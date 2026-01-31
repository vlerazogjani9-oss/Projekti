<?php
require_once __DIR__ . "/Database.php";

class TeamMember extends Database {

    public function getAll() {
        try {
            $stmt = $this->conn->query("SELECT * FROM team_members ORDER BY sort_order ASC, id ASC");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
