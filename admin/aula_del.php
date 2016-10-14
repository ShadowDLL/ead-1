<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    //print_r($_GET);
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['aula'];

        $SQLSelect = "DELETE FROM unidade WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    echo "<h1>Aula removida com sucesso</h1>\n";
    echo "<p><a href=\"./modificar_aula.php\">Voltar para a listagem de aulas.</a></p>\n";
    
    include_once("../core/templates/rodape.php");
?>
