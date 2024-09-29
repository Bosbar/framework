<?php

namespace Bosbar;

class Handler 
{
    protected $db;

    public function __construct() {
        $this->db = new \mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function index() {
        echo "Base Controller Index Method<br>";
    }

    // Add more methods as needed
}

?>
