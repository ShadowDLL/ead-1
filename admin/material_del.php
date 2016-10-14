<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['material'];

        $SQLSelect = "DELETE FROM material WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    echo "<h1>Material removido com sucesso</h1>\n";
    echo "<p><a href=\"./modificar_material.php\">Voltar para a listagem de materiais.</a></p>\n";
    
    include_once("../core/templates/rodape.php");
?>