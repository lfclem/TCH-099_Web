<?php

session_start();

class Database {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        $host = "db";
        $database = "mydatabase";
        $username = "user";
        $password = "password";

        if (!self::$instance) {
            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$database", 
                      $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, 
                      PDO::ERRMODE_EXCEPTION);
            } 
            catch(PDOException $e) {
                echo "Connexion échouée: " . $e->getMessage();
            }
        }
        return self::$instance;
    }
}

