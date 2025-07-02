<?php
require_once __DIR__ . '/../../config/database.php';

class MatchModel
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::connect();
    }

    // Get all matches (raw, no joins)
    public function getAll()
    {
        $sql = "SELECT * FROM matches ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a match by its ID (raw, no joins)
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all matches with skill and user names
    public function obtenerTodos()
    {
        $sql = "
            SELECT 
                matches.id,
                matches.status,
                matches.created_at,
                matches.skill_id,
                matches.matched_user_id,
                skills.name AS skill_name,
                users.name AS user_name
            FROM matches
            JOIN skills ON matches.skill_id = skills.id
            JOIN users ON matches.matched_user_id = users.id
            ORDER BY matches.created_at DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a match by ID with skill and user names
    public function obtenerPorId($id)
    {
        $sql = "
            SELECT 
                matches.id,
                matches.status,
                matches.created_at,
                matches.skill_id,
                matches.matched_user_id,
                skills.name AS skill_name,
                users.name AS user_name
            FROM matches
            JOIN skills ON matches.skill_id = skills.id
            JOIN users ON matches.matched_user_id = users.id
            WHERE matches.id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new match
    public function crear($skill_id, $matched_user_id, $status = 'pendiente')
    {
        $stmt = $this->db->prepare("
            INSERT INTO matches (skill_id, matched_user_id, status, created_at) 
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute([$skill_id, $matched_user_id, $status]);
    }

    // Update the status of a match
    public function actualizar($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE matches SET status = ? WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    // Delete a match by ID
    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Get all matches related to a specific user (as instructor or matched user)
    public function obtenerPorUsuario($userId)
    {
        $sql = "
            SELECT 
                m.id,
                m.skill_id,
                s.name AS skill_name,
                m.status,
                m.created_at,
                s.user_id AS instructor_id,
                u.name AS instructor_name,
                mu.id AS matched_user_id,
                mu.name AS matched_user_name
            FROM matches m
            JOIN skills s ON m.skill_id = s.id
            JOIN users u ON s.user_id = u.id               -- Instructor
            JOIN users mu ON m.matched_user_id = mu.id     -- Matched user
            WHERE s.user_id = ? OR m.matched_user_id = ?
            ORDER BY m.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
