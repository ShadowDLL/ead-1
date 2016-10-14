<?php
include_once("utils.php");

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED & ~E_NOTICE);
session_start();
testa_autenticacao();


try{
    $nome = utf8_encode(htmlspecialchars($_POST['name']));
    $aula = utf8_encode(htmlspecialchars($_POST['aula']));
    $id = utf8_encode(htmlspecialchars($_POST['id']));

    $conexao = conn_mysql();
    
    $SQLUpdate = 'UPDATE atividade SET nome = ?, unidade_id = ? WHERE id = ?';
    $operacao = $conexao->prepare($SQLUpdate);					  
    $atualiza = $operacao->execute(array($nome, $aula, $id));
    
    $SQLUpdate = 'UPDATE pergunta SET pergunta = ? WHERE id = ?';
    
    $operacao = $conexao->prepare($SQLUpdate);					  
    $atualiza = $operacao->execute(array($pergunta, $pergunta_id));
    $conexao = null;
    
    if($atualiza){
        include_once("../core/templates/cabecalho_adm.php");
        echo "<h1>Avaliação editada com sucesso.</h1>\n";
        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-2)\">Voltar para a tela de listagem de avaliações.</a></p>\n";
        include_once("../core/templates/rodape.php");
    }
    else{
        include_once("../core/templates/cabecalho_adm.php");
        echo "<h1>Erro na operacao.</h1>\n";
        $arr = $operacao->errorInfo();
        $erro = utf8_decode($arr[2]);
        echo "<p>$erro</p>";						
        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
        include_once("../core/templates/rodape.php");
    }
       
} 
catch (PDOException $e){
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>
