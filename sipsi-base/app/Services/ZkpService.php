<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ZkpService
{
    /**
     * Verify identity hash with ZKP backend
     */
    public function verifyIdentityHash($userId, $nik, $nama, $ttl, $key)
    {
        try {
            $client = new Client();
            $response = $client->post(rtrim(env('ZKP_BACKEND_URL'), '/') . '/verify', [
                'json' => [
                    'userId' => $userId,
                    'nik' => $nik,
                    'nama' => $nama,
                    'ttl' => $ttl,
                    'key' => $key
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            Log::info('Verify Identity API Response:', [
                'userId' => $userId,
                'response' => $data,
                'raw_response' => $response->getBody()->getContents()
            ]);
            return $data;
        } catch (\Exception $e) {
            Log::error('Identity verification failed: ' . $e->getMessage());
            throw new \Exception('Failed to verify identity: ' . $e->getMessage());
        }
    }

    /**
     * Submit hash to blockchain via ZKP backend
     */
    public function submitHashToBlockchain($userId, $nik, $nama, $ttl, $key)
    {
        try {
            $client = new Client();
            $response = $client->post(env('ZKP_BACKEND_URL') . '/submit-hash', [
                'json' => [
                    'userId' => $userId,
                    'nik' => $nik,
                    'nama' => $nama,
                    'ttl' => $ttl,
                    'key' => $key
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            Log::info('Submit Hash API Response:', [
                'userId' => $userId,
                'response' => $data,
                'raw_response' => $response->getBody()->getContents()
            ]);
            
            return $data;
        } catch (\Exception $e) {
            Log::error('Hash submission failed: ' . $e->getMessage());
            throw new \Exception('Failed to submit hash: ' . $e->getMessage());
        }
    }

    /**
     * Check if a user's identity is approved in the ZKP system
     */
    public function isApproved($userId)
    {
        try {
            $client = new Client();
            $response = $client->get(env('ZKP_BACKEND_URL') . '/is-approved/' . $userId);
            $data = json_decode($response->getBody(), true);

            Log::info('Is Approved API Response:', [
                'userId' => $userId,
                'response' => $data,
                'raw_response' => $response->getBody()->getContents()
            ]);

            // Check if response has the expected structure
            if (!is_array($data)) {
                throw new \Exception('Invalid response format: not an array');
            }

            if (!isset($data['approved'])) {
                throw new \Exception('Invalid response format: missing approved field');
            }

            return $data['approved'];
        } catch (\Exception $e) {
            throw new \Exception('Failed to check approval status: ' . $e->getMessage());
        }
    }

    /**
     * Approve a user in the ZKP system
     */
    public function approveUser($userId) 
    {
        try {
            // Panggil backend approve jika belum approved
            $client = new Client();
            $response = $client->post(env('ZKP_BACKEND_URL') . '/approve', [
                'json' => [
                    'userId' => $userId
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            Log::info('Approve User API Response:', [
                'userId' => $userId,
                'response' => $data
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('User approval failed: ' . $e->getMessage(), [
                'userId' => $userId,
            ]);
            throw new \Exception('Failed to approve user: ' . $e->getMessage());
        }
    }


} 