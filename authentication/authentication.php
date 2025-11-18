<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   
    $database = new Database();
    $mysqli = $database->getConnection();
    

    $stmt = $mysqli->prepare("CALL GetUserValidate(?)");
    
    // Bind the user-provided email to the placeholder
    $stmt->bind_param("s", $_POST["email"]);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    $userAccount = $result->fetch_assoc();

    $stmt->close();


    if ($userAccount) {
  
        if (password_verify($_POST["password"], $userAccount["password_hash"])) {
            session_start();
            session_regenerate_id();
            $userRole = $userAccount["role"]; 

            $_SESSION['role'] = $userRole; 
            $_SESSION['email'] = $userAccount["email"]; 
            $_SESSION['user_id'] = $userAccount["id"];
            if($userRole == 2)
            {    
                header("Location: ./admin/");  
                exit;
            }else if($userRole == 1)
            {
                header("Location: ./client/");  
                exit;
            }         
            // $_SESSION["user_id"] = $userAccount["id"];
            // header("Location: ./dashboard");
            //exit;
        }
    }
    
    // If user not found or password verification failed
    $is_invalid = true;
}

?>