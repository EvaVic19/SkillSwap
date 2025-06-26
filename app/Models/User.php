<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // ✅ Obtener todos los usuarios
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, email, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Crear un nuevo usuario

    public function create($name, $email, $hashedPassword, $role = 'standard')
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $role]);
    }

    // ✅ Obtener usuario por ID
   public function find($id)
{
    $stmt = $this->db->prepare("SELECT id, name, email, role, skill, about, photo FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // ✅ Eliminar usuario
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Obtener usuario por correo (para login o recuperación)
    public function getByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Guardar token de recuperación
    public function saveResetToken($userId, $token, $expiry)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE id = ?");
        return $stmt->execute([$token, $expiry, $userId]);
    }

    // ✅ Buscar por token
    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Actualizar contraseña
    public function updatePassword($userId, $newHashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$newHashedPassword, $userId]);
    }

    // ✅ Borrar token de recuperación
    public function clearResetToken($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = NULL, token_expiry = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }

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

    public static function buscarPorId($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, name, skill, about, photo FROM users WHERE id = :id AND role != 'admin'");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $name, $email, $skill, $about)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, skill = ?, about = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $skill, $about, $id]);
    }

    public function update($id, $name, $email, $skill, $about, $photo)
{
    $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, skill = ?, about = ?, photo = ? WHERE id = ?");
    return $stmt->execute([$name, $email, $skill, $about, $photo, $id]);
}

}
