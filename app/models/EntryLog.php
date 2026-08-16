<?php
class EntryLog {
    private PDO $db;
    public function __construct() {
        $this->db = Database::connect();
    }
    public function record(array $data): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO entry_logs (estate_id, pass_id, guard_id, code_entered, result, note)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['estate_id'], $data['pass_id'] ?? null,
            $data['guard_id'] ?? null, $data['code_entered'],
            $data['result'], $data['note'] ?? null
        ]);
    }
    public function allForEstate(int $estateId, int $limit = 50): array {
        $stmt = $this->db->prepare(
            'SELECT l.*, u.name AS guard_name, p.visitor_name
             FROM entry_logs l
             LEFT JOIN users u ON u.id = l.guard_id
             LEFT JOIN passes p ON p.id = l.pass_id
             WHERE l.estate_id = ?
             ORDER BY l.logged_at DESC
             LIMIT ?'
        );
        $stmt->execute([$estateId, $limit]);
        return $stmt->fetchAll();
    }
    public function todayCount(int $estateId): int {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM entry_logs
             WHERE estate_id = ? AND result = "granted" AND DATE(logged_at) = CURDATE()'
        );
        $stmt->execute([$estateId]);
        return (int) $stmt->fetchColumn();
    }
}