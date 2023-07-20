<?php
namespace Tests;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../infrastructure/login/CreateLoginPDO.php';
require_once __DIR__ . '/../infrastructure/login/useCasesLogin.php';
require_once __DIR__ . '/../infrastructure/login/Login.php';
require_once __DIR__ . '/../infrastructure/login/LoginRepository.php';
require_once __DIR__ . '/../infrastructure/login/LoginService.php';

use Tests\Support\UnitTester;

date_default_timezone_set('America/Sao_Paulo');

class LoginCest
{
    public function _before(UnitTester $I) {
        (\Database::getInstance('test'))->eraseTestDatabase();
    }

    public function createLogin(UnitTester $I)
    {
        $input = new \CreateLoginPDO('John Doe', 'johndoe@email.com', 'senhacontajonhdoe');
        $login = (new \CreateLogin())->execute($input);
        $I->assertEquals($login->name, $input->name);

        return $login;
    }

    public function authenticateLogin(UnitTester $I)
    {
        $login = $this->createLogin($I);
        $loginAutenticaded = (new \LoginAutentication())->execute($login->email, 'senhacontajonhdoe');
        $I->assertEquals($loginAutenticaded->name, $login->name);

        try {
            (new \LoginAutentication())->execute($login->email, 'senhacontajonhdoe2');
        } catch (\Throwable $th) {
            $I->assertEquals($th->getMessage(), 'Password invalid');
        }

        try {
            (new \LoginAutentication())->execute($login->email);
        } catch (\Throwable $th) {
            $I->assertEquals($th->getMessage(), 'Login not found');
        }

        try {
            (new \LoginAutentication())->execute($login->email, null, 'tokeninvalido');
        } catch (\Throwable $th) {
            $I->assertEquals($th->getMessage(), 'Login not found');
        }

        $loginAutenticadedWithToken = (new \LoginAutentication())->execute($login->email, null, $login->token);
        $I->assertEquals($loginAutenticadedWithToken->name, $login->name);


        $pdo = \Database::getInstance()->getDb();
        $pdo->exec("UPDATE login SET token_expiration_time = now() + '-3 hour' WHERE id = '$login->id' ");
        try {
            (new \LoginAutentication())->execute($login->email, null, $login->token);
        } catch (\Throwable $th) {
            $I->assertEquals($th->getMessage(), 'Token expired');
        }

    }


}
