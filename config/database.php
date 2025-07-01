<?php
class Database
{
    private static $host = 'localhost';
    private static $dbName = 'skillswap';
    private static $username = 'root';
    private static $password = '';

    public static function connect()
    {
        try {
            $conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8mb4", // <-- Se añadió charset
                self::$username,
                self::$password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // En una API REST, se suele devolver error en formato JSON
            http_response_code(500);
            echo json_encode([
                "error" => "Error de conexión a la base de datos.",
                "details" => $e->getMessage()
            ]);
            exit;
        }
    }

    
}

