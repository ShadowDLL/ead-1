<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<?php
require_once("../core/conf/confBD.php");
include_once ("../cursos/utils.php");

$usuario = utf8_encode(htmlspecialchars($_POST['usuario']));

try{
    $conexao = conn_mysql();
    $SQLSelect = "SELECT id, login FROM usuario WHERE login LIKE ?";
      
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array("%$usuario%"));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    $conexao=null;
      
    if($resultados){
        foreach ($resultados as $resultado) {

            echo "<h3>Aluno: ".$resultado['login']."</h3>";

            $usuario_id = $resultado['id'];

            relatorio($usuario_id);
        }
    }
    else{
        echo "Aluno ".$usuario." não foi encontrado";
    }
}
catch(PDOException $excep){
    echo "Erro!: " . $excep->getMessage() . "\n";
    $conexao=null;
    die();
}


?>