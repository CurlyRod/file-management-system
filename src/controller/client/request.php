<?php
    require_once '../../database/db-conn.php';
    require_once '../../class/client/request.php';

    ob_start(); // START buffering to catch unwanted output
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
 


    $database = new Database(); 
    $dbConn = Database::GetInstanceConn();  
    $request = new Request($dbConn);

    if($_POST['action'] === "request_file")
    {
         $request->RequestFile($_POST["filename"], $_POST["user_id"]); 
         exit;
    }  
   

?>