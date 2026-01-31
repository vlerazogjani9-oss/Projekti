<?php
require_once __DIR__ . "/Database.php";

class Job extends Database {

    public function getAll() {
        try {
            $stmt = $this->conn->query("SELECT * FROM jobs ORDER BY sort_order ASC, created_at DESC");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
