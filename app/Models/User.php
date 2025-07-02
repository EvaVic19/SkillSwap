<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $this->db = Database::connect();
    }

    // ✅ Get all users (basic info)
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, email, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Create a new user
    public function create($name, $email, $hashedPassword, $role = 'standard')
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $role]);
    }

    // ✅ Get a user by ID (detailed info)
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, email, role, skill, about, photo FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Delete a user by ID
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Get a user by email (for login or password recovery)
    public function getByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Save password reset token and its expiry
    public function saveResetToken($userId, $token, $expiry)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE id = ?");
        return $stmt->execute([$token, $expiry, $userId]);
    }

    // ✅ Find a user by password reset token
    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Update user's password
    public function updatePassword($userId, $newHashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$newHashedPassword, $userId]);
    }

    // ✅ Clear password reset token and expiry
    public function clearResetToken($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = NULL, token_expiry = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    // Search users by skill (excluding admins)
    public static function buscarUsuarios($filtro = '')
    {
        $db = Database::connect();
        $sql = "SELECT id, name, skill, photo FROM users WHERE role != 'admin'";

        if (!empty($filtro)) {
            $sql .= " AND skill LIKE :filtro";
        }

        $stmt = $db->prepare($sql);

        if (!empty($filtro)) {
            $stmt->bindValue(':filtro', '%' . $filtro . '%');
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search a user by ID (excluding admins)
    public static function buscarPorId($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, name, skill, about, photo FROM users WHERE id = :id AND role != 'admin'");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update basic user profile info
    public function updateProfile($id, $name, $email, $skill, $about)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, skill = ?, about = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $skill, $about, $id]);
    }

    // Update user info including photo
    public function update($id, $name, $email, $skill, $about, $photo)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, skill = ?, about = ?, photo = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $skill, $about, $photo, $id]);
    }

    // Get all users (full info)
    public function obtenerTodos()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
