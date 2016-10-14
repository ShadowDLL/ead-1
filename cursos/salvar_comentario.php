<?php
include_once("utils.php");

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED & ~E_NOTICE);
session_start();
testa_autenticacao();


$comentario = utf8_encode(htmlspecialchars($_POST['comentario']));
$curso_id = $_POST['curso_id'];
$usuario_id = $_POST['usuario_id'];

try{
  
    $conexao = conn_mysql();
    
    $SQLDelete = 'DELETE FROM avaliacao_curso WHERE curso_id = ? AND usuario_id = ?';
    $operacao = $conexao->prepare($SQLDelete);					  
    $atualiza = $operacao->execute(array($curso_id, $usuario_id));
     
    $SQLInsert = 'INSERT INTO avaliacao_curso(comentario, curso_id, usuario_id) VALUES (?,?,?)';
    $operacao = $conexao->prepare($SQLInsert);					  
    $atualiza = $operacao->execute(array($comentario, $curso_id, $usuario_id));
     	
    header("Location: ".$_SERVER['HTTP_REFERER']."");   
} 
catch (PDOException $e){
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>


