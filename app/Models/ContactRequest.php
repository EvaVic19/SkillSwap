<?php
require_once __DIR__ . '/../../config/database.php';

class ContactRequest
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::connect();
    }

    // Check if a pending contact request already exists between the two users
    public function yaExiste($sender_id, $receiver_id)
    {
        $stmt = $this->db->prepare("SELECT id FROM contact_requests WHERE sender_id = ? AND receiver_id = ? AND status = 'pendiente'");
        $stmt->execute([$sender_id, $receiver_id]);
        return $stmt->fetch() !== false;
    }

    // Create a new contact request with 'pending' status
    public function crear($sender_id, $receiver_id)
    {
        $stmt = $this->db->prepare("INSERT INTO contact_requests (sender_id, receiver_id, status) VALUES (?, ?, 'pendiente')");
        return $stmt->execute([$sender_id, $receiver_id]);
    }

    // Get all contact requests sent by the user
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

    // Get all contact requests received by the user
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

    // Update the status of a contact request (e.g., accept or reject)
    public function actualizarEstado($id, $nuevoEstado)
    {
        $stmt = $this->db->prepare("UPDATE contact_requests SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$nuevoEstado, $id]);
    }
}

