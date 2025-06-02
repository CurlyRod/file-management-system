<?php   

class UserManagement{ 

    public function GetRegisterUser( $firstName, $middleName, $lastName, $email, $password_hash)
    { 
      
      $database = new Database();
      $mysqli = $database->getConnection();   
      $InsertAccount = "INSERT INTO user_acc (first_name,     
                                                middle_name, last_name, email,  
                                                password_hash)  
                                            VALUES (?, ?, ?, ?, ?, ?, ?)";                                                            
      $stmt = $mysqli->stmt_init();  
      if(!$stmt->prepare($InsertAccount))  
      {    
      die("SQL error: " . $mysqli->error);
      }   
      $stmt->bind_param("ssssss", $firstName, $middleName, $lastName, $email, $password_hash);          

      if($stmt->execute()){
        $result = ["statuscode"=> 200, "message"=> "Successfully Register."];
        echo json_encode($result);
      } 
      else 
      {
      die("Database error: Connection failed.");
      } 
    }
}

?>