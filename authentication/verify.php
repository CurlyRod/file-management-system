<?php 
session_start();
if ( !isset($_SESSION['email']) || empty(trim($_SESSION['email'])) )
{   
    header("Location: ../../"); 
    exit;
}
?>