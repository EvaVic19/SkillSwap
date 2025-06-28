<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private function safeSessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ✅ Mostrar formulario de login
    public function showLogin()
    {
        $this->safeSessionStart();
        $error = '';
        require __DIR__ . '/../../views/auth/login.php';
    }

    // ✅ Procesar login con redirección por rol
    public function login()
    {
        $this->safeSessionStart();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        if (!$email || !$password) {
            $error = 'Correo y contraseña son obligatorios.';
            require __DIR__ . '/../../views/auth/login.php';
            return;
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'] ?? 'standard';

            // ✅ Redirigir según el rol
            if ($_SESSION['role'] === 'admin') {
                header("Location: index.php?controller=admin&action=dashboard");
            } else {
                header("Location: index.php?controller=home&action=index");
            }
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
            require __DIR__ . '/../../views/auth/login.php';
        }
    }

    // ✅ Cerrar sesión
    public function logout()
    {
        $this->safeSessionStart();
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        header("Location: index.php?controller=auth&action=showLogin");
        exit;
    }

    // ✅ Mostrar formulario de recuperación
    public function forgotPassword()
    {
        require __DIR__ . '/../../views/auth/forgot_password.php';
    }

    // ✅ Enviar email con enlace de recuperación
    public function sendResetEmail()
    {
        date_default_timezone_set('America/Bogota');

        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            die("Correo requerido");
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if (!$user) {
            die("Usuario no encontrado");
        }

        $token = bin2hex(random_bytes(16));
        $expiry = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $userModel->saveResetToken($user['id'], $token, $expiry);

        $resetUrl = "http://localhost/App_SkillSwap/public/index.php?controller=auth&action=resetForm&token=$token";

        $resetLink = "
            <a href='$resetUrl' 
               style='display:inline-block;padding:10px 20px;font-size:16px;color:#fff;
                      background-color:#28a745;text-decoration:none;border-radius:5px;'>
               Recuperar contraseña
            </a>
        ";

        $subject = 'Recuperación de contraseña';
        $body = "
            <p>Hola <strong>{$user['name']}</strong>,</p>
            <p>Has solicitado restablecer tu contraseña.</p>
            <p>Haz clic en el siguiente botón para continuar:</p>
            <p>$resetLink</p>
            <p>Este enlace expirará en 1 hora.</p>
        ";

        try {
            require_once __DIR__ . '/../../src/Services/MailService.php';
            $mailer = new MailService();
            $mailer->send($email, $user['name'], $subject, $body);

            $type = "success";
            $message = "Se ha enviado un correo con el enlace de recuperación.";
            $redirectUrl = "index.php?controller=auth&action=showLogin";

        } catch (Exception $e) {
            $type = "danger";
            $message = "Error al enviar el correo: " . $e->getMessage();
            $redirectUrl = "index.php?controller=auth&action=forgotPassword";
        }

        require __DIR__ . '/../../views/shared/message.php';
        exit;
    }

    // ✅ Mostrar formulario para nueva contraseña
    public function resetForm()
    {
        $token = $_GET['token'] ?? '';
        require __DIR__ . '/../../views/auth/reset_password.php';
    }

    // ✅ Procesar el cambio de contraseña
    public function resetPassword()
    {
        $token = $_POST['token'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByToken($token);

        if (!$user || strtotime($user['token_expiry']) < time()) {
            $type = "danger";
            $message = "Token inválido o expirado.";
            $redirectUrl = "index.php?controller=auth&action=showLogin";
            require __DIR__ . '/../../views/shared/message.php';
            exit;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->updatePassword($user['id'], $hashed);
        $userModel->clearResetToken($user['id']);

        $type = "success";
        $message = "Contraseña actualizada correctamente.";
        $redirectUrl = "index.php?controller=auth&action=showLogin";
        require __DIR__ . '/../../views/shared/message.php';
        exit;
    }
}
