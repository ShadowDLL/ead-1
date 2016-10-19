<?php

    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['categoria'];
        
        $SQLSelect = "DELETE FROM categoria WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    echo "<h1>Categoria removida com sucesso</h1>\n";
    echo "<p><a href=\"./modificar_categoria.php\">Voltar para a listagem de categorias.</a></p>\n";
    
    include_once("../core/templates/rodape.php");
?>
