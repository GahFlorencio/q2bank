<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentGateway
{
    public static function capture():bool
    {
        try{
            $result = Http::get('https://run.mocky.io/v3/d02168c6-d88d-4ff2-aac6-9e9eb3425e31');

            if (empty($result)) {
                return false;
            }

            if ($result->status() !== 200) {
                return false;
            }

            $result->json();

            if (empty($result['authorization'])) {
                return false;
            }

            return (bool)$result['authorization'];

        }catch (\Exception $exception){
            Log::info('[Services][Payment][PaymentGateway][Capture] Error: '.$exception);
            return false;
        }

    }
}
