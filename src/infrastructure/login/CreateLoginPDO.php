<?php

class CreateLoginPDO {
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}