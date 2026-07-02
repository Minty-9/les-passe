<?php
class Pass {
    private PDO $db;
    public function __construct() {
        $this->db = Database::connect();
    }
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            'INSERT INTO passes (estate_id, resident_id, visitor_name, visitor_phone, code, duration_hrs, expires_at)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['estate_id'], $data['resident_id'], $data['visitor_name'],
            $data['visitor_phone'] ?? null, $data['code'],
            $data['duration_hrs'], $data['expires_at']
        ]);
        return (int) $this->db->lastInsertId();
    }
    public function findByCode(string $code): ?array {
        $stmt = $this->db->prepare(
            'SELECT p.*, u.name AS resident_name, u.unit, e.name AS estate_name
             FROM passes p
             JOIN users u ON u.id = p.resident_id
             JOIN estates e ON e.id = p.estate_id
             WHERE p.code = ? LIMIT 1'
        );
        $stmt->execute([$code]);
        return $stmt->fetch() ?: null;
    }
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM passes WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public function allForResident(int $residentId): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM passes WHERE resident_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$residentId]);
        return $stmt->fetchAll();
    }
    public function markUsed(int $id): bool {
        $stmt = $this->db->prepare('UPDATE passes SET status = "used" WHERE id = ?');
        return $stmt->execute([$id]);
    }
    public function cancel(int $id, int $residentId): bool {
        $stmt = $this->db->prepare(
            'UPDATE passes SET status = "cancelled" WHERE id = ? AND resident_id = ? AND status = "active"'
        );
        return $stmt->execute([$id, $residentId]);
    }
    public function todayForEstate(int $estateId): array {
        $stmt = $this->db->prepare(
            'SELECT p.*, u.name AS resident_name, u.unit
             FROM passes p JOIN users u ON u.id = p.resident_id
             WHERE p.estate_id = ? AND DATE(p.created_at) = CURDATE()
             ORDER BY p.created_at DESC'
        );
        $stmt->execute([$estateId]);
        return $stmt->fetchAll();
    }
}