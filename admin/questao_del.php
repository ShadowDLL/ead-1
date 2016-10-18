<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();

    
    
    
    try{
        $conexao = conn_mysql();
        $id = $_GET['questao'];

        $SQLSelect = "DELETE FROM pergunta WHERE id = ".$id;

        $operacao = $conexao->prepare($SQLSelect);	
        $atualiza = $operacao->execute();
        if($atualiza){
            echo "<h1>Questão removida com sucesso</h1>\n";
            echo "<p><a href=\"javascript:window.history.go(-1);self.location.reload();\">Voltar para a página anterior.</a></p>\n";
        }
        
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }

    $conexao=null;
    
    
    
    include_once("../core/templates/rodape.php");
?>

