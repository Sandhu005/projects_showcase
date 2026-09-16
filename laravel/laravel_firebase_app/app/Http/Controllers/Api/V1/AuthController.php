<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\FarmerOtpRequest;
use App\Http\Requests\Api\Auth\FarmerOtpVerifyRequest;
use App\Http\Requests\Api\Auth\RefreshTokenRequest;
use App\Models\Farmer;
use App\Models\Guest;
use App\Services\FarmerService;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        protected OtpService $otpService,
        protected FarmerService $farmerService
    ) {}

    public function generateTokens(Farmer $farmer)
    {
        $accessToken = JWTAuth::fromUser($farmer);

        return response()->json([
            'access_token' => $accessToken,
            'expires_in' => config('jwt.ttl') * 60,
            'farmer_id' => $farmer->id,
        ]);
    }

    public function refresh(RefreshTokenRequest $request)
    {
        $newAccessToken = JWTAuth::setToken($request->validated('refresh_token'))->refresh();

        return response()->json([
            'access_token' => $request->validated('refresh_token'),
            'refresh_token' => $newAccessToken,
            'expires_in' => config('jwt.ttl') * 60,
        ]);
    }

    public function guest()
    {
        $guestId = 'guest_' . Str::uuid();

        $guest = new Guest($guestId);

        $accessToken = JWTAuth::fromUser($guest);

        return response()->json([
            'access_token' => $accessToken,
            'guest_id' => $guestId,
            'expires_in' => config('jwt.ttl') * 60,
        ]);
    }

    public function sendotp(FarmerOtpRequest $request)
    {
        $phone = $request->validated('phone');

        $farmer = $this->farmerService->findByPhone($phone);

        if (!$farmer) {
            $farmerId = $this->farmerService->createPhoneFarmer($phone);

            $farmer = [
                'id' => $farmerId,
                'phone' => $phone,
                'phone_verified' => false,
                'status' => 'pending',
            ];
        }

        if (($farmer['status'] ?? 'active') === 'deleted') {
            return response()->json([
                'error' => 'account_deleted',
                'message' => 'This account has been deleted.',
            ], 403);
        }

        if (($farmer['phone_verified'] ?? true) === false) {
            return response()->json([
                'error' => 'phone_not_verified',
                'message' => 'An account with this phone number already exists, but the phone number is not verified.',
            ], 403);
        }

        $otp = $this->otpService->generate($phone, $farmer['id']);

        return response()->json([
            'message' => 'OTP sent successfully.',
            'otp_id' => $otp['otp_id'],
            'farmer_id' => $farmer['id'],
            'expires_in' => $otp['expires_in'],
            'resend_after' => $otp['resend_after'],
            'otp' => $otp['otp'],
        ]);
    }

    public function verifyOtp(FarmerOtpVerifyRequest $request)
    {
        $verified = $this->otpService->verify($request->validated('otp_id'), $request->validated('otp'));

        if (!$verified['success']) {

            if ($verified['error'] === 'otp_locked') {
                return response()->json([
                    'error' => 'otp_locked',
                    'message' => 'OTP attempts exceeded. Request a new OTP.',
                ], 423);
            }

            return response()->json([
                'error' => $verified['error'],
                'attempts_remaining' => $verified['attempts_remaining'],
            ], 401);
        }

        $farmerId = $verified['farmer_id'];

        $this->farmerService->markPhoneVerified($farmerId);
        $this->farmerService->updateOnlineStatus($farmerId, true);

        $farmer = new \App\Models\Farmer($farmerId);

        return $this->generateTokens($farmer);
    }

    public function logout(Request $request)
    {
        JWTAuth::parseToken()->invalidate();

        $this->farmerService->updateOnlineStatus(auth('api')->id(), false);

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();

        // Check if farmer exists with Google ID
        $farmer = $this->farmerService->findByGoogleId($googleId);

        if ($farmer) {

            // Deleted account
            if (($farmer['status'] ?? null) === 'deleted') {
                return response()->json([
                    'error' => 'account_deleted',
                    'message' => 'This account has been deleted.',
                ], 403);
            }

            $farmerId = $farmer['id'];

            $farmerModel = new Farmer($farmerId);

            $this->farmerService->updateOnlineStatus($farmerId, true);

            return $this->generateTokens($farmerModel);
        }

        // Find farmer by email
        $farmer = $this->farmerService->findByEmail($email);

        if ($farmer) {

            // Deleted account
            if (($farmer['status'] ?? null) === 'deleted') {
                return response()->json([
                    'error' => 'account_deleted',
                    'message' => 'This account has been deleted.',
                ], 403);
            }

            // Farmer found by email → check if email is verified
            if (($farmer['email_verified'] ?? false) === true) {

                $this->farmerService->linkGoogleAccount(
                    $farmer['id'],
                    $googleId,
                    $email
                );

                $farmerModel = new Farmer($farmer['id']);

                $this->farmerService->updateOnlineStatus($farmer['id'], true);

                return $this->generateTokens($farmerModel);
            }

            //  Email not verified → return error
            return response()->json([
                'error' => 'email_not_verified',
                'message' => 'An account with this email already exists, but the email is not verified.',
            ], 409);
        }

        // NO Farmer FOUND → Create a new farmer with Google ID and email
        $farmerId = $this->farmerService->createGoogleFarmer(
            $googleId,
            $email
        );

        $farmerModel = new Farmer($farmerId);

        return $this->generateTokens($farmerModel);
    }
}
