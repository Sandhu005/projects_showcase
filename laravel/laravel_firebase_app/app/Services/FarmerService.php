<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class FarmerService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected FirebaseService $firebase)
    {
        //
    }

    public function index()
    {
        return $this->firebase->database()->getReference('farmers')->orderByKey()->limitToFirst(10)->getValue();
    }

    public function show(string $id)
    {
        $farmer = $this->firebase->database()->getReference('farmers/' . $id)->getValue();

        if (!$farmer) {
            return null;
        }

        //Checking if account is being deleted
        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        return $farmer;
    }

    public function createPhoneFarmer(string $phone)
    {
        $database = $this->firebase->database();

        // Get next ID
        $counter = $database
            ->getReference('farmer_counter')
            ->getValue();

        $counter = ($counter ?? 0) + 1;

        // Save counter
        $database
            ->getReference('farmer_counter')
            ->set($counter);

        // Create farmer ID
        $id = 'farmer_' . str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Farmer data
        $farmer = [
            'id'          => $id,
            'phone'       => $phone,
            'phone_verified' => false,
            'email' => null,
            'email_verified' => false,
            'google_id' => null,
            'online'      => false,
            'status'      => 'pending',
            'created_at'  => now()->toIso8601String(),
        ];

        // Save farmer
        $database
            ->getReference('farmers/' . $id)
            ->set($farmer);

        return $id;
    }

    public function createGoogleFarmer(string $email, string $googleId)
    {
        $database = $this->firebase->database();

        // Get next ID
        $counter = $database
            ->getReference('farmer_counter')
            ->getValue();

        $counter = ($counter ?? 0) + 1;

        // Save counter
        $database
            ->getReference('farmer_counter')
            ->set($counter);

        // Create farmer ID
        $id = 'farmer_' . str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Farmer data
        $farmer = [
            'id'          => $id,
            'phone' => null,
            'phone_verified' => false,
            'email'       => $email,
            'email_verified' => true,
            'google_id'  => $googleId,
            'online'      => true,
            'status'      => 'active',
            'created_at'  => now()->toIso8601String(),
        ];

        // Save farmer
        $database
            ->getReference('farmers/' . $id)
            ->set($farmer);

        return $id;
    }

    public function update(string $id, array $data)
    {
        return $this->firebase->database()->getReference('farmers/' . $id)->update($data);
    }

    public function destroy(string $farmerId)
    {
        $this->firebase->database()->getReference('farmers/' . $farmerId)->remove();
    }

    public function findByPhone(string $phone)
    {
        $farmers = $this->firebase
            ->database()
            ->getReference('farmers')
            ->orderByChild('phone')
            ->equalTo($phone)
            ->getValue();

        if (!$farmers) {
            return null;
        }

        //Checking if account is being deleted
        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        // Return the first farmer found
        return reset($farmers);
    }

    public function findByEmail(string $email)
    {
        $farmers = $this->firebase
            ->database()
            ->getReference('farmers')
            ->orderByChild('email')
            ->equalTo($email)
            ->getValue();

        if (!$farmers) {
            return null;
        }

        //Checking if account is being deleted
        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        // Return the first farmer found
        return reset($farmers);
    }

    public function findByGoogleId(string $googleId)
    {
        $farmers = $this->firebase
            ->database()
            ->getReference('farmers')
            ->orderByChild('google_id')
            ->equalTo($googleId)
            ->getValue();

        if (!$farmers) {
            return null;
        }

        //Checking if account is being deleted
        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        return reset($farmers);
    }

    public function updateLocation(string $farmerId, array $location): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}/location")
            ->update($location);
    }

    public function updateSettings(string $farmerId, array $settings): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update($settings);
    }

    public function softDelete(string $farmerId): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update([
                'status' => 'deleted',
                'deleted_at' => now()->toIso8601String(),
            ]);
    }

    public function markPhoneVerified(string $farmerId): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update([
                'phone_verified' => true,
                'status' => 'active',
                'updated_at' => now()->toIso8601String(),
            ]);
    }

    public function markEmailVerified(string $farmerId): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update([
                'email_verified' => true,
                'status' => 'active',
                'updated_at' => now()->toIso8601String(),
            ]);
    }

    public function linkGoogleAccount(string $farmerId, string $googleId, string $email): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update([
                'google_id' => $googleId,
                'email' => $email,
                'email_verified' => true,
                'status' => 'active',
                'updated_at' => now()->toIso8601String(),
            ]);
    }

    public function updateOnlineStatus(string $farmerId, bool $isOnline): void
    {
        $this->firebase
            ->database()
            ->getReference("farmers/{$farmerId}")
            ->update([
                'online' => $isOnline,
                'updated_at' => now()->toIso8601String(),
            ]);
    }

    public function getLocation(string $farmerID)
    {
        return $this->firebase
            ->database()
            ->getReference("farmers/{$farmerID}/location")
            ->getValue();
    }
}
