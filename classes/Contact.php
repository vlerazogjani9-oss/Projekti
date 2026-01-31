<?php
require_once __DIR__ . "/Database.php";

class Contact extends Database {

    public function save($name, $email, $message) {
        $stmt = $this->conn->prepare(
            "INSERT INTO contact_messages(name, email, message) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$name, $email, $message]);
    }

    public function getAll() {
        try {
            $stmt = $this->conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
