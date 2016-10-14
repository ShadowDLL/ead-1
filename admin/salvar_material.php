<?php
include_once("utils.php");

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED & ~E_NOTICE);
session_start();
testa_autenticacao();

try{
    $nome = utf8_encode(htmlspecialchars($_POST['name']));
    $aula = utf8_encode(htmlspecialchars($_POST['aula']));
    $video = utf8_encode(htmlspecialchars($_POST['video']));
    $id = utf8_encode(htmlspecialchars($_POST['id']));
    $arquivo = $_FILES['file'];

    //print_r($_POST);
    //print_r($_FILES);
    
    if (!empty($_POST['video'])){
        
        $conexao = conn_mysql();
        $SQLInsert = 'UPDATE material SET nome=?, embedded =?, unidade_id=?, filepath=? WHERE id=?';
        //prepara a execução
        $operacao = $conexao->prepare($SQLInsert);					  
        //executa a sentença SQL com os parâmetros passados por um vetor
        $inserir = $operacao->execute(array($nome, $video, $aula, NULL, $id));
        // fecha a conexão ao banco
        $conexao = null;
       
        if ($inserir){
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Material alterado com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"./modificar_material.php\">Ir para a listagem de materiais</a></p>\n";
            include_once("../core/templates/rodape.php");
        }
        else {
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Erro na operacao.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = utf8_decode($arr[2]);
            echo "<p>$erro</p>";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
        }   
    }
    else{       
        // Pasta onde o arquivo vai ser salvo
        $_UP['pasta'] = '../cursos/uploads/';

        // Tamanho máximo do arquivo (em Bytes)
        $_UP['tamanho'] = 1024 * 1024 * 5; // 5Mb

        // Array com as extensões permitidas
        $_UP['extensoes'] = array('pdf', 'doc', 'ppt');

        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
        $_UP['renomeia'] = false;

        // Array com os tipos de erros de upload do PHP
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
        
        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
        if ($_FILES['file']['error'] != 0) {
            include_once("../core/templates/cabecalho_adm.php");
            echo "<h1>Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']] . "</h1>\n";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a pagina anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
            exit; // Para a execução do script
        }
        
        // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
        // Faz a verificação da extensão do arquivo
        $extensao = strtolower(end(explode('.', $_FILES['file']['name'])));
        if (array_search($extensao, $_UP['extensoes']) === false) {
            include_once("../core/templates/cabecalho_adm.php");
            echo "Por favor, envie arquivos com as seguintes extensões: pdf, doc ou ppt";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a pagina anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
            exit;
        }

        // Faz a verificação do tamanho do arquivo
        if ($_UP['tamanho'] < $_FILES['file']['size']) {
            include_once("../core/templates/cabecalho_adm.php");
            echo "O arquivo enviado é muito grande, envie arquivos de até 5Mb.";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a pagina anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
            exit;
        }
        
        // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
        // Primeiro verifica se deve trocar o nome do arquivo
        if ($_UP['renomeia'] == true) {
          // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
          $nome_final = md5(time()).'.jpg';
        } else {
          // Mantém o nome original do arquivo
          $nome_final = $_FILES['file']['name'];
        }
        
        // Depois verifica se é possível mover o arquivo para a pasta escolhida
        if (move_uploaded_file($_FILES['file']['tmp_name'], $_UP['pasta'] . $nome_final)) {
            $conexao = conn_mysql();

            $SQLInsert = 'UPDATE material SET nome=?, unidade_id=?, filepath=?, tipo=?, embedded =? WHERE id=?';
            //$SQLInsert = 'UPDATE material SET nome=?,unidade_id=?, filepath=? WHERE id=?';
            //prepara a execução
            $operacao = $conexao->prepare($SQLInsert);					  
            //executa a sentença SQL com os parâmetros passados por um vetor
            $inserir = $operacao->execute(array($nome, $aula, $_UP['pasta'].$nome_final, $extensao, NULL, $id));
            
            // fecha a conexão ao banco
            $conexao = null;
            //verifica se o retorno da execução foi verdadeiro ou falso,
            //imprimindo mensagens ao cliente
            if ($inserir){
                include_once("../core/templates/cabecalho_adm.php");
                echo "<h1>Material alterado com sucesso.</h1>\n";
                echo "<p class=\"lead\"><a href=\"./modificar_material.php\">Ir para a listagem de materiais</a></p>\n";
                include_once("../core/templates/rodape.php");
            }
            else {
                include_once("../core/templates/cabecalho_adm.php");
                echo "<h1>Erro na operacao.</h1>\n";
                $arr = $operacao->errorInfo();
                $erro = utf8_decode($arr[2]);
                echo "<p>$erro</p>";						
                echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
                include_once("../core/templates/rodape.php");
            }
        } 
        else {
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            include_once("../core/templates/cabecalho_adm.php");
            echo "Não foi possível enviar o arquivo, tente novamente";						
            echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a pagina anterior</a></p>\n";
            include_once("../core/templates/rodape.php");
            exit;
        }  
    }
} 
catch (PDOException $e){
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}



?>
