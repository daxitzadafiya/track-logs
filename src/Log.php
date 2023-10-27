<?php

namespace Logavel\TrackLogs;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Log
{
    protected static $base_url = 'http://127.0.0.1:5000';

    public static function log($message)
    {
        try {
            $httpClient = new Client();
            $user_details = Auth::check() ? Auth::user()->toArray() : Null;

            $data = [
                'description' => $message,
                'user_details' => isset($user_details) && !empty($user_details) ? json_encode($user_details) : Null,
                'type' => 'PHP'
            ];

            $response = $httpClient->post(self::$base_url."/logs", [
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
