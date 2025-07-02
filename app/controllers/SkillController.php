<?php

require_once __DIR__ . '/../models/Skill.php';

class SkillController
{
    private $skillModel;

    public function __construct()
    {
        // Initialize the Skill model
        $this->skillModel = new Skill();
    }

    // ✅ List logged-in user's skills
    public function index()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        // Get all skills for the logged-in user and load the skills list view
        $skills = $this->skillModel->getByUser($_SESSION['user_id']);
        require __DIR__ . '/../../views/skills/index.php';
    }

    // ✅ Show form to create a new skill
    public function create()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        require __DIR__ . '/../../views/skills/create.php';
    }

    // ✅ Save a new skill
    public function store()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        // Basic validation
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

        // Validate that required fields are not empty
        if (empty($data['name']) || empty($data['level']) || empty($data['category'])) {
            die("Todos los campos son obligatorios.");
        }

        // Create the new skill and redirect to the skills list
        $this->skillModel->create($data);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }

    // ✅ Show form to edit a skill
    public function edit()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_GET['id'] ?? null;
        $skill = $this->skillModel->find($id);

        // Ensure the skill exists and belongs to the logged-in user
        if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
            die("No autorizado.");
        }

        require __DIR__ . '/../../views/skills/edit.php';
    }

    // ✅ Update a skill
    public function update()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_POST['id'] ?? null;
        $skill = $this->skillModel->find($id);

        // Ensure the skill exists and belongs to the logged-in user
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

        // Update the skill and redirect to the skills list
        $this->skillModel->update($id, $data);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }

    // ✅ Delete a skill
    public function delete()
    {
        session_start();
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die("Acceso no autorizado.");
        }

        $id = $_GET['id'] ?? null;
        $skill = $this->skillModel->find($id);

        // Ensure the skill exists and belongs to the logged-in user
        if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
            die("No autorizado.");
        }

        // Delete the skill and redirect to the skills list
        $this->skillModel->delete($id);
        header("Location: index.php?controller=skill&action=index");
        exit;
    }
}
