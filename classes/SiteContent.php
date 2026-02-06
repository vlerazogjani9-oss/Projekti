<?php
require_once __DIR__ . "/Database.php";

class SiteContent extends Database {

    public function get($key) { // read only
        try {
            $stmt = $this->conn->prepare("SELECT content_value FROM site_content WHERE content_key = ?");
            $stmt->execute([$key]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['content_value'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllKeys() {
        try {
            $stmt = $this->conn->query("SELECT content_key, content_value FROM site_content");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }
}
