<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Skill.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        // Initialize the User model
        $this->userModel = new User();
    }

    public function index()
    {
        // Retrieve all users and load the users list view
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../../views/users/index.php';
    }

    public function create()
    {
        // Load the user creation form view
        require_once __DIR__ . '/../../views/users/create.php';
    }

    public function store()
    {
        // Handle the registration of a new user
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'standard';

        if ($name && $email && $password) {
            // Check if the email is already registered
            if ($this->userModel->getByEmail($email)) {
                echo "El correo ya está registrado.";
                return;
            }

            // Hash the password and create the user
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->create($name, $email, $hashed, $role);
            header("Location: index.php?controller=user&action=index");
        } else {
            echo "Todos los campos son obligatorios.";
        }
    }

    public function edit()
    {
        // Load the user edit form, only if the session user matches the ID
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
        // Handle the update of user profile data
        session_start();
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skill = $_POST['skill'] ?? '';
        $about = $_POST['about'] ?? '';

        if (!$id || !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $id) {
            die("No autorizado.");
        }

        // Handle profile photo upload
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

        // Get current user data
        $user = $this->userModel->find($id);

        // Keep the existing photo if a new one was not uploaded
        if (!$photo) {
            $photo = $user['photo'] ?? null;
        }

        // Update user data in the database
        $this->userModel->update($id, $name, $email, $skill, $about, $photo);

        // Redirect to the updated user profile
        header("Location: index.php?controller=user&action=show&id=$id");
        exit;
    }

    public function delete()
    {
        // Delete a user by ID and redirect to the users list
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->delete($id);
        }
        header("Location: index.php?controller=user&action=index");
    }

    public function show()
    {
        // Display the public profile of a user by ID
        session_start();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "<div class='alert alert-danger'>ID no válido.</div>";
            return;
        }

        $usuario = $this->userModel->find($id);

        if (!$usuario) {
            echo "<div class='alert alert-warning'>Usuario no encontrado.</div>";
            return;
        }

        require_once __DIR__ . '/../models/Skill.php';
        $skillModel = new Skill();
        $skills = $skillModel->getByUser($id);

        require __DIR__ . '/../../views/users/show.php';
    }

    public function contactar()
    {
        // Handle the process of sending a contact request to another user
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            header("Location: index.php?controller=user&action=show&id=" . ($_GET['id'] ?? '') . "&error=unauthorized");
            exit;
        }

        $sender_id = $_SESSION['user_id'];
        $receiver_id = $_GET['id'];

        // Prevent sending a request to oneself
        if ($sender_id == $receiver_id) {
            header("Location: index.php?controller=user&action=show&id=$receiver_id&error=self");
            exit;
        }

        require_once __DIR__ . '/../models/ContactRequest.php';
        $contactModel = new ContactRequest();

        // Check if a request already exists between these users
        if ($contactModel->yaExiste($sender_id, $receiver_id)) {
            header("Location: index.php?controller=user&action=show&id=$receiver_id&info=exists");
            exit;
        }

        // Create the contact request and redirect with success or error message
        if ($contactModel->crear($sender_id, $receiver_id)) {
            header("Location: index.php?controller=user&action=show&id=$receiver_id&success=1");
            exit;
        } else {
            header("Location: index.php?controller=user&action=show&id=$receiver_id&error=db");
            exit;
        }
    }
}
