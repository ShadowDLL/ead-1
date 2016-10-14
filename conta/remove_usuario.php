<?php
require_once("../core/conf/confBD.php");
include_once("./utils.php");
include_once("../core/templates/cabecalho.php");

testa_autenticacao();


try{
    $conexao = conn_mysql();
    $id = $_SESSION['id'];
    
    $SQLSelect = "DELETE FROM usuario WHERE id = ".$id;
 
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute();
}
catch(PDOException $excep){
    echo "Erro!: " . $excep->getMessage() . "\n";
    die();
}

$conexao=null;

$_SESSION = array();
session_destroy();


echo "<h1>Sua conta foi encerrada com sucesso</h1>\n";
echo "<p><a href=\"../home/index.php\">Ir para a página inicial.</a></p>\n";
include_once("../core/templates/rodape.php");
die();


    
     
?>