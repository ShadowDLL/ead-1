<?php
require_once("../core/conf/confBD.php");

function cursos(){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT curso.id, curso.nome, curso.categoria_id, curso.descricao, curso.image, instrutor.nome as instrutor FROM curso inner join instrutor on instrutor.id = curso.instrutor_id order by curso.nome';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute();

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
    
    return $resultados;
}

function detalhes($curso_id){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $curso_id = utf8_encode(htmlspecialchars($curso_id));
 
    //$SQLSelect = 'SELECT * FROM curso where id = ?';
    $SQLSelect = 'SELECT curso.id, curso.image, curso.nome, curso.categoria_id, curso.descricao, curso.sobre, instrutor.nome AS instrutor 
                  FROM curso INNER JOIN instrutor on instrutor.id = curso.instrutor_id 
                  WHERE curso.id = ?';
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($curso_id));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    return $resultados;
}

function testa_autenticacao(){
    if(empty($_SESSION['auth'])||($_SESSION['auth']!=true)){
        header("Location:../conta/acessoNegado.php");
        die();
    }
}
function lista_cursos_usuario($usuario_id){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    
    $SQLSelect = 'SELECT curso.nome, curso.descricao, curso.id as curso_id, curso.nome as curso_nome, instrutor.nome as instrutor '
               . 'FROM curso inner join inscrito on inscrito.curso_id = curso.id inner join usuario on '
               . 'usuario.id = inscrito.usuario_id inner join instrutor on instrutor.id = curso.instrutor_id '
               . 'where usuario.id = ?';
    
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($usuario_id));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;    
}
function gera_menu_cursos($usuario_id){
    $cursos = lista_cursos_usuario($usuario_id);
    
    if($cursos){
        foreach($cursos as $curso){
            echo "<li><a data-toggle=\"collapse\" href=\"#".str_replace(" ","",$curso['nome'])."\"><span class=\"glyphicon glyphicon-book\"> ".utf8_decode($curso['nome'])."</span></a></li>";
            echo "<div id=\"".str_replace(" ","",$curso['nome'])."\" class=\"panel-collapse collapse\">";
            echo "<div class=\"panel-body\">";
            echo "<a href=\"../cursos/curso.php?id=".$curso['curso_id']."&nome=".$curso['nome']."\"><i class=\"glyphicon glyphicon-facetime-video\"></i> Aulas e Materiais</a>";
            echo "</div>";
            //echo "<div class=\"panel-body\">";
            //echo "<a href=\"#\"><i class=\"glyphicon glyphicon-info-sign\"></i> Informacoes</a>";
            //echo "</div>";
            //echo "<div class=\"panel-body\">";
            //echo "<a href=\"#\"><i class=\"glyphicon glyphicon-envelope\"></i> Anuncios</a>";
            //echo "</div>";
            echo "</div>";   
        }
    }
}

function lista_cursos_inscritos($usuario_id){
    $cursos = lista_cursos_usuario($usuario_id);
    
    if($cursos){
        foreach($cursos as $curso){
            echo "<div class=\"well\">";
            echo "<h3>".utf8_decode($curso['nome'])."</h3>";
            echo utf8_decode($curso['descricao']);
            echo "<p>Instrutor: ".utf8_decode($curso['instrutor'])."</p>";
            echo "<div class=\"btn-group-sm\">";
            echo "<a href=\"../cursos/curso.php?id=".$curso['curso_id']."&nome=".utf8_decode($curso['curso_nome'])."\" class=\"btn btn-info\"> Acessar</a>"; 
            echo "<a href=\"../cursos/desinscrever.php?curso=".$curso['curso_id']."\" class=\"btn btn-danger\">Cancelar</a>";
            echo "</div>";
            echo "</div>";
        }
    }
    else{
            echo "<aside class=\"pure-u-1\">";
            echo "<p>Nenhum curso inscrito</p>";
            echo "</aside>";
    
    }
}


function lista_video_unidade_curso($id_curso, $unidade){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT material.id, material.nome, material.embedded FROM unidade inner join material on unidade.id = material.unidade_id WHERE curso_id = ? and unidade.id = ?';

    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($id_curso, $unidade));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;
}

function lista_material_unidade_curso($id_curso, $unidade){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT * FROM unidade INNER JOIN material ON unidade.id = material.unidade_id WHERE curso_id = ? and unidade.id = ? AND filepath IS NOT NULL';

    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($id_curso, $unidade));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;
}

function lista_unidades_curso($id_curso){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT DISTINCT unidade.id, unidade.nome, unidade.descricao, curso.nome as curso_nome FROM `curso` inner join unidade on unidade.curso_id = curso.id WHERE curso_id = ? ORDER BY unidade.ordem';

    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($id_curso));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;
}

function retorna_video($id){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT embedded FROM material WHERE id = ?';

    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($id));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;
}

function retorna_material_complementar($id){
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT nome, arquivo, id FROM material_complementar WHERE id = ?';

    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($id));
 
    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    
    //libera a conexão (dados já foram capturados)
    $conexao=null;
   
    return $resultados;
}

function retorna_atividade_unidade($unidade_id){
    try{
        
        $conexao = conn_mysql();
        $SQLSelect = 'SELECT * FROM atividade WHERE unidade_id = ?';

        //prepara a execução da sentença
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($unidade_id));

        //captura TODOS os resultados obtidos
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

        $conexao=null;
   
        return $resultados;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }     
}

function retorna_questao_atividade($atividade_id){
    $SQLSelect = 'SELECT * FROM pergunta WHERE atividade_id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($atividade_id));
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

function retorna_alternativas($pergunta_id){
    $SQLSelect = 'SELECT * FROM alternativa WHERE pergunta_id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($pergunta_id));
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

function retorna_resposta_usuario($pergunta_id, $usuario_id){
    $SQLSelect = 'SELECT * FROM usuario_alternativa WHERE pergunta_id = ? AND usuario_id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($pergunta_id, $usuario_id));
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

function atividade_foi_realizada($usuario_id, $avaliacao){
    $SQLSelect = 'SELECT * FROM usuario_atividade WHERE usuario_id = ? AND atividade_id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($usuario_id, $avaliacao));
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

function retorna_atividades($id){
    $SQLSelect = 'SELECT * FROM atividade WHERE id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($id));
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

function confere_resposta($pergunta, $usuario){
    $SQLSelect = 'SELECT sentenca, alternativa.id FROM pergunta '
               . 'INNER JOIN alternativa ON pergunta.id = alternativa.pergunta_id '
               . 'INNER JOIN correta ON correta.pergunta_id = pergunta.id '
               . 'AND correta.alternativa_id = alternativa.id AND pergunta.id = ?';
    
  
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($pergunta));
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        
        $solucao = $resultados;
        
        $SQLSelect =  'SELECT alternativa_id FROM usuario_alternativa WHERE  usuario_id = ? AND pergunta_id = ?';
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($usuario, $pergunta));
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        
        $resposta_usuario = $resultados;
        $conexao=null;
        
        if($solucao[0]['id'] == $resposta_usuario[0]['alternativa_id']){
            echo "<span class=\"label label-success\">Sua resposta está correta.</span>";
        }
        else{
            echo "<h5><span class=\"label label-danger\">Sua resposta está errada.</span></h5>";
            echo "<h5><span class=\"label label-danger\">A resposta correta é: ". $solucao[0]['sentenca']."</span></h5>";
        }
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function calcula_videos_curso($curso){
   $SQLSelect = 'SELECT count(embedded) as videos, curso_id as curso '
              . 'FROM unidade '
              . 'INNER JOIN material ON unidade.id = material.unidade_id '
              . 'WHERE embedded IS NOT NULL AND curso_id = ? group by curso_id';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso));
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

function computa_videos_visualizados($curso_id, $usuario_id){
    $SQLSelect = 'SELECT count(*) as visualizados from material_usuario '
               . 'INNER JOIN unidade ON material_usuario.unidade_id = unidade.id '
               . 'INNER JOIN curso ON curso.id = unidade.curso_id WHERE curso.id = ? AND usuario_id = ?';

    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso_id, $usuario_id));
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

function acima_70_por_cento_curso($id_usuario, $id_curso){
    
    $SQLSelect = 'SELECT unidade.id FROM unidade INNER JOIN curso ON curso.id = unidade.curso_id WHERE curso.id = ?';
    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($id_curso));
        $unidades = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;
       
        
        foreach ($unidades as $unidade){
            
            $conexao = conn_mysql();
            $operacao = $conexao->prepare("CALL conta_acerto(:id_usuario,:id_unidade,@saida)");
            $operacao->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $operacao->bindParam(':id_unidade', $unidade['id'], PDO::PARAM_INT);
            $operacao->execute();
            $result = $operacao->fetchAll(PDO::FETCH_ASSOC);
            
            $row = $conexao->query("SELECT @saida AS saida")->fetch(PDO::FETCH_ASSOC);
            
            if($row['saida'] < 0.70) {
                
               $conexao = null;
               return false;
            }
            $conexao = null;
        }
        return true;;

    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function acima_70_por_cento_unidade($id_usuario, $id_unidade){    
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare("CALL conta_acerto(:id_usuario,:id_unidade,@saida)");
        $operacao->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $operacao->bindParam(':id_unidade', $id_unidade, PDO::PARAM_INT);
        $operacao->execute();
        $result = $operacao->fetchAll(PDO::FETCH_ASSOC);

        $row = $conexao->query("SELECT @saida AS saida")->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $conexao = null;
            return $row['saida'];
        }

        $conexao = null;
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        $conexao=null;
        die();
    }
}

function viu_todos_videos($id_usuario, $id_curso){
    $visualizados = computa_videos_visualizados($id_curso, $id_usuario)[0]['visualizados'];
    $total_videos = calcula_videos_curso($id_curso)[0]['videos'];
    $viu_todos;
    
    if($visualizados == $total_videos){
        $viu_todos = TRUE;
    }
    else {
        $viu_todos = FALSE;
    }
    
    return $viu_todos;

}

function testa_aptidao($id_usuario, $id_curso){
    $bom_desempenho = acima_70_por_cento_curso($id_usuario, $id_curso);
    $viu_todos = viu_todos_videos($id_usuario, $id_curso);
    return ($bom_desempenho && $viu_todos);
}

function recupera_nota($curso_id, $usuario_id){
    $SQLSelect = 'SELECT * FROM post_rating WHERE curso_id = ? AND usuario_id = ?';

    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso_id, $usuario_id));
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

function retorna_comentario($curso_id, $usuario_id){
    $SQLSelect = 'SELECT comentario FROM avaliacao_curso WHERE curso_id = ? AND usuario_id = ?';

    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso_id, $usuario_id));
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

function retorna_avaliacoes($curso_id){
    $SQLSelect = 'SELECT usuario.login, comentario, rating_number '
               . 'FROM avaliacao_curso '
               . 'INNER JOIN post_rating '
               . 'ON avaliacao_curso.curso_id = post_rating.curso_id AND avaliacao_curso.usuario_id = post_rating.usuario_id '
               . 'INNER JOIN usuario '
               . 'ON usuario.id = post_rating.usuario_id and avaliacao_curso.usuario_id = usuario.id '
               . 'WHERE avaliacao_curso.curso_id = ? ORDER BY rating_number';

    try{
        $conexao = conn_mysql();
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

function lista_cursos_inscritos_admin($usuario_id){
    $cursos = lista_cursos_usuario($usuario_id);
    
    if($cursos){
        foreach($cursos as $curso){
            echo "<div class=\"well\">";
            echo "<h3>".utf8_decode($curso['nome'])."</h3>";
            echo utf8_decode($curso['descricao']);
            echo "<p>Instrutor: ".utf8_decode($curso['instrutor'])."</p>";
            echo "<div class=\"btn-group-sm\">";
            echo "</div>";
            lista_desempenho_curso($usuario_id, $curso['curso_id']);
            echo "</div>";
        }
    }
    else{
            echo "<aside class=\"pure-u-1\">";
            echo "<p>Nenhum curso inscrito</p>";
            echo "</aside>";
    
    }
}

function lista_desempenho_curso($usuario_id, $curso_id){
     $SQLSelect = 'SELECT unidade.nome, unidade.id FROM unidade INNER JOIN curso WHERE unidade.curso_id = curso.id AND curso.id = ?';
     
    try{
        $conexao = conn_mysql();
        $operacao = $conexao->prepare($SQLSelect);	
        $operacao->execute(array($curso_id));
        $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
        $conexao=null;
        
        $unidades = $resultados;
        if($unidades){
            echo "<table>";
            echo "<tr>";
            echo "<th>Módulo</th>";
            echo "<th>Percentual de acerto</th>";
            echo "</tr>";
            foreach ($unidades as $unidade){
                echo "<tr>";
                echo "<td>".$unidade['nome']."</td>";
                echo "<td>".(acima_70_por_cento_unidade($usuario_id, $unidade['id']) * 100)."%</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            $visualizados = computa_videos_visualizados($curso_id, $usuario_id)[0]['visualizados'];
            $total_videos = calcula_videos_curso($curso_id)[0]['videos'];
            echo "<p>Quantidade de vídeos do curso: ".$total_videos."</p>";
            echo "<p>Quantidade de vídeos visualizados pelo aluno: ".$visualizados."</p>";
            echo "<p>Percentual de vídeos visualizados do curso: ".($visualizados / $total_videos * 100)."%</p>"; 
            
            $apto = testa_aptidao($usuario_id, $curso_id);
            if($apto == TRUE){
                echo "<span class=\"label label-success\">Aprovado.</span>";
            }
            else{
                echo "<span class=\"label label-danger\">Ainda não Aprovado.</span>";
            }
        }
        
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        //$conexao=null;
        die();
    }
}
function relatorio($usuario_id){
    lista_cursos_inscritos_admin($usuario_id);
    
     
}
?>