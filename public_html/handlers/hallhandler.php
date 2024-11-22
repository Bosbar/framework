<?php

namespace WelkeHal\Handlers;

use DateTime;
use WelkeHal\Handlers\DatabaseHandler;

class HallHandler {

    public function __construct() {
        // Constructor logic, if any
    }

    public function chooseRandHall($originalChoice = false) {
        $date = new DateTime();
        $dayOfYear = $date->format('z'); // Day of the year (0-365)
        srand($dayOfYear); // Seed the random number generator with the day of the year
        $choice = rand(1, 2); // Replace with your actual random hall selection logic

        if($originalChoice) {
            return $choice;
        }

        if($this->hasBeenOverruled($choice) == "already overruled") { //Switches 1 to 2 and 2 to 1 if it's already overruled!
            $choice = ($choice == 1) ? 2 : (($choice == 2) ? 1 : $choice);
        }

        return $choice;
    }

    public function isHallConfirmed($token) {
        if ($token === "afv0v@v928!!") {
            $dbHandler = new DatabaseHandler(); // Assuming DatabaseHandler handles database operations

            // Get today's chosen hall ID
            $todaysChoice = $this->chooseRandHall();

            // Query to fetch confirmation status from database
            $query = "SELECT `confirmed_for_today` FROM `halls_history` WHERE `hall_id` = $todaysChoice";
            $result = $dbHandler->useDb($query); // Execute SQL query
            if ($result && !empty($result[0]['confirmed_for_today'])) {
                // Assuming `confirmed_for_today` is a date or timestamp in the database
                $confirmedDate = strtotime($result[0]['confirmed_for_today']);
                $today = strtotime(date('Y-m-d')); // Today's date

                // Compare dates: if today is after the confirmed date, it's confirmed
                if ($today == $confirmedDate) {
                    return true; // Hall is confirmed for today
                } else {
                    return false; // Hall is not confirmed for today
                }
            } else {
                return false; // No valid confirmation record found for today
            }
        } else {
            return ['error' => 'No access']; // Invalid token error message
        }
    }

    public function confirmHall($token) {
        if ($token === "afv0v@v928!!" && !$this->isHallConfirmed($token)) {
            $dbHandler = new DatabaseHandler();
            $todaysChoice = $this->chooseRandHall();
            $todayDate = date('Y-m-d');
    
            // Update `confirmed_for_today` with today's date and increment `visits` by 1
            $queryUpdate = "UPDATE `halls_history` SET `confirmed_for_today` = '$todayDate' WHERE `hall_id` = $todaysChoice";
            $resultUpdate = $dbHandler->useDb($queryUpdate); // Execute SQL query to update halls_history
            
            if ($resultUpdate !== false) {
                // Log visit in visits table
                $queryInsert = "INSERT INTO `visits` (`hall_id`, `visit_date`, `details`) VALUES ($todaysChoice, '$todayDate', '')";
                $resultInsert = $dbHandler->useDb($queryInsert); // Execute SQL query to insert into visits

                $query = "SELECT COUNT(*) AS visit_count FROM `visits` WHERE `hall_id` = $todaysChoice";
                $amountOfVisits = $dbHandler->useDb($query); // Execute SQL query
                $amountOfVisits = $amountOfVisits[0]['visit_count'];

                $query = "UPDATE `halls_history` SET `hall_visits` = $amountOfVisits WHERE `hall_id` = $todaysChoice";
                $resultInsert = $dbHandler->useDb($query); // Execute SQL query
                
                if ($resultInsert !== false) {
                    return true; // Both update and log were successful
                } else {
                    // Handle log insertion failure
                    return false;
                }
            } else {
                // Handle update failure
                return false;
            }
        } else {
            header('Location: https://meatspin.com/');
            die();
        }
    }

    public function overruleHall($token) {
        if ($token === "afv0v@v928!!" && !$this->isHallConfirmed($token)) {
            $dbHandler = new DatabaseHandler();
            $todaysChoice = $this->chooseRandHall(true);
            $todayDate = date('Y-m-d');
            $ip = $_SERVER['REMOTE_ADDR'];
            // Update `overruled` field to true for the selected hall
            $queryInsert = "INSERT INTO `visits` (`hall_id`, `visit_date`, `overruled`, `details`) VALUES ($todaysChoice, '$todayDate', 1, 'Hall has been overruled! From: $ip')";
            $resultInsert = $dbHandler->useDb($queryInsert); // Execute SQL query to insert into visits

            if ($resultInsert !== false) { //Now we update and log the new hall
                $todaysChoice = $this->chooseRandHall(false); //Since we overruled, we must re-set $todaysChoice

                $queryInsert2 = "INSERT INTO `visits` (`hall_id`, `visit_date`, `overruled`, `details`) VALUES ($todaysChoice, '$todayDate', 0, 'New Hall Selected! From: $ip')";
                $resultInsert = $dbHandler->useDb($queryInsert2); // Execute SQL query to insert into visits
                var_dump("resultInsert2 = " . $resultInsert);
                $queryUpdate = "UPDATE `halls_history` SET `confirmed_for_today` = '$todayDate' WHERE `hall_id` = $todaysChoice";
                $resultUpdate = $dbHandler->useDb($queryUpdate); // Execute SQL query to update halls_history

                var_dump("resultInsert = " . $resultUpdate);
                return true; // Update successful
            } else {
                return false; // Handle update failure
            }
        } else {
            header('Location: https://meatspin.com/');
            die();
        }
    }

    public function hasBeenOverruled($todaysChoice) {
        $dbHandler = new DatabaseHandler();
    
        // Get today's date
        $todayDate = date('Y-m-d');
    
        // Check if the hall has been overruled today
        $query = "SELECT * FROM `visits` WHERE `hall_id` = '$todaysChoice' AND `visit_date` = '$todayDate' AND `overruled` = 1";
        $result = $dbHandler->useDb($query);
        
        if ($result !== "0 results" && !empty($result)) {
            return "already overruled";
        } else {
            // Check if the hall has already been confirmed today
            $query = "SELECT * FROM `halls_history` WHERE `hall_id` = '$todaysChoice' AND `confirmed_for_today` = '$todayDate'";
            $result = $dbHandler->useDb($query);
    
            if ($result !== "0 results" && !empty($result)) {
                return "already confirmed";
            } else {
                return false;
            }
        }
    }
    
}
?>
