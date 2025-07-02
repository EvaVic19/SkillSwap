<?php
require_once __DIR__ . '/../../config/database.php';

class Skill
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::connect();
    }

    // Get all skills for a specific user
    public function getByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM skills WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a skill by its ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new skill with the provided data
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO skills (user_id, name, description, level, type, category) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $data['name'],
            $data['description'],
            $data['level'],
            $data['type'],
            $data['category']
        ]);
    }

    // Update an existing skill with new data
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE skills SET name = ?, description = ?, level = ?, type = ?, category = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['level'],
            $data['type'],
            $data['category'],
            $id
        ]);
    }

    // Delete a skill by its ID
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM skills WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Get all skills in the database
    public function obtenerTodas()
    {
        $stmt = $this->db->query("SELECT * FROM skills");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

