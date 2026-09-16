<?php

namespace App\Services;

use Kreait\Firebase\Factory;


class FirebaseService
{
    protected $database;

    public function __construct()
    {

        $factory = (new Factory)->withServiceAccount(base_path(config('services.firebase.credentials')))->withDatabaseUri(config('services.firebase.database_url'));

        $this->database = $factory->createDatabase();
    }

    public function database()
    {
        return $this->database;
    }
}
