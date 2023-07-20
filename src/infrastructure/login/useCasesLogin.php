<?php

class CreateLogin {

    public function __construct(
        private LoginRepository $loginRepository = new LoginRepository(),
    ) {}

    public function execute(CreateLoginPDO $input) : Login
    {
        $login = Login::create($input->name, $input->email, \LoginService::encryptPassword($input->password));
        return $this->loginRepository->save($login);
    }
}


class LoginAutentication {
    
        public function __construct(
            private LoginRepository $loginRepository = new LoginRepository(),
        ) {}
    
        public function execute(string $email, string $passwor=null, string $token=null) : Login
        {
            try {
                $login = $passwor
                    ? $this->loginRepository->find('email', $email)
                    : $this->loginRepository->find('token', $token);
            } catch (\Throwable $th) {
                throw new Exception('Login not found');
            }

            if ($passwor && !\LoginService::comparePassword($passwor, $login->password)) {
                throw new Exception('Password invalid');
            }

            if ($token && date('Y-m-d H:i:s') > $login->token_expiration_time) {
                throw new Exception('Token expired');
            }

            $this->loginRepository->updateExpirationTokenTime($login->id);
            return $login;
        }
    
}
