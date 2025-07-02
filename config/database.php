<?php
class Database
{
    // Database connection parameters
    private static $host = 'localhost';
    private static $dbName = 'skillswap';
    private static $username = 'root';
    private static $password = '';

    // Establish and return a PDO database connection
    public static function connect()
    {
        try {
            $conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8mb4", // <-- Charset added
                self::$username,
                self::$password
            );
            // Set PDO to throw exceptions on error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // For a REST API, return error in JSON format
            http_response_code(500);
            echo json_encode([
                "error" => "Error de conexión a la base de datos.",
                "details" => $e->getMessage()
            ]);
            exit;
        }
    }
}


