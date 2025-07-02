<?php

class AdminController
{
    public function dashboard()
    {
        // Start the session to access user data
        session_start();

        // Check if the user is logged in and has the admin role
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            // If not authorized, redirect to the login page
            header("Location: index.php?controller=auth&action=showLogin");
            exit;
        }

        // Load the admin dashboard view
        require __DIR__ . '/../../views/admin/dashboard.php';
    }
}

