<?php
//Database configuration
$dbHost = 'localhost';
//$dbHost = 'mysql.hostinger.com.br';
$dbUsername = 'root';
//$dbUsername = 'stv';
$dbPassword = '';
//$dbPassword = 'pucminas';
$dbName = 'stv';

//Connect with the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if($db->connect_errno):
    die('Connect error:'.$db->connect_error);
endif;
?>