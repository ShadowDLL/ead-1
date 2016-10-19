<?php
require_once("../core/conf/confBD.php");

function get_instrutores(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT * FROM instrutor order by nome';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

        //libera a conexão (dados já foram capturados)
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}
function get_instrutor($id){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT * FROM instrutor WHERE id = ?';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($id));

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

        //libera a conexão (dados já foram capturados)
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function get_categorias(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT * FROM categoria order by nome';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
    
    
}

function get_categoria($id){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT * FROM categoria WHERE id = ?';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($id));

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

        //libera a conexão (dados já foram capturados)
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function aulas(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT unidade.id, unidade.nome, unidade.descricao, unidade.ordem, curso.nome as curso FROM unidade inner join curso on unidade.curso_id = curso.id order by unidade.id, curso_id';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
    
    
}

function aulas_curso($curso){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT unidade.id, unidade.nome, unidade.descricao, unidade.ordem, curso.nome as curso FROM unidade inner join curso on unidade.curso_id = curso.id WHERE curso.id = ? order by unidade.id, curso_id';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso));

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}
function materiais(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT unidade.nome as unidade_nome, material.nome as material_nome, material.id, curso.nome as curso  FROM unidade inner join material on unidade.id = material.unidade_id '
               . 'INNER JOIN curso ON unidade.curso_id = curso.id';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
    
    
}

function atividades(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT unidade.nome as unidade_nome, atividade.nome as atividade_nome, atividade.id, curso.nome as curso  '
               . 'FROM unidade inner join atividade on unidade.id = atividade.unidade_id INNER JOIN curso ON unidade.curso_id = curso.id ORDER BY curso.nome, unidade.nome';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function cursos(){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT curso.id, curso.nome, curso.categoria_id, curso.descricao, curso.image, instrutor.nome as instrutor FROM curso inner join instrutor on instrutor.id = curso.instrutor_id order by curso.nome';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute();

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
    
}

function detalhes(){
    try{
        $conexao = conn_mysql();
        $curso_id = utf8_encode(htmlspecialchars($_GET['curso']));
 
        $SQLSelect = 'SELECT curso.id, curso.image, curso.nome, curso.categoria_id, curso.descricao, curso.sobre, instrutor.nome AS instrutor 
                      FROM curso INNER JOIN instrutor on instrutor.id = curso.instrutor_id 
                      WHERE curso.id = ?';
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso_id));

        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;
        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function detalhes_unidade_curso($id){
    try{
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT unidade.id, unidade.nome, unidade.descricao, unidade.ordem, curso.nome as curso_nome, curso.id as curso_id FROM unidade inner join curso on unidade.curso_id = curso.id WHERE unidade.id=?';
   
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($id));

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;

        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function lista_perguntas_avaliacao($avaliacao_id){
    //$SQLSelect = 'SELECT * FROM pergunta WHERE atividade_id = ?';
    $SQLSelect = 'SELECT pergunta, pergunta.id as id, sentenca '
               . 'FROM pergunta '
               . 'INNER JOIN alternativa ON pergunta.id = alternativa.pergunta_id '
               . 'INNER JOIN correta on correta.pergunta_id = pergunta.id and correta.alternativa_id = alternativa.id '
               . 'WHERE atividade_id = ?';
    
    try{
        $conexao = conn_mysql();
        
        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($avaliacao_id));
    
        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;
        
        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
    
}


function testa_autenticacao(){
    if(empty($_SESSION['auth'])||empty($_SESSION['adm'])||($_SESSION['adm']!=2)||($_SESSION['auth']!=true)){
        header("Location:./acessoNegado.php");
        die();
    }
}
?>