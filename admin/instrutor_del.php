<?php

    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['instrutor'];
        
        $SQLSelect = "DELETE FROM instrutor WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    echo "<h1>Instrutor removido com sucesso</h1>\n";
    echo "<p><a href=\"./modificar_instrutor.php\">Voltar para a listagem de instrutores.</a></p>\n";
    
    include_once("../core/templates/rodape.php");
?>
