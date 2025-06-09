<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailValidationService
{
    public function validate(string $email): bool
    {
        try {
            $response = Http::get('http://apilayer.net/api/check', [
                'access_key' => config('services.mailboxlayer.key'),
                'email' => $email,
                'smtp' => 1,
                'format' => 1
            ]);

            if ($response->ok()) {
                $result = $response->json();
                
                // Log the response for debugging
                Log::info('MailboxLayer API Response', [
                    'email' => $email,
                    'response' => $result
                ]);

                // Check if the required keys exist
                if (!isset($result['format_valid']) || !isset($result['smtp_check'])) {
                    Log::error('MailboxLayer API missing required keys', [
                        'email' => $email,
                        'response' => $result
                    ]);
                    return false;
                }
                   sleep(2);
                
                return $result['format_valid'] && $result['smtp_check'];
            }

            // Log error if response is not OK
            Log::error('MailboxLayer API error', [
                'email' => $email,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('MailboxLayer API exception', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}