<?php

namespace Logavel\TrackLogs;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Log
{
    
    public static function log($message)
    {
        try {
            $config = require_once __DIR__.'../config.php';
            $base_url = $config['HOST_URL'];
            $httpClient = new Client();
            $user_details = Auth::check() ? Auth::user()->toArray() : Null;

            $data = [
                'description' => $message,
                'user_details' => isset($user_details) && !empty($user_details) ? json_encode($user_details) : Null,
                'type' => 'PHP'
            ];

            $response = $httpClient->post($base_url."/logs", [
                'json' => $data,
            ]);

            if ($response->getStatusCode() === 200) {
                $response->getBody()->getContents();
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
