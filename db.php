<?php 

    require "vendor/autoload.php";
    use Dotenv\Dotenv;

    class Database {
        private $pdo;

        public function __construct() {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];

            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Database connect successfully";
            } catch (PDOException $e) {
                die("Could not connect the database : ".$e);
            }
        }


        public function getConnection() {
            return $this->pdo;
        }

    }



