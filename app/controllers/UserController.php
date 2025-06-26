<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Skill.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../../views/users/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../../views/users/create.php';
    }

    public function store()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'standard';

        if ($name && $email && $password) {
            if ($this->userModel->getByEmail($email)) {
                echo "El correo ya está registrado.";
                return;
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->create($name, $email, $hashed, $role);
            header("Location: index.php?controller=user&action=index");
        } else {
            echo "Todos los campos son obligatorios.";
        }
    }

    public function edit()
    {
        session_start();
        $id = $_GET['id'] ?? null;

        if (!$id || !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $id) {
            die("No autorizado.");
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            die("Usuario no encontrado.");
        }

        require __DIR__ . '/../../views/users/edit.php';
    }

    public function update()
    {
        session_start();
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skill = $_POST['skill'] ?? '';
        $about = $_POST['about'] ?? '';

        if (!$id || !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $id) {
            die("No autorizado.");
        }

        // Subida de imagen
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['photo']['tmp_name'];
            $originalName = basename($_FILES['photo']['name']);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $newName = uniqid('user_') . '.' . $extension;
            $destination = __DIR__ . '/../../public/img/' . $newName;

            if (move_uploaded_file($tmpName, $destination)) {
                $photo = $newName;
            }
        }

        // Obtener datos actuales del usuario
        $user = $this->userModel->find($id);

        // Si no se subió nueva foto, conservar la existente
        if (!$photo) {
            $photo = $user['photo'] ?? null;
        }

        // Actualizar usuario
        $this->userModel->update($id, $name, $email, $skill, $about, $photo);

        // Redirigir al perfil actualizado
        header("Location: index.php?controller=user&action=show&id=$id");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->delete($id);
        }
        header("Location: index.php?controller=user&action=index");
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no válido.");
        }

        $usuario = $this->userModel->find($id);
        $skillModel = new Skill();
        $skills = $skillModel->getByUser($id);

        require __DIR__ . '/../../views/users/show.php';
    }
}
