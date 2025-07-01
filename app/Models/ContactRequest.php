<?php
require_once __DIR__ . '/../../config/database.php';

class ContactRequest
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Verifica si ya existe una solicitud entre los dos usuarios    
    public function yaExiste($sender_id, $receiver_id)
    {
        $stmt = $this->db->prepare("SELECT id FROM contact_requests WHERE sender_id = ? AND receiver_id = ? AND status = 'pendiente'");
        $stmt->execute([$sender_id, $receiver_id]);
        return $stmt->fetch() !== false;
    }

    public function crear($sender_id, $receiver_id)
    {
        $stmt = $this->db->prepare("INSERT INTO contact_requests (sender_id, receiver_id, status) VALUES (?, ?, 'pendiente')");
        return $stmt->execute([$sender_id, $receiver_id]);
    }

    public function getEnviadas($user_id)
    {
        $stmt = $this->db->prepare("
        SELECT cr.*, u.name AS receptor_name
        FROM contact_requests cr
        JOIN users u ON cr.receiver_id = u.id
        WHERE cr.sender_id = ?
        ORDER BY cr.created_at DESC
    ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecibidas($user_id)
    {
        $stmt = $this->db->prepare("
        SELECT cr.*, u.name AS emisor_name
        FROM contact_requests cr
        JOIN users u ON cr.sender_id = u.id
        WHERE cr.receiver_id = ?
        ORDER BY cr.created_at DESC
    ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstado($id, $nuevoEstado)
    {
        $stmt = $this->db->prepare("UPDATE contact_requests SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$nuevoEstado, $id]);
    }
}
