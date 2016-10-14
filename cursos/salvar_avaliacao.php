<?php
include_once("utils.php");

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED & ~E_NOTICE);
session_start();
testa_autenticacao();

//print_r($_POST); 
//print_r($_SESSION);die;
$respostas = $_POST;
$atividade_id = $_POST['atividade'];
$usuario_id = $_SESSION['id'];

//print_r($_POST);
//die;

try{
    $conexao = conn_mysql();
    
    $SQLDelete = 'DELETE FROM usuario_alternativa WHERE atividade_id = ? AND usuario_id = ?';
    $operacao = $conexao->prepare($SQLDelete);					  
    $atualiza = $operacao->execute(array($atividade_id, $usuario_id));
    
    foreach ($respostas as $key => $value) {
        if(is_int ($key)){
            $SQLInsert = 'INSERT INTO usuario_alternativa(usuario_id, alternativa_id, pergunta_id, atividade_id) VALUES (?,?,?,?)';
            $operacao = $conexao->prepare($SQLInsert);					  
            $atualiza = $operacao->execute(array($usuario_id, $value , $key, $atividade_id));
        }
    }
    
    if($_POST['submit'] == 'Enviar'){
        $SQLInsert = 'INSERT INTO usuario_atividade(usuario_id, atividade_id) VALUES (?,?)';
        $operacao = $conexao->prepare($SQLInsert);					  
        $atualiza = $operacao->execute(array($usuario_id, $atividade_id));
        
        if($atualiza){
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Avaliação enviada com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior.</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
        else{
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
        
    }
    else{
        if($atualiza){
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Avaliação salva com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior.</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
        else{
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
    }
    
    
       
} 
catch (PDOException $e){
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>


