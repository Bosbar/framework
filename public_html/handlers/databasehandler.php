<?php

namespace Bosbar\Handlers;

use mysqli;

class DatabaseHandler {
    private $conn;

    public function __construct() {
        $this->dbConnect();
    }

    public function dbConnect() {
        $this->conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function useDb($sql) {
        // Temporarily disable the mysqli exception throwing
        mysqli_report(MYSQLI_REPORT_OFF);
    
        // Execute the query
        $result = $this->conn->query($sql);
    
        // Re-enable mysqli exception throwing
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
        // Check if there's an error
        if ($result === false) {
            var_dump($sql); // Dump the SQL query
            var_dump($this->conn->error); // Dump the SQL error message
            die("Fatal error in SQL query: " . $this->conn->error); // Stop execution with an error message
        }
    
        // Return the result if it's a boolean and true
        if (is_bool($result) && $result) {
            return $result;
        }
    
        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "0 results";
        }
    }
    
    
}

?>
