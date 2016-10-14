<?php
require_once("../core/conf/confBD.php");
//print_r($_POST);

try{
    $origem = basename($_SERVER['HTTP_REFERER']);

    //tem que ter dados nos 6 campos do formulario
    if(($origem!='editar_senha.php')){
            header("Location:./acessoNegado.php");
            die();
    }
    else{
        $senha_antiga = utf8_encode(htmlspecialchars($_POST['passwd-old']));
        $nova_senha = utf8_encode(htmlspecialchars($_POST['passwd1']));
        $confirmacao_senha = utf8_encode(htmlspecialchars($_POST['passwd2']));
        $login = utf8_encode(htmlspecialchars($_POST['usuario']));
        
        if(($nova_senha!=$confirmacao_senha)||(strlen($nova_senha)<4)||(strlen($nova_senha)>8)){
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            echo "<p>As senhas nao se conferem ou possuem tamanhos menores que quatro caracteres ou maiores que oito.</p>";
            echo "<p><a href=\"./editar_senha.php\">Retornar</a></p>\n";
            include_once("../core/templates/rodape.php");
            die();
        }

        $conexao = conn_mysql();

        $SQLInsert = 'UPDATE usuario SET password = MD5(?) WHERE password = MD5(?)';
        
        $operacao = $conexao->prepare($SQLInsert);					  
        $atualiza = $operacao->execute(array($nova_senha, $senha_antiga));
        
        $linha_afetada = $operacao->rowCount();

        $conexao = null; 
        

        if ( $linha_afetada > 0){
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Senha alterada com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"./editar_senha.php\">Voltar para a página anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
        }

        else{
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            echo "<p>Senha antiga incorreta ou a nova senha coincide com a senha antiga.</p>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p><a href=\"./editar_senha.php\">Retornar</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
    }
}
catch (PDOException $e){
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();

}


?>
