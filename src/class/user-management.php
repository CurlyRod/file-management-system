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

        public function GetAllUsers() {
            $stmt = $this->mysqli->prepare("CALL GetAllUsers()");
            if (!$stmt) {
                return null;
            }
        
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $users = [];
        
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
        
                return $users;
            }
        
            return null;
        }
        // by id of lookup ..-rod
        public function GetUserById($id)
        {
            $stmt = $this->mysqli->prepare("CALL GetUserById(?)");
        
            if (!$stmt) {
                die("MYSQL error: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $id);
        
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
        
                echo json_encode([
                    "statuscode" => 200,
                    "data" => $user
                ]);
            } else {
                echo json_encode([
                    "statuscode" => 500,
                    "message" => "Failed to retrieve user: " . $stmt->error
                ]);
            }
        
            $stmt->close();
        } 
        //delete by id 

        public function DeleteUserById($id) {
            $stmt = $this->mysqli->prepare("CALL DeleteUserById(?)");
        
            if (!$stmt) {
                die("MYSQL error: " . $this->mysqli->error);
            }
        
            $stmt->bind_param("i", $id);
        
            if ($stmt->execute()) {
                return ["statuscode" => 200, "message" => "User deleted successfully."];
            } else {
                return ["statuscode" => 500, "message" => "Deletion failed."];
            }
        
            $stmt->close();
        }
        

        public function UpdateUser($id, $firstName, $middleName, $lastName, $email, $role) {
            $stmt = $this->mysqli->prepare("CALL UpdateUser( ?, ?, ?, ?, ?,?)");
        
            if (!$stmt) {
                die("MYSQL error: " . $this->mysqli->error);
            }
        
            
            $stmt->bind_param("issssi", $id, $firstName, $middleName, $lastName, $email, $role);
        
            if ($stmt->execute()) {
                $result = ["statuscode" => 200, "message" => "User updated successfully."];
                echo json_encode($result);
            } else {
                die("Database error: " . $stmt->error);
            }
        
            $stmt->close();
        }
        
        
    }
?>
    