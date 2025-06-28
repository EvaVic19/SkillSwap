<?php

class AdminController
{
    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=showLogin");
            exit;
        }

        require __DIR__ . '/../../views/admin/dashboard.php';
    }
}
