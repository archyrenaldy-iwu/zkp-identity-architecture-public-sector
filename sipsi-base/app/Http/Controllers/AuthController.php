<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\InformasiAkunUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\PasswordResetSuccess;
use App\Services\AuthService;
use Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Roles;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        // Validasi input termasuk reCAPTCHA
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        // Jika validasi gagal, kembalikan respons dengan kesalahan
        if ($validator->fails()) {
            return responseJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ]);
        }
        //add password with salt
        $request->merge(['password' => saltPassword($request->password)]);

        $credentials = $request->only('username', 'password');

        //user can login with email if username field is email
        if (filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        // Coba otentikasi pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $default_role = $user->getRoleNames()->first();
            $request->session()->put(Constant::SESSION_ACTIVE_ROLE, $default_role);

            if ($default_role != Roles::ROLE_PEMOHON) {
                $ki = $user->userInternal;
                $request->session()->put(Constant::SESSION_ACTIVE_ID_KI, $ki->id_ki);
            }

            // Kembalikan respons dengan token dan informasi pengguna
            return responseJson([
                'success' => true,
                'message' => 'Login successful',
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ]);
        }

        // Jika otentikasi gagal
        return responseJson([
            'success' => false,
            'message' => 'Username or password is incorrect.',
            'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
        ]);
    }

    //delete soon
    public function loginWithoutCaptcha(Request $request)
    {
        //validation tanpa recaptcha
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan respons dengan kesalahan
        if ($validator->fails()) {
            return responseJson([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ]);
        }

        //add password with salt
        $request->merge(['password' => saltPassword($request->password)]);

        $credentials = $request->only('username', 'password');

        //user can login with email if username field is email
        if (filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        // Coba otentikasi pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $default_role = $user->getRoleNames()->first();
            $request->session()->put(Constant::SESSION_ACTIVE_ROLE, $default_role);

            if ($default_role != Roles::ROLE_PEMOHON) {
                $ki = $user->userInternal;
                $request->session()->put(Constant::SESSION_ACTIVE_ID_KI, $ki->id_ki);
            }

            // Kembalikan respons dengan token dan informasi pengguna
            return responseJson([
                'success' => true,
                'message' => 'Login successful',
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ]);
        }

        // Jika otentikasi gagal
        return responseJson([
            'success' => false,
            'message' => 'Username or password is incorrect.',
            'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->register($request->all()));
        }
    }

    public function resendVerif(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return responseJson([
                'success' => false,
                'message' => Constant::HTTP_CODE_SUCCESS_EMAIL_VERIFIED_MESSAGE,
                'http_code' => 400,
            ]);
        }

        $user->sendEmailVerificationNotification();

        return responseJson([
            'success' => true,
            'message' => Constant::HTTP_CODE_SUCCESS_EMAIL_RESEND_MESSAGE,
            'http_code' => 200,
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return responseJson([
            'success' => true,
            'message' => 'Logged out successfully',
            'http_code' => 200,
        ]);
    }

    //reset password
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ]);
        }

        //find user by email or username or no_hp or nomor_identitas
        $user = User::where('email', $request->data)
            ->orWhere('username', $request->data)
            ->orWhereHas('pemohon', function ($query) use ($request) {
                $query->where('no_hp', $request->data)
                    ->orWhere('nomor_identitas', $request->data);
            })
            ->first();

        if (! $user) {
            return responseJson([
                'success' => false,
                'message' => 'User not found',
                'http_code' => Constant::HTTP_CODE_ERROR_NOT_FOUND,
            ]);
        }

        $status = Password::sendResetLink(
            ['email' => $user->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? responseJson([
                'success' => true,
                'message' => __($status),
                'data' => [
                    'email' => $user->email,
                    'name' => $user->name,
                ],
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ])
            : responseJson([
                'success' => false,
                'message' => __($status),
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/', // must contain at least one special character
            ],
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return responseJson([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'http_code' => Constant::HTTP_CODE_UNPROCESSABLE_ENTITY,
            ]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt(saltPassword($password)),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->notify(new PasswordResetSuccess());
            }
        );

        return $status === Password::PASSWORD_RESET
            ? responseJson([
                'success' => true,
                'message' => __($status),
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ])
            : responseJson([
                'success' => false,
                'message' => __($status),
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ]);
    }

    public function switchRole(Request $request)
    {
        if (Auth::user()->hasRole($request->role)) {
            $request->session()->put(Constant::SESSION_ACTIVE_ROLE, $request->role);

            if ($request->role != Roles::ROLE_PEMOHON) {
                $ki = Auth::user()->userInternal;
                $request->session()->put(Constant::SESSION_ACTIVE_ID_KI, $ki->id_ki);
            }

            return responseJson([
                'success' => true,
                'message' => 'Berhasil mengganti role',
                'data' => ['active_role' => getActiveRole()],
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ]);
        }

        return responseJson([
            'success' => false,
            'message' => 'Gagal mengganti role. Anda tidak memiliki role tersebut',
            'http_code' => Constant::HTTP_CODE_ERROR_NOT_FOUND,
        ]);
    }

    public function changeEmail(ChangeEmailRequest $request)
    {

        if ($request->ajax()) {
            return responseJson($this->service->changeEmail($request->all()));
        }
    }

    public function confirmChangeEmail(Request $request)
    {
        return $this->service->confirmChangeEmail($request->all());
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->changePassword($request->all()));
        }
    }

    public function user()
    {
        return responseJson($this->service->user());
    }

    public function updateUser(InformasiAkunUpdateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->updateUser($request->all()));
        }
    }
}
