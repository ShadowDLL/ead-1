<?php
require_once("../core/conf/confBD.php");
function hex_to_bin($str) 
{
   $bin = "";
   $i = 0;
   do {
   	$bin .= chr(hexdec($str{$i}.$str{($i + 1)}));
   	$i += 2;
   } while ($i < strlen($str));
   return $bin;
}

if(isset($_GET['id'])){

    
 try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
$id = $_GET['id'];
$SQLSelect = "SELECT * FROM material_complementar WHERE id = ?";
print_r($SQLSelect);
//prepara a execução da sentença
$operacao = $conexao->prepare($SQLSelect);	
$operacao->execute(array($id));
 

$resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

if($resultados){
    foreach ($resultados as $resultado){
        $nome = $resultado['nome'];
        $tamanho = $resultado['tamanho'];
        $arquivo = $resultado['dados_documento'];
    }
} 
//echo $nome." ".$tamanho." ";die;

$nomeArquivo = $nome;
$file = fopen($nomeArquivo,"a+");
fwrite($file, hex2bin($arquivo));
fclose($file);

//Forçando o download...
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=" . $nomeArquivo);
header("Content-Length: " . $tamanho);
header("Content-Transfer-Encoding: binary");
readfile($nomeArquivo);

//Apagando o arquivo
unlink($nomeArquivo); 

}

?>	