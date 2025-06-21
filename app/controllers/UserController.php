<?php
require_once __DIR__ . '/../models/User.php';


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
            // Verificar si ya existe un usuario con ese email
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
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID no válido");
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            die("Usuario no encontrado.");
        }

    require_once __DIR__ . '/../../views/users/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'standard';

        if ($id && $name && $email) {
            $this->userModel->update($id, $name, $email, $role);
            header("Location: index.php?controller=user&action=index");
        } else {
            echo "Todos los campos son obligatorios.";
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->delete($id);
        }
        header("Location: index.php?controller=user&action=index");
    }
}
