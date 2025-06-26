<?php 
require_once __DIR__ . '/../models/User.php';

class HomeController
{
    public function index()
    {
        $filtro = $_GET['buscar'] ?? '';
        $usuarios = User::buscarUsuarios($filtro);

        // Hacemos disponibles las variables para la vista
       require __DIR__ . '/../../views/home/index.php';
    }
}
