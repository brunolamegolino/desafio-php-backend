<?php

class Login {
    
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $token='',
        public string $token_expiration_time='',
        public string $id='', // to not use name nether email as identifier
        public string $created_at='',
    ) {}

    public static function create($name, $email, $password) : Login
    {
        return new Login(
            $name,
            $email,
            $password,
            bin2hex(random_bytes(32))
        );
    }
}