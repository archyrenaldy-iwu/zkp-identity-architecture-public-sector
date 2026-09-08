<?php

namespace App\Services;

use App\Models\KiConfig;
use App\Models\User;
use App\Models\UserInternal;
use Constant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Roles;

class UserInternalService
{
    public function create($request)
    {
        if (in_array(Roles::ROLE_SUPERADMIN, $request['roles'])) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        //check KI
        KiConfig::findOrFail($request['id_ki']);

        try {

            DB::beginTransaction();

            //trim email remove space
            $email = $request['email'];
            //replace space with empty string
            $email = str_replace(' ', '', $email);

            $user = User::create([
                'name' => $request['name'],
                'email' => $email,
                'password' => bcrypt(saltPassword($request['password'])),
                'username' => $email,
            ]);

            //assign role
            foreach ($request['roles'] as $role) {
                $user->assignRole($role);
            }

            UserInternal::create([
                'id_user' => $user['id'],
                'nama' => $request['name'],
                'alamat' => $request['alamat'],
                'no_hp' => $request['no_hp'],
                'email' => $email,
                'jenis_identitas' => $request['jenis_identitas'],
                'nomor_identitas' => $request['nomor_identitas'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'id_ki' => $request['id_ki'],
                'tanggal_lahir' => $request['tanggal_lahir'] ?? null,
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

    public function list()
    {
        $query = UserInternal::with('user.roles', 'ki')->whereNull('deleted_at')
            ->where('id_user', '!=', 1)
            ->where('id_user', '!=', 2)
            ->get();

        $transformedData = $query->map(function ($item) {
            return [
                'id' => $item->id,
                'id_user' => $item->id_user,
                'nama' => $item->nama,
                'alamat' => $item->alamat,
                'no_telp' => $item->no_telp,
                'no_hp' => $item->no_hp,
                'email' => $item->email,
                'tanggal_lahir' => $item->tanggal_lahir,
                'jenis_identitas' => $item->jenis_identitas,
                'nomor_identitas' => $item->nomor_identitas,
                'jenis_kelamin' => $item->jenis_kelamin,
                'id_ki' => $item->id_ki,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
                'roles' => implode(', ', $item->user->roles->pluck('description')->toArray()),
                'ki' => $item->ki->nama,
            ];
        });

        return datatables()->of($transformedData)->make(true);
    }

    public function show($id)
    {
        $user = UserInternal::where('id_user', $id)->with('user.roles', 'ki')->firstOrFail();
        $response = [
            'success' => true,
            'data' => $user,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];

        return $response;
    }

    public function update($request, $id)
    {
        $user = UserInternal::where('id_user', $id)
            ->where('id_user', '!=', 1)
            ->with('user')
            ->firstOrFail();

        if (in_array(Roles::ROLE_SUPERADMIN, $request['roles'])) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        try {
            DB::beginTransaction();

            //trim email remove space
            $email = $request['email'];
            //replace space with empty string
            $email = str_replace(' ', '', $email);

            $user->update([
                'nama' => $request['name'],
                'alamat' => $request['alamat'],
                'no_hp' => $request['no_hp'],
                'email' => $email,
                'jenis_identitas' => $request['jenis_identitas'],
                'nomor_identitas' => $request['nomor_identitas'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'id_ki' => $request['id_ki'],
                //update if password not empty
                'password' => $request['password'] ? bcrypt(
                    saltPassword($request['password'])) : $user->password,
                'tanggal_lahir' => $request['tanggal_lahir'] ?? $user->tanggal_lahir,
            ]);

            $user->user->update([
                'name' => $request['name'],
                'email' => $email,
            ]);

            //remove all role
            $user->user->roles()->detach();

            //assign role
            foreach ($request['roles'] as $role) {
                $user->user->assignRole($role);
            }

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

    public function destroy($id)
    {
        $user = UserInternal::where('id_user', $id)->with('user')->firstOrFail();
        try {
            DB::beginTransaction();
            $user->user->delete();
            $user->delete();
            DB::commit();

            return [
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'http_code' => Constant::HTTP_CODE_SUCCESS,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            //log
            Log::error($th);

            return [
                'success' => false,
                'message' => 'Gagal menghapus data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }
}
