<?php
require_once __DIR__ . "/Database.php";

class Job extends Database {

    /** @var string|null Last PDO error message */
    protected $lastError = null;

    public function getLastError() {
        return $this->lastError;
    }

    public function getAll() {
        try {
            $stmt = $this->conn->query("SELECT * FROM jobs ORDER BY sort_order ASC, created_at DESC");
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE id = ?");
            $stmt->execute([(int) $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function add($title, $company, $location, $sortOrder = 0) {
        $this->lastError = null;
        try {
            $stmt = $this->conn->prepare("INSERT INTO jobs (title, company, location, sort_order) VALUES (?, ?, ?, ?)");
            $ok = $stmt->execute([
                trim($title),
                trim($company),
                trim($location),
                (int) $sortOrder
            ]);
            return $ok;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }

    public function update($id, $title, $company, $location, $sortOrder = 0) {
        try {
            $stmt = $this->conn->prepare("UPDATE jobs SET title = ?, company = ?, location = ?, sort_order = ? WHERE id = ?");
            return $stmt->execute([
                trim($title),
                trim($company),
                trim($location),
                (int) $sortOrder,
                (int) $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM jobs WHERE id = ?");
            return $stmt->execute([(int) $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
