<?php
require_once("../core/conf/confBD.php");
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'uploads/';

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
if ($_FILES['arquivo']['error'] != 0) {
  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
  exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
  echo "Por favor, envie arquivos com as seguintes extensões: pdf, doc ou ppt";
  exit;
}

// Faz a verificação do tamanho do arquivo
if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
  echo "O arquivo enviado é muito grande, envie arquivos de até 5Mb.";
  exit;
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta


// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
  $nome_final = md5(time()).'.jpg';
} else {
  // Mantém o nome original do arquivo
  $nome_final = $_FILES['arquivo']['name'];
}

// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
  echo "Upload efetuado com sucesso!";
  
  try{
        $conexao = conn_mysql();
        
        
        $unidade_id = 3;
        $SQLInsert = 'INSERT INTO material_complementar (nome, unidade_id, caminho, tipo)
                                              VALUES (?,?,?,?)';
        //prepara a execução
        $operacao = $conexao->prepare($SQLInsert);					  

        //executa a sentença SQL com os parâmetros passados por um vetor
        $inserir = $operacao->execute(array($nome_final, $unidade_id, $_UP['pasta'], $extensao));


        // fecha a conexão ao banco
        $conexao = null;

        //verifica se o retorno da execução foi verdadeiro ou falso,
        //imprimindo mensagens ao cliente
        if ($inserir){
               
        }
        else {
           
        }
    }
    catch (PDOException $e){
        // caso ocorra uma exceção, exibe na tela
        echo "Erro!: " . $e->getMessage() . "<br>";
        die();
    }
    
  
  echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
} else {
  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
  echo "Não foi possível enviar o arquivo, tente novamente";
}
