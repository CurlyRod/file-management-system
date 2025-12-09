<?php   

    require_once '../../database/db-conn.php';
    require_once '../../class/admin/analytics.php';

    ob_start(); // START buffering to catch unwanted output
    ini_set('display_errors', 1);
    error_reporting(E_ALL); 


    $database = new Database(); 
    $dbConn = Database::GetInstanceConn();
    $analytics = new Analytics($dbConn); 

    if ($_POST['action'] === 'get_myfiles') {
        $id = intval($_POST['user_id']);
        $analytics->GetTotalMyfilesByID($id);
        exit;
    }  
    if ($_POST['action'] === 'get_transacCount') {
        $analytics->GetTotalTransactionCount();
        exit;
    }  
     if ($_POST['action'] === 'get_resolveCount') {
        $analytics->GetTotalResolveCount();
        exit;
    } 


?>