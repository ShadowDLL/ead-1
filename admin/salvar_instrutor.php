<?php
    include_once("utils.php");
    session_start();
    testa_autenticacao();
       
    
    try{
        $nome = utf8_encode(htmlspecialchars($_POST['name']));
        $id = utf8_encode(htmlspecialchars($_POST['id_instrutor']));
        
        $conexao = conn_mysql();

        $SQLInsert = 'UPDATE instrutor SET nome = ? WHERE id = ?';


        $operacao = $conexao->prepare($SQLInsert);					  
        $atualiza = $operacao->execute(array($nome, $id));

        $linha_afetada = $operacao->rowCount();

        if($atualiza){
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Instrutor alterado com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
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

        $conexao = null; 
        
        
        
    }
    catch (PDOException $e){
        echo "Erro!: " . $e->getMessage() . "<br>";
        die();
    }
    
?>

