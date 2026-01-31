<?php
require_once __DIR__ . "/Database.php";

class Slider extends Database {

    public function getAllActive() {
        try {
            $stmt = $this->conn->query("SELECT * FROM slider WHERE active = 1 ORDER BY sort_order ASC, id ASC");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
