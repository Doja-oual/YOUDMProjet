<?php
namespace Config;

require  '../vendor/autoload.php'; // Composer autoloader


use PDO;
USE PDOException;
use Dotenv\Dotenv;


// Load .env file from the root of your project
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class Database {
    private static $host ;
    private static $db_name ;
    private static $username ;
    private static $password ;
    public static $conn;

    public  function __construct() {
        // Retrieve values from the loaded environment variables
        self::$host = $_ENV['host'];
        self::$db_name = $_ENV['db_name'];
        self::$username = $_ENV['username'];
        self::$password = $_ENV['password'];
        self::$conn = null;
    }

    public static function getConnection() {
        
        try {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            self::$conn->exec("set names utf8");
            echo "works";
        } catch(PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
        }
        return self::$conn;
    }
}
$conn=new Database();
$conn->getConnection();

?>