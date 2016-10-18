<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['curso'];

        $SQLSelect = "DELETE FROM curso WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    echo "<h1>Curso removido com sucesso</h1>\n";
    echo "<p><a href=\"./modificar_curso.php\">Voltar para a listagem de cursos.</a></p>\n";
    
    include_once("../core/templates/rodape.php");
?>