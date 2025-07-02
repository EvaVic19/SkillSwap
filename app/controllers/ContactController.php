<?php
require_once __DIR__ . '/../models/ContactRequest.php';
require_once __DIR__ . '/../../config/database.php';

class ContactController
{
    // Send a contact request from the logged-in user to another user
    public function sendRequest()
    {
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "Debes iniciar sesión para enviar solicitudes.";
            return;
        }

        $sender_id = $_SESSION['user_id'];
        $receiver_id = $_POST['receiver_id'];

        require_once __DIR__ . '/../models/ContactRequest.php';
        $contactModel = new ContactRequest();

        // Prevent sending a request to oneself
        if ($sender_id == $receiver_id) {
            echo "No puedes enviarte una solicitud a ti mismo.";
            return;
        }

        // Check if a request already exists
        if ($contactModel->yaExiste($sender_id, $receiver_id)) {
            echo "Ya enviaste una solicitud.";
        } else {
            // Create the contact request
            $contactModel->crear($sender_id, $receiver_id);
            echo "Solicitud enviada correctamente.";
        }
    }

    // Show the logged-in user's sent and received contact requests
    public function misSolicitudes()
    {
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<div class='alert alert-warning'>Debes iniciar sesión para ver tus solicitudes.</div>";
            return;
        }

        $user_id = $_SESSION['user_id'];
        require_once __DIR__ . '/../models/ContactRequest.php';

        $contactModel = new ContactRequest();

        // Get sent and received contact requests
        $enviadas = $contactModel->getEnviadas($user_id);
        $recibidas = $contactModel->getRecibidas($user_id);

        // Load the contact requests view
        require_once __DIR__ . '/../../views/contact/index.php';
    }

    // Accept a received contact request
    public function aceptar()
    {
        session_start();
        // Check if the user is logged in and the request ID is provided
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "No autorizado.";
            return;
        }

        require_once __DIR__ . '/../models/ContactRequest.php';
        $model = new ContactRequest();
        // Update the request status to 'accepted'
        $model->actualizarEstado($_GET['id'], 'aceptado');

        // Redirect back to the contact requests page
        header('Location: index.php?controller=contact&action=misSolicitudes');
        exit;
    }

    // Reject a received contact request
    public function rechazar()
    {
        session_start();
        // Check if the user is logged in and the request ID is provided
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "No autorizado.";
            return;
        }

        require_once __DIR__ . '/../models/ContactRequest.php';
        $model = new ContactRequest();
        // Update the request status to 'rejected'
        $model->actualizarEstado($_GET['id'], 'rechazado');

        // Redirect back to the contact requests page
        header('Location: index.php?controller=contact&action=misSolicitudes');
        exit;
    }
}
