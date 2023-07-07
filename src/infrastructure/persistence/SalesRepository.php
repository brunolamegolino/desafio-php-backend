<?php

class SalesRepository {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getDb();
    }

    public function save(Sales $sale) {
        $return = $this->db->query("INSERT INTO sales (total) VALUES ($sale->total) RETURNING id, created_at")
            ->fetch(PDO::FETCH_ASSOC);
        $sale->id = $return['id'];
        $sale->created_at = $return['created_at'];
    }

    public function delete(string $salesId) {
        $this->db->exec("DELETE FROM sales WHERE id = '$salesId'");
    }
}