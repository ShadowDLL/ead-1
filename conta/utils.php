<?php
require_once("../core/conf/confBD.php");

function testa_autenticacao(){
    if(empty($_SESSION['auth'])||($_SESSION['auth']!=true)){
        header("Location:./acessoNegado.php");
        die();
    }
}

?>