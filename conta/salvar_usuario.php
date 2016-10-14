<?php
    require_once("../core/conf/confBD.php");
    include_once("./utils.php");
    session_start();

    testa_autenticacao();

    try{
        $origem = basename($_SERVER['HTTP_REFERER']);
        
	//tem que ter dados nos 6 campos do formulario
	if(($origem!='editar_conta.php')){
		header("Location:./acessoNegado.php");
		die();
	}
	else{
            $email = utf8_encode(htmlspecialchars($_POST['email']));
            $login = utf8_encode(htmlspecialchars($_POST['usuario']));
            $first_name = utf8_encode(htmlspecialchars($_POST['first_name']));
            $last_name = utf8_encode(htmlspecialchars($_POST['last_name']));
            $id = utf8_encode(htmlspecialchars($_SESSION['id']));
            
            $conexao = conn_mysql();
            
            $SQLInsert = 'UPDATE usuario SET email = ?, login = ?, first_name = ?, last_name = ? WHERE id = ?';
            $operacao = $conexao->prepare($SQLInsert);					  
            $atualiza = $operacao->execute(array($email, $login, $first_name, $last_name, $id));
            
            $conexao = null;

            
            if ($atualiza){

                include_once("../core/templates/cabecalho.php");
                echo "<h1>Conta alterada com sucesso.</h1>\n";
                echo "<p class=\"lead\"><a href=\"./editar_conta.php\">Voltar para a página anterior</a></p>\n";
                include_once("../core/templates/rodape.php");
                
                //Renova alguns dados de sessao do usuario
                $_SESSION['usuario'] = $login;
                $_SESSION['email'] = $email;
            }
            
            else{
                include_once("../core/templates/cabecalho.php");
                echo "<h1>Erro na operacao.</h1>\n";
                $arr = $operacao->errorInfo();
                $erro = utf8_decode($arr[2]);
                echo "<p>$erro</p>";						
                echo "<p><a href=\"./editar_conta.php\">Retornar</a></p>\n";
                include_once("../core/templates/rodape.php");
            }
        }
    }
    catch (PDOException $e){
        echo "Erro!: " . $e->getMessage() . "<br>";
        die();
     
    }

?>