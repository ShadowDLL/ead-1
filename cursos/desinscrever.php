<?php
include_once ("./utils.php");
require_once("../core/conf/confBD.php");

session_start();
testa_autenticacao();

print_r($_SESSION);
$curso_id = $_GET['curso'];


try{
    $conexao = conn_mysql();

    $usuario_id = utf8_encode(htmlspecialchars($_SESSION['id']));
    $curso_id = utf8_encode(htmlspecialchars($_GET['curso']));


    $SQLInsert = 'DELETE FROM inscrito WHERE usuario_id = ? AND curso_id = ?';
    
    //prepara a execução
    $operacao = $conexao->prepare($SQLInsert);					  

    //executa a sentença SQL com os parâmetros passados por um vetor
    $inserir = $operacao->execute(array($usuario_id, $curso_id));


    // fecha a conexão ao banco
    $conexao = null;

    //verifica se o retorno da execução foi verdadeiro ou falso,
    //imprimindo mensagens ao cliente
    if ($inserir){

            include_once("../core/templates/cabecalho.php");
            echo "<h1>Voce se desinscreveu no curso com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"../conta/painel.php\">Painel</a></p>\n";
            include_once("../core/templates/rodape.php");
    }
    else {
        include_once("../core/templates/cabecalho.php");
        echo "<h1>Erro na operacao.</h1>\n";
        $arr = $operacao->errorInfo();
        $erro = utf8_decode($arr[2]);
        echo "<p>$erro</p>";						
        echo "<p><a href=\"javascript:history.back()\">Retornar</a></p>\n";
        include_once("../core/templates/rodape.php");
    }
}
catch (PDOException $e){
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>


