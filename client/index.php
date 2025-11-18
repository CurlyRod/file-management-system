<?php
session_start();
if(isset($_SESSION['email']) || !empty(trim($_SESSION['email'])))
{
    header("location: ./myfiles/"); 
    exit; 
}
else
{
    header("Location: ../");  
    exit; 
}
?> 
