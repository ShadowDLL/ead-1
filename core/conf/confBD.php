<?php
 function conn_mysql(){

   $servidor = 'localhost';
   //$servidor = 'mysql.hostinger.com.br';
   $porta = 3306;
   $banco = "stv";
   $usuario = "root";
   //$usuario = "stv";
   $senha = "";
   //$senha = "pucminas";
   
   
      $conn = new PDO("mysql:host=$servidor;
	                   port=$porta;
					   dbname=$banco", 
					   $usuario, 
					   $senha,
					   array(PDO::ATTR_PERSISTENT => true)
					   );
      return $conn;
   }
?>