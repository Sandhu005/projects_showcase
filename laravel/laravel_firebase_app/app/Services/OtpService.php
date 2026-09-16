<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class OtpService
{
    public function generate(string $phone, string $farmerId): array
    {
        $key = 'otp:' . $phone;

        //Allow a maximum of 3 OTP requests per minute for the same phone number
        $maxAttempts = 3;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw new HttpResponseException(
                response()->json([
                    'error' => 'too_many_requests',
                    'retry_after' => RateLimiter::availableIn($key),
                ], 429)
            );
        }

        RateLimiter::hit($key, $decaySeconds);

        //Generate a 6-digit OTP and a unique OTP ID
        $otp = (string) random_int(100000, 999999);
        $optId = 'otp_' . Str::random(12);

        // Delete any existing unverified OTPs for the same phone number
        OtpVerification::where('phone', $phone)
            ->whereNull('verified_at')
            ->delete();

        // Store new OTP details in the database
        OtpVerification::create([
            'otp_id' => $optId,
            'farmer_id' => $farmerId,
            'phone' => $phone,
            'otp_hash' => Hash::make($otp),
            'attempts' => 0,
            'expires_at' => now()->addSeconds(30),
        ]);

        return [
            'otp_id' => $optId,
            'otp' => $otp,
            'expires_in' => 30,
            'resend_after' => 24,
        ];
    }

    public function verify(string $otpId, string $code): array
    {
        $record = OtpVerification::where('otp_id', $otpId)
            ->whereNull('verified_at')
            ->first();

        if (!$record) {
            return [
                'success' => false,
                'error' => 'invalid_code',
                'attempts_remaining' => 0,
            ];
        }

        if ($record->expires_at->isPast()) {
            return [
                'success' => false,
                'error' => 'otp_expired',
                'attempts_remaining' => 0,
            ];
        }

        if ($record->attempts >= 3) {
            return [
                'success' => false,
                'error' => 'otp_locked',
                'attempts_remaining' => 0,
            ];
        }

        if (!Hash::check($code, $record->otp_hash)) {

            $record->increment('attempts');

            $remaining = max(
                0,
                3 - $record->attempts
            );

            return [
                'success' => false,
                'error' => 'invalid_code',
                'attempts_remaining' => $remaining,
            ];
        }

        $record->update([
            'verified_at' => now(),
        ]);

        return [
            'success' => true,
            'phone' => $record->phone,
            'farmer_id' => $record->farmer_id,
        ];
    }
}
