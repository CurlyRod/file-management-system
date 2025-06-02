<?php   
    class UserManagement {     
       // ref: use magic constructor for passsing db-connector... -rod  03/06/2025  https://www.php.net/manual/en/language.oop5.magic.php
       // in this development im using stored proc for safety passing of query and not to expose the raw query...  -rod  03/06/2025 
        private $mysqli;
    
        public function __construct($dbConn) {
            $this->mysqli = $dbConn->getConnection();
        }
    
        public function GetRegisterUser($firstName, $middleName, $lastName, $email, $password_hash, $role) { 
          
            $stmt = $this->mysqli->prepare("CALL RegisterUser(?, ?, ?, ?, ?,?)");
    
            if (!$stmt) {
                die("MYSQL error: " . $this->mysqli->error);
            }
    
            $stmt->bind_param("ssssss", $firstName, $middleName, $lastName, $email, $password_hash, $role);          
    
            if ($stmt->execute()) {
                $result = ["statuscode" => 200, "message" => "Successfully Registered via Stored Procedure."];
                echo json_encode($result);
            } else {
                die("Database error: " . $stmt->error);
            }
    
            $stmt->close(); 
        }
    }
?>
    