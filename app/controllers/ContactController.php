<?php
require_once __DIR__ . '/../models/ContactRequest.php';
require_once __DIR__ . '/../../config/database.php';

class ContactController
{
    public function sendRequest()
{
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo "Debes iniciar sesión para enviar solicitudes.";
        return;
    }

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];

    require_once __DIR__ . '/../models/ContactRequest.php';
    $contactModel = new ContactRequest();

    if ($sender_id == $receiver_id) {
        echo "No puedes enviarte una solicitud a ti mismo.";
        return;
    }

    if ($contactModel->yaExiste($sender_id, $receiver_id)) {
        echo "Ya enviaste una solicitud.";
    } else {
        $contactModel->crear($sender_id, $receiver_id);
        echo "Solicitud enviada correctamente.";
    }
}


    public function misSolicitudes()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            echo "<div class='alert alert-warning'>Debes iniciar sesión para ver tus solicitudes.</div>";
            return;
        }

        $user_id = $_SESSION['user_id'];
        require_once __DIR__ . '/../models/ContactRequest.php';

        $contactModel = new ContactRequest();

        $enviadas = $contactModel->getEnviadas($user_id);
        $recibidas = $contactModel->getRecibidas($user_id);

        require_once __DIR__ . '/../../views/contact/index.php';
    }

    public function aceptar()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "No autorizado.";
            return;
        }

        require_once __DIR__ . '/../models/ContactRequest.php';
        $model = new ContactRequest();
        $model->actualizarEstado($_GET['id'], 'aceptado');

        header('Location: index.php?controller=contact&action=misSolicitudes');
        exit;
    }

    public function rechazar()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "No autorizado.";
            return;
        }

        require_once __DIR__ . '/../models/ContactRequest.php';
        $model = new ContactRequest();
        $model->actualizarEstado($_GET['id'], 'rechazado');

        header('Location: index.php?controller=contact&action=misSolicitudes');
        exit;
    }
}
