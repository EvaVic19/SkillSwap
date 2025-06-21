<?php
// Carga automática de Composer (para PHPMailer)
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class MailService
{
    private $config;

    public function __construct()
    {
        // Cargar archivo de configuración de correo
        $this->config = require __DIR__ . '/../../config/mail_config.php';
    }

    public function send($toEmail, $toName, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = $this->config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config['username'];
            $mail->Password   = $this->config['password'];
            $mail->SMTPSecure = $this->config['secure'];
            $mail->Port       = $this->config['port'];
            $mail->CharSet    = 'UTF-8';

            // Remitente
            $mail->setFrom($this->config['from_email'], $this->config['from_name']);

            // Destinatario
            $mail->addAddress($toEmail, $toName);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Enviar
            $mail->send();
            return true;

        } catch (Exception $e) {
            throw new Exception("Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }
}
