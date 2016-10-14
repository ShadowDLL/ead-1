<?php
    session_start();

    $_SESSION = array();
    session_destroy();
    
    //print_r($_SESSION);
    header("Location: ../admin/index.php");	
?>