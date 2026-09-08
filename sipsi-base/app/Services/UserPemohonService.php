<?php

namespace App\Services;

use App\Models\Pemohon;
use App\Models\User;
use Constant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Roles;

class UserPemohonService
{
    public function create($request)
    {
        try {
            DB::beginTransaction();

            //trim email remove space
            $email = $request['email'];
            //replace space with empty string
            $email = str_replace(' ', '', $email);

            $user = User::create([
                'name' => $request['name'],
                'email' => $email,
                //random password
                'password' => bcrypt(Str::random(15)),
                'username' => $email,
            ]);

            $user->assignRole(Roles::ROLE_PEMOHON);

            $pemohon = Pemohon::create([
                'id_user' => $user->id,
                'nama' => $request['name'],
                'alamat' => $request['alamat'],
                'no_hp' => $request['no_hp'],
                'email' => $email,
                'jenis_identitas' => $request['jenis_identitas'],
                'nomor_identitas' => $request['nomor_identitas'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'jenis_pemohon' => $request['jenis_pemohon'],
                'tanggal_lahir' => $request['tanggal_lahir'] ?? null,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'User created successfully',
                'data' => $pemohon,
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return [
                'success' => false,
                'message' => 'Failed to create user',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function list()
    {
        $query = Pemohon::with('user.roles')->where('id_user', '!=', null)->whereNull('deleted_at')->get();

        $transformedData = $query->map(
            function ($item) {
                return [
                    'id' => $item->id,
                    'id_user' => $item->id_user,
                    'nama' => $item->nama,
                    'email' => $item->email,
                    'no_hp' => $item->no_hp,
                    'alamat' => $item->alamat,
                    'nomor_identitas' => $item->nomor_identitas,
                    'jenis_pemohon' => $item->jenis_pemohon,
                    'jenis_identitas' => $item->jenis_identitas,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'roles' => implode(', ', $item->user->roles->pluck('description')->toArray()),
                ];
            }
        );

        return datatables()->of($transformedData)->make(true);
    }

    public function show($id)
    {
        $user = Pemohon::where('id_user', $id)->with('user')->firstOrFail();
        $response = [
            'success' => true,
            'data' => $user,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ];

        return $response;
    }

    public function update($request, $id)
    {
        $user = Pemohon::where('id_user', $id)->with('user')->firstOrFail();
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
                'jenis_pemohon' => $request['jenis_pemohon'],
                //update if password not empty
                'password' => isset($request['password']) && $request['password'] ? bcrypt(
                    saltPassword($request['password'])) : $user->password,
                'tanggal_lahir' => $request['tanggal_lahir'] ?? $user->tanggal_lahir,
            ]);

            $user->user->update([
                'name' => $request['name'],
                'email' => $email,
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
            Log::error($e);

            return [
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ];
        }
    }

    public function destroy($id)
    {
        $user = Pemohon::where('id_user', $id)->with('user')->firstOrFail();
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
