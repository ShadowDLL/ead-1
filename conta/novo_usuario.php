<?php
    require_once("../core/conf/confBD.php");
    
    /*
    $origem = basename($_SERVER['HTTP_REFERER']);
    if((count($_POST)!=4)&&($origem!='registro.php')){
	header("Location:./acessoNegado.php");
	die();
    }
    */
    try{
        $conexao = conn_mysql();
        
        $login = utf8_encode(htmlspecialchars($_POST['login']));
        $senha = utf8_encode(htmlspecialchars($_POST['passwd1']));
        $senhaConf = utf8_encode(htmlspecialchars($_POST['passwd2']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));

        //print_r($_POST);

        if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            echo "<p>As senhas nao se conferem ou possuem tamanhos menores que quatro caracteres ou maiores que oito.</p>";
            echo "<p><a href=\"./registro.php\">Retornar</a></p>\n";
            include_once("../core/templates/rodape.php");
            die();
        }

        $SQLInsert = 'INSERT INTO usuario (login, password, email, tipo_id)
                                              VALUES (?,MD5(?),?,1)';

        //prepara a execução
        $operacao = $conexao->prepare($SQLInsert);					  

        //executa a sentença SQL com os parâmetros passados por um vetor
        $inserir = $operacao->execute(array($login, $senha, $email));


        // fecha a conexão ao banco
        $conexao = null;

        //verifica se o retorno da execução foi verdadeiro ou falso,
        //imprimindo mensagens ao cliente
        if ($inserir){
                
                include_once("../core/templates/cabecalho.php");
                echo "<h1>Cadastro efetuado com sucesso.</h1>\n";
                echo "<p class=\"lead\"><a href=\"./login.php\">Pagina de login</a></p>\n";
                include_once("../core/templates/rodape.php");
        }
        else {
            include_once("../core/templates/cabecalho.php");
            echo "<h1>Erro na operacao.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p><a href=\"./registro.php\">Retornar</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
    }
    catch (PDOException $e){
        // caso ocorra uma exceção, exibe na tela
        echo "Erro!: " . $e->getMessage() . "<br>";
        die();
    }
?>