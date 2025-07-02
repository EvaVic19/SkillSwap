<?php
require_once __DIR__ . '/../models/User.php';

class HomeController
{
    // Display the home page with the list of users, optionally filtered by skill
    public function index()
    {
        $filtro = $_GET['filtro'] ?? '';
        // Retrieve users filtered by the search term (skill)
        $usuarios = User::buscarUsuarios($filtro);

        // Make the variables available to the view
        require __DIR__ . '/../../views/home/index.php';
    }
}
