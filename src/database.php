<?php

class Database {
    private static $instance = null;
    private $db;

    private function __construct(PDO $db=null) {
        $this->db = $db;
    }

    public static function getInstance(String $name=null) {
        if (self::$instance == null && !empty($name)) {
            if ($name == 'postgres') {
                $db = new PDO(
                    'pgsql:host=db;port=5432;dbname=' . getenv('DB_NAME'),
                    getenv('DB_USER'),
                    getenv('DB_PASSWD')
                );
            } else if ($name == 'sqlite') {
                $db = new PDO('sqlite:tests/database.db');
                $db->exec("DELETE FROM product_types");
                $db->exec("DELETE FROM products");
                $db->exec("DELETE FROM sales");
                $db->exec("DELETE FROM sale_products");
            } else {
                throw new \Exception('Database not found');
            }

            self::$instance = new Database($db);
        }

        return self::$instance;
    }

    public function getDb() {
        return $this->db;
    }
}
