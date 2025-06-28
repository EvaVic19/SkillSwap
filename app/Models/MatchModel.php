<?php
require_once __DIR__ . '/../../config/database.php';

class MatchModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Obtener todos los matches con nombres de habilidad y usuario
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

    // Obtener un match por ID
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

    // Crear un nuevo match
    public function crear($skill_id, $matched_user_id, $status = 'pendiente')
    {
        $stmt = $this->db->prepare("
            INSERT INTO matches (skill_id, matched_user_id, status, created_at) 
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute([$skill_id, $matched_user_id, $status]);
    }

    // Actualizar el estado de un match
    public function actualizar($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE matches SET status = ? WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    // Eliminar un match
    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        return $stmt->execute([$id]);
    }

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
            mu.id AS aprendiz_id,
            mu.name AS aprendiz_name
        FROM matches m
        JOIN skills s ON m.skill_id = s.id
        JOIN users u ON s.user_id = u.id -- Instructor
        JOIN users mu ON m.matched_user_id = mu.id -- Aprendiz
        WHERE s.user_id = ? OR m.matched_user_id = ?
        ORDER BY m.created_at DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}


