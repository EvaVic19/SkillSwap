<?php

require_once __DIR__ . '/../models/Skill.php';

class SkillController
{
    private $skillModel;

    public function __construct()
    {
        $this->skillModel = new Skill();
    }

    // ✅ Listado de habilidades del usuario logueado
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $skills = $this->skillModel->getByUser($_SESSION['user_id']);
        require __DIR__ . '/../../views/skills/index.php';
    }

    // ✅ Formulario para crear habilidad
    public function create()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        require __DIR__ . '/../../views/skills/create.php';
    }

    // ✅ Guardar habilidad nueva
    public function store()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        // Validación básica
        $type = $_POST['type'] ?? '';
        if (!in_array($type, ['teach', 'learn'])) {
            die("Tipo de habilidad no válido.");
        }

        $data = [
            'user_id'     => $_SESSION['user_id'],
            'name'        => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'level'       => $_POST['level'] ?? '',
            'type'        => $type,
            'category'    => $_POST['category'] ?? '',
        ];

        // Validar que los campos no estén vacíos
        if (empty($data['name']) || empty($data['level']) || empty($data['category'])) {
            die("Todos los campos son obligatorios.");
        }

        $this->skillModel->create($data);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }

    // ✅ Formulario de edición
    public function edit()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_GET['id'] ?? null;
        $skill = $this->skillModel->find($id);

        if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
            die("No autorizado.");
        }

        require __DIR__ . '/../../views/skills/edit.php';
    }

    // ✅ Actualizar habilidad
    public function update()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_POST['id'] ?? null;
        $skill = $this->skillModel->find($id);

        if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
            die("No autorizado.");
        }

        $type = $_POST['type'] ?? '';
        if (!in_array($type, ['teach', 'learn'])) {
            die("Tipo no válido.");
        }

        $data = [
            'name'        => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'level'       => $_POST['level'] ?? '',
            'type'        => $type,
            'category'    => $_POST['category'] ?? '',
        ];

        $this->skillModel->update($id, $data);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }

    // ✅ Eliminar habilidad
    public function delete()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_GET['id'] ?? null;
        $skill = $this->skillModel->find($id);

        if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
            die("No autorizado.");
        }

        $this->skillModel->delete($id);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }
}

