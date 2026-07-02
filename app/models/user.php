<?php
class User {
    private PDO $db;
    public function __construct() {
        $this->db = Database::connect();
    }
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? AND status = "active" LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public function allResidents(int $estateId): array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE estate_id = ? AND role = "resident" ORDER BY name');
        $stmt->execute([$estateId]);
        return $stmt->fetchAll();
    }
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO users (estate_id, name, email, phone, password, role, unit)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['estate_id'], $data['name'], $data['email'],
            $data['phone'], $data['password'], $data['role'], $data['unit'] ?? null
        ]);
    }
    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare('UPDATE users SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }
    public function allByRole(int $estateId, string $role): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM users WHERE estate_id = ? AND role = ? ORDER BY name'
        );
        $stmt->execute([$estateId, $role]);
        return $stmt->fetchAll();
    }
}