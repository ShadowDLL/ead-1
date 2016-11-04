<?php
include_once("utils.php");
    
session_start();
testa_autenticacao();

try{
    $pergunta_id = utf8_encode(htmlspecialchars($_POST['questao']));
    $pergunta = utf8_encode(htmlspecialchars($_POST['pergunta']));
    $alternativas = $_POST['alternativa'];
    $resposta = utf8_encode(htmlspecialchars($_POST['resposta']));
    
  
    $conexao = conn_mysql();
    $conexao->beginTransaction();
    
    $SQLDelete = 'DELETE FROM alternativa WHERE pergunta_id = ?';
    $operacao = $conexao->prepare($SQLDelete);					  
    $atualiza = $operacao->execute(array($pergunta_id));
    
    if(!$atualiza){
        include_once("../core/templates/cabecalho_adm.php");
        echo "<h1>Erro na operacao.</h1>\n";
        $arr = $operacao->errorInfo();
        $erro = utf8_decode($arr[2]);
        echo "<p>$erro</p>";						
        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
        include_once("../core/templates/rodape.php");
        $conexao->rollBack();
        $conexao = null;
        die;
    }
    
    $SQLUpdate = 'UPDATE pergunta SET pergunta = ? WHERE id = ?';
    
    $operacao = $conexao->prepare($SQLUpdate);					  
    $atualiza = $operacao->execute(array($pergunta, $pergunta_id));

    if(!$atualiza){
        include_once("../core/templates/cabecalho_adm.php");
        echo "<h1>Erro na operacao.</h1>\n";
        $arr = $operacao->errorInfo();
        $erro = utf8_decode($arr[2]);
        echo "<p>$erro</p>";						
        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
        include_once("../core/templates/rodape.php");
        $conexao->rollBack();
        $conexao = null;
        die;
    }
    
    foreach ($alternativas as $chave => $alternativa){
        $SQLInsert = 'INSERT INTO alternativa (sentenca, pergunta_id) VALUES(?, ?)';
   
        $operacao = $conexao->prepare($SQLInsert);					  
        $atualiza = $operacao->execute(array(utf8_encode(htmlspecialchars($alternativa)), $pergunta_id));
        
        if(!$atualiza){
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Erro na operacao.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
            $conexao->rollBack();
            $conexao = null;
            die;
        }
        
        $alternativa_id = $conexao->lastInsertId();
        
        if($_POST['resposta'] == $chave){
            $SQLInsert = 'INSERT INTO correta (pergunta_id, alternativa_id) VALUES(?, ?)';
            $operacao = $conexao->prepare($SQLInsert);					  
            $atualiza = $operacao->execute(array($pergunta_id, $alternativa_id));
            
            if(!$atualiza){
                include_once("../core/templates/cabecalho_adm.php");
                echo "<h1>Erro na operacao.</h1>\n";
                $arr = $operacao->errorInfo();
                $erro = utf8_decode($arr[2]);
                echo "<p>$erro</p>";						
                echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
                include_once("../core/templates/rodape.php");
                $conexao->rollBack();
                $conexao = null;
                die;
            }
        }
        
    }
    
    $conexao->commit();
    $conexao = null;
    
    include_once("../core/templates/cabecalho_adm.php");
    echo "<h1>Questão editada com sucesso.</h1>\n";
    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-2);self.location.reload();\">Voltar para a tela de edição da avaliação.</a></p>\n";
    include_once("../core/templates/rodape.php");
}
catch (PDOException $e){
    $conexao->rollBack();
    
    include_once("../core/templates/cabecalho_adm.php");
    echo "<h1>Erro na operacao.</h1>\n";
    $arr = $operacao->errorInfo();
    $erro = utf8_decode($arr[2]);
    echo "<p>$erro</p>";
    echo "<br>Erro!: " . $e->getMessage() . "<br>";
    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
    include_once("../core/templates/rodape.php");
    
    $conexao = null;
    die();
}
 
?>
