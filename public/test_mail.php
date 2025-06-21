<?php
require_once __DIR__ . '/../src/Services/MailService.php';

try {
    $mailer = new MailService();

    $correoDestino = 'evicfulls@gmail.com'; 
    $nombreDestino = 'Victoria';           // <--- opcional
    $asunto = 'Correo de prueba desde App_SkillSwap';
    $cuerpo = '<p>Hola Victoria, este es un <strong>correo de prueba</strong> enviado con PHPMailer desde tu app.</p>';

    $mailer->send($correoDestino, $nombreDestino, $asunto, $cuerpo);

    echo "✅ Correo enviado con éxito a $correoDestino.";
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: " . $e->getMessage();
}
