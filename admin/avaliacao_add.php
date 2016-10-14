<?php
    include_once("utils.php");
    
    session_start();
    testa_autenticacao();
    
    try{
        $nome = utf8_encode(htmlspecialchars($_POST['name']));
        $aula = utf8_encode(htmlspecialchars($_POST['aula']));
        
        $conexao = conn_mysql();
       
        $SQLInsert = 'INSERT INTO atividade (nome, unidade_id) VALUES(?,?)';


        $operacao = $conexao->prepare($SQLInsert);					  
        $atualiza = $operacao->execute(array($nome, $aula));

        if($atualiza){
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Avaliação cadastrada com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"./modificar_avaliacao.php\">Ir para a listagem de avaliações</a></p>\n";
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