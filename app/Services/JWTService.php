<?php

namespace App\Services;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWTService
{
    private $key;
    public function __construct($key)
    {
        
        $this->key = $key;
    }

    public function encode($payload)
    {
        if ($this->key === null) {
            throw new \Exception('JWT secret key is not set.');
        }

        return FirebaseJWT::encode($payload, $this->key, 'HS256');
    }

    public function decode($token)
    {
        if ($this->key === null) {
            throw new \Exception('JWT secret key is not set.');
        }
        return FirebaseJWT::decode($token, new Key($this->key, 'HS256'));
    }
}
