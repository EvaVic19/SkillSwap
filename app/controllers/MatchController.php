<?php 
require_once __DIR__ . '/../models/MatchModel.php';
require_once __DIR__ . '/../../config/database.php';

class MatchController
{
    private $matchModel;
    private $db;

    public function __construct()
    {
        session_start();
        $this->matchModel = new MatchModel();
        $this->db = Database::connect(); // Necesario para consultas directas con PDO
    }

    // Mostrar todos los matches (solo para admin)
    public function index()
    {
        if ($_SESSION['role'] !== 'admin') {
            echo "⚠️ No tienes permisos para ver esta página.";
            return;
        }

        $matches = $this->matchModel->obtenerTodos();
        require_once __DIR__ . '/../../views/matches/index.php';
    }

    // Ver detalle de un match (instructor, aprendiz o admin)
    public function show($id)
    {
        $userId = $_SESSION['user_id'] ?? null;
        $role = $_SESSION['role'] ?? 'standard';

        $sql = "SELECT m.*, 
                       s.name AS skill_name,
                       u1.id AS instructor_id, 
                       u1.name AS instructor_name,
                       u2.id AS aprendiz_id, 
                       u2.name AS aprendiz_name
                FROM matches m
                JOIN skills s ON m.skill_id = s.id
                JOIN users u1 ON s.user_id = u1.id
                JOIN users u2 ON m.matched_user_id = u2.id
                WHERE m.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$match) {
            echo "⚠️ Match no encontrado.";
            return;
        }

        if (
            $role !== 'admin' &&
            $userId != $match['instructor_id'] &&
            $userId != $match['aprendiz_id']
        ) {
            echo "<div class='alert alert-warning'>⚠️ No tienes permisos para ver este match.</div>";
            return;
        }

        require_once __DIR__ . '/../../views/matches/show.php';
    }

    // Ver solo los matches del usuario logueado
    public function misMatches()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "⚠️ Debes iniciar sesión.";
            return;
        }

        $user_id = $_SESSION['user_id'];

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
                WHERE u1.id = :user_id OR m.matched_user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../views/users/matches.php';
    }

    // Formulario para crear un match (admin o desde backend)
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

    // Guardar nuevo match
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

    // Formulario para editar estado de match
    public function edit($id)
    {
        $match = $this->matchModel->obtenerPorId($id);

        if (!$match) {
            echo "⚠️ Match no encontrado.";
            return;
        }

        if ($_SESSION['user_id'] != $match['matched_user_id'] && $_SESSION['role'] !== 'admin') {
            echo "⚠️ No tienes permiso para editar este match.";
            return;
        }

        require_once __DIR__ . '/../../views/matches/edit.php';
    }

    // Actualizar estado
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

            if ($_SESSION['user_id'] != $match['matched_user_id'] && $_SESSION['role'] !== 'admin') {
                echo "⚠️ No tienes permiso para actualizar este match.";
                return;
            }

            $this->matchModel->actualizar($id, $status);
            header('Location: index.php?controller=match&action=misMatches');
        }
    }

    // Eliminar match (solo admin)
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
