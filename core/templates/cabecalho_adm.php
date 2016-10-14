<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EAD - Uma plataforma de ensino a distância"/>
    <title>EAD</title>
    <link rel="stylesheet" href="../core/css/styles.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="content container">
    <nav class="navbar navbar-inverse">
	<div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	      </button>
	      <a class="navbar-brand" href="#">Learn Alone - Administração</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                <?php
                    if(empty($_SESSION)){
                        session_start();   
                    }
                    
                    if(empty($_SESSION['auth'])||($_SESSION['auth']!=true)){
                ?>
                        <li><a href="../admin/index.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <?php
                    }
                    else{
                 ?>
                        <li><a href="../admin/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                <?php   
                    }
                ?>
                </ul>
	    </div>
	</div>
    </nav>
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

