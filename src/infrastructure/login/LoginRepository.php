<?php

class LoginRepository {

    public function __construct(
        private PDO|null $pdo = null,
    ) {
        $this->pdo = \Database::getInstance()->getDb();
    }

    public function save(Login $login) {
        $query = $this->pdo->query(
            "INSERT INTO login (name, email, password, token)
            VALUES ('$login->name', '$login->email', '$login->password', '$login->token') 
            RETURNING * ");
        $query->setFetchMode(PDO::FETCH_CLASS, Login::class, ['', '', '', '', '', '']);
        return $query->fetch(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    }

    public function find(string $field, string $value) : Login
    {
        $query = $this->pdo->query(
            "SELECT * FROM login WHERE $field = '$value'");
        $query->setFetchMode(PDO::FETCH_CLASS, Login::class, ['', '', '', '', '', '']);
        return $query->fetch(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    }

    public function updateExpirationTokenTime(string $id) : void {
        $this->pdo->exec(
            "UPDATE login SET token_expiration_time = now() + '1 hour' WHERE id = '$id' ");
    }
}