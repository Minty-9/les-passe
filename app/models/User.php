<?php
class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Any status on purpose: login.php decides what to tell a suspended user,
    // and the admin "add user" duplicate check must also see suspended emails.
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare(
            'SELECT u.*, e.name AS estate_name, e.status AS estate_status
             FROM users u
             JOIN estates e ON e.id = u.estate_id
             WHERE u.email = ? LIMIT 1'
        );
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

    public function allByRole(int $estateId, string $role): array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE estate_id = ? AND role = ? ORDER BY name');
        $stmt->execute([$estateId, $role]);
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

    // Only touches residents and guards inside the given estate.
    // An admin can't suspend users of another estate, other admins, or themselves.
    public function updateStatus(int $id, string $status, int $estateId): bool {
        $stmt = $this->db->prepare(
            "UPDATE users SET status = ?
             WHERE id = ? AND estate_id = ? AND role IN ('resident','guard')"
        );
        $stmt->execute([$status, $id, $estateId]);
        return $stmt->rowCount() > 0;
    }
}
