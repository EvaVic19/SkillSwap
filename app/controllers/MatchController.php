<?php 
require_once __DIR__ . '/../models/MatchModel.php';
require_once __DIR__ . '/../../config/database.php';

class MatchController
{
    private $matchModel;
    private $db;

    public function __construct()
    {
        // Start session and initialize the Match model and database connection
        session_start();
        $this->matchModel = new MatchModel();
        $this->db = Database::connect(); // Needed for direct PDO queries
    }

    // Show all matches (admin only)
    public function index()
    {
        if ($_SESSION['role'] !== 'admin') {
            echo "⚠️ No tienes permisos para ver esta página.";
            return;
        }

        $matches = $this->matchModel->obtenerTodos();
        require_once __DIR__ . '/../../views/matches/index.php';
    }

    // Show match details (available for instructor, learner, or admin)
    public function show($id)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $role = $_SESSION['role'] ?? 'standard';

        // Ensure DB connection is available
        if (!isset($this->db)) {
            require_once __DIR__ . '/../config/database.php';
            $this->db = Database::connect();
        }

        // Query to get all match details including names for the view
        $sql = "SELECT m.*, 
                       s.name AS skill_name,
                       u1.id AS instructor_id, 
                       u1.name AS instructor_name,
                       u2.id AS matched_user_id, 
                       u2.name AS matched_user_name
                FROM matches m
                JOIN skills s ON m.skill_id = s.id
                JOIN users u1 ON s.user_id = u1.id
                JOIN users u2 ON m.matched_user_id = u2.id
                WHERE m.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$match) {
            echo "<div class='alert alert-danger'>⚠️ Match no encontrado.</div>";
            return;
        }

        // Allow only admin, instructor, or learner to view the match
        if (
            $role !== 'admin' &&
            $userId != $match['instructor_id'] &&
            $userId != $match['matched_user_id']
        ) {
            echo "<div class='alert alert-warning'>⚠️ No tienes permisos para ver este match.</div>";
            return;
        }

        require_once __DIR__ . '/../../views/matches/show.php';
    }

    // Show only matches related to the logged-in user
    public function misMatches()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "<div class='alert alert-warning'>⚠️ Debes iniciar sesión para ver tus matches.</div>";
            return;
        }

        $userId = $_SESSION['user_id'];

        // Get matches for the logged-in user
        $matches = $this->matchModel->obtenerPorUsuario($userId);

        require_once __DIR__ . '/../../views/users/matches.php';
    }

    // Form to create a match (admin or backend)
    public function create()
    {
        require_once __DIR__ . '/../models/Skill.php';
        require_once __DIR__ . '/../models/User.php';

        $skillModel = new Skill();
        $userModel = new User();

        $skills = $skillModel->obtenerTodas();
        $users = $userModel->obtenerTodos();

        require_once __DIR__ . '/../../views/matches/create.php';
    }

    // Store a new match
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $skill_id = $_POST['skill_id'];
            $matched_user_id = $_POST['matched_user_id'];
            $status = $_POST['status'] ?? 'pendiente';

            $this->matchModel->crear($skill_id, $matched_user_id, $status);
            header('Location: index.php?controller=Match&action=misMatches');
        }
    }

    // Form to edit match status
    public function edit($id)
    {
        $match = $this->matchModel->obtenerPorId($id);

        if (!$match) {
            echo "⚠️ Match no encontrado.";
            return;
        }

        // Only the learner or admin can edit the match
        if ($_SESSION['user_id'] != $match['matched_user_id'] && $_SESSION['role'] !== 'admin') {
            echo "⚠️ No tienes permiso para editar este match.";
            return;
        }

        require_once __DIR__ . '/../../views/matches/edit.php';
    }

    // Update match status
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];

            $match = $this->matchModel->obtenerPorId($id);

            if (!$match) {
                echo "⚠️ Match no encontrado.";
                return;
            }

            // Only the learner or admin can update the match
            if ($_SESSION['user_id'] != $match['matched_user_id'] && $_SESSION['role'] !== 'admin') {
                echo "⚠️ No tienes permiso para actualizar este match.";
                return;
            }

            $this->matchModel->actualizar($id, $status);
            header('Location: index.php?controller=match&action=misMatches');
        }
    }

    // Delete a match (admin only)
    public function delete($id)
    {
        if ($_SESSION['role'] !== 'admin') {
            echo "⚠️ No tienes permisos para eliminar matches.";
            return;
        }

        $this->matchModel->eliminar($id);
        header('Location: index.php?controller=Match&action=index');
    }
}
