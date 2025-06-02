<?php  
 // follow the singleton pattern practice to for reusing a function and straight forward transaction.. -rod 3/06/2025
  require_once '../database/db-conn.php';
  require_once '../class/user-management.php';   
  
  $database = new Database(); 
  $dbConn =  Database::GetInstanceConn();
  $userClass = new UserManagement($dbConn);

  if(isset($_POST['action']) && $_POST['action'] == "insert")
  {  
    
        $firstName = $_POST['fname']; 
        $middleName =   $_POST['mname'];
        $lastName = $_POST['lname'];  
        $email =  $_POST['email'];
        $password_hash = password_hash($_POST['user-password'], PASSWORD_DEFAULT);     
        $selectedValue = $_POST['user-role'];

        try {
            $userClass->GetRegisterUser( $firstName, $middleName, $lastName, $email, $password_hash, $selectedValue); 
        } catch (\Throwable $th) { 
            error_log('Exception occurred: ' . $th->getMessage());
        }
   }     
?>