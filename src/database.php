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
            } else if ($name == 'test') {
                $db = new PDO(
                    'pgsql:host=db;port=5432;dbname=' . getenv('DB_NAME') . '-test',
                    getenv('DB_USER'),
                    getenv('DB_PASSWD')
                );
            } else {
                throw new \Exception('Database not found');
            }

            self::$instance = new Database($db);
            self::$instance->eraseTestDatabase();
        }

        return self::$instance;
    }

    public function getDb() {
        return $this->db;
    }

    public function eraseTestDatabase() {
        $databaseName = $this->db->query("SELECT current_database()")->fetchColumn();
        if (strpos($databaseName, '-test') !== false) {
            $this->db->exec("DELETE FROM sale_products");
            $this->db->exec("DELETE FROM products");
            $this->db->exec("DELETE FROM sales");
            $this->db->exec("DELETE FROM product_types");
            $this->db->exec("DELETE FROM login");
        }
    }
}
