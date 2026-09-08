<?php

namespace App\Services;

use App\Models\Pemohon;
use App\Models\User;
use App\Models\UserInternal;
use App\Notifications\ChangeEmailNotification;
use Constant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Roles;

class AuthService
{
    public function register($request)
    {

        try {
            DB::beginTransaction();

            //trim email remove space
            $email = $request['email'];
            //replace space with empty string
            $email = str_replace(' ', '', $email);
            // Create the user
            $user = User::create([
                'name' => $request['name'],
                'email' => $email,
                'username' => $email,
                'password' => bcrypt(saltPassword($request['password'])),
            ]);

            // Create pemohon
            Pemohon::create([
                'nama' => $request['name'],
                'alamat' => $request['alamat'],
                'no_hp' => $request['no_hp'],
                'email' => $email,
                'jenis_identitas' => $request['jenis_identitas'],
                'nomor_identitas' => $request['nomor_identitas'],
                'jenis_pemohon' => $request['jenis_pemohon'],
                'id_user' => $user->id,
                'created_by' => $user->id,
                'kewarganegaraan' => 'WNI', //karena not null
                'jenis_kelamin' => $request['jenis_kelamin'],
            ]);

            $user->assignRole(Roles::ROLE_PEMOHON);

            DB::commit();

            // Trigger email verification
            Log::info('Email verification link sent to '.$email);
            event(new Registered($user));

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_EMAIL_MESSAGE,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ];
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     Log::error($e->getMessage());

        //     return [
        //         'success' => false,
        //         'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
        //         'http_code' => Constant::HTTP_CODE_ERROR,
        //     ];
        // }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'http_code' => Constant::HTTP_CODE_ERROR,
            ];
        }
    }

    public function changeEmail($request)
    {
        $oldEmail = $request['old_email'];
        $newEmail = $request['new_email'];

        //check if old email is valid
        $user = User::where('email', $oldEmail)->where('id', Auth::user()->id)->firstOrFail();

        try {
            DB::beginTransaction();

            $token = Str::random(60);
            $user->email_verification_token = $token;
            $user->save();

            $user->notify(new ChangeEmailNotification($token, $newEmail));

            DB::commit();

            return [
                'success' => true,
                'message' => 'Konfirmasi perubahan alamat email telah dikirim ke '.$oldEmail,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ];
        } catch (\Exception $e) {
            //log
            Log::error($e->getMessage());
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function confirmChangeEmail($request)
    {
        $token = $request['token'];
        $newEmail = $request['new_email'];

        $user = User::where('email_verification_token', $token)->first();

        if (! $user) {
            return redirect('/login')->withErrors('Invalid verification link. Please request a new one.');
        }

        try {
            DB::beginTransaction();

            $user->email = $newEmail;
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            //check if user is pemohon
            $pemohon = Pemohon::where('id_user', $user->id)->first();
            if ($pemohon) {
                $pemohon->email = $newEmail;
                $pemohon->save();
            }

            //check if user is internal
            $userInternal = UserInternal::where('id_user', $user->id)->first();
            if ($userInternal) {
                $userInternal->email = $newEmail;
                $userInternal->save();
            }

            DB::commit();

            return redirect('/login')->with('message', 'Email berhasil diubah');
        } catch (\Exception $e) {
            //log
            Log::error($e->getMessage());

            DB::rollBack();

            return redirect('/login')->withErrors('Gagal mengubah email');
        }
    }

    public function changePassword($request)
    {
        $user = User::where('id', Auth::user()->id)->firstOrFail();

        //check if old password is valid with bycrypt
        if (! password_verify(saltPassword($request['old_password']), $user->password)) {
            return [
                'success' => false,
                'message' => 'Password lama tidak valid',
                'http_code' => Constant::HTTP_CODE_ERROR,
            ];
        }

        //update password
        $user->password = bcrypt(saltPassword($request['new_password']));
        $user->save();

        return [
            'success' => true,
            'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
            'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
        ];
    }

    public function user()
    {
        //get user data with relation to userPemohon and userInternal
        $user = User::where('id', Auth::user()->id)->with('userPemohon', 'userInternal')->firstOrFail();

        return [
            'success' => true,
            'data' => $user,
            'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
        ];
    }

    public function updateUser($request)
    {
        $user = UserInternal::where('id_user', Auth::user()->id)
            ->with('user')
            ->firstOrFail();
        try {
            DB::beginTransaction();

            $user->update([
                'no_hp' => $request['no_hp'],
                'nomor_identitas' => $request['nomor_identitas'],
                'alamat' => $request['alamat'],
                'nama' => $request['name'],
                'tanggal_lahir' => $request['tanggal_lahir'],
                'jenis_kelamin' => $request['jenis_kelamin'],
            ]);

            $user->user->update([
                'name' => $request['name'],
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => Constant::HTTP_CODE_SUCCESS_ENTRY_MESSAGE,
                'data' => $user,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }
}
