<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $avaliacao = $_GET['atividade'];
    
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT unidade.nome as unidade_nome, atividade.nome as atividade_nome, atividade.id, curso.nome as curso, curso.id as curso_id FROM unidade inner join atividade on unidade.id = atividade.unidade_id INNER JOIN curso ON unidade.curso_id = curso.id WHERE atividade.id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($avaliacao));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    //print_r($resultados);
    //libera a conexão (dados já foram capturados)
    $conexao=null;
    //echo "<br>";
    $aulas = aulas_curso($resultados[0]['curso_id']);
   // print_r($resultados); 
   // die;
    
   
?>
<script src="../ckeditor/ckeditor.js"></script> 
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_avaliacao.php">Avaliações</a></li>
        <li><a href="javascript:window.history.go(-1)">Editar Avaliação</a></li>
        <li>Adicionar Questão</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="questao_add.php">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($resultados[0]['atividade_nome']);?>" disabled>
            </div>
    </div>
    
    <div class="form-group">
        <label for="aula" class="col-sm-2 control-label">Unidade</label>
        <div class="col-sm-10">
            <select class="form-control" name="aula" id="aula" disabled>
                <?php
                    foreach ($aulas as $aula){
                         if($aula['nome']==$resultados[0]['unidade_nome']){
                        
                ?>
                <option selected value="<?php echo $aula['id'];?>"><?php echo utf8_encode($aula['nome']." - ".$aula['curso']);?></option>
                <?php
                         }
                         else{
                ?>
                <option value="<?php echo $aula['id'];?>"><?php echo utf8_encode($aula['nome']." - ".$aula['curso']);?></option>
                <?php
                         }
                    }
                ?>
            </select>
        </div>
    </div>
    
    
    <div class="form-group">
        <label for="pergunta" class="col-sm-2 control-label">Pergunta</label>
        <div class="col-sm-10">
            <textarea name="pergunta" id="pergunta"></textarea><script> CKEDITOR.replace( 'pergunta' );</script>
        </div>
    </div>
    
    <div class="form-group">
        <label for="pergunta" class="col-sm-2 control-label">Respostas</label>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="0" required></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="alternativa[]" value="Alternativa A">
        </div>
        
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="1" required></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="alternativa[]" value="Alternativa B">
        </div>
        
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="2" required></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="alternativa[]" value="Alternativa C">
        </div>
        
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="3" required></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="alternativa[]" value="Alternativa D">
        </div>
    </div>
    
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="atividade" value="<?php echo $avaliacao;?>">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>

<?php
    include_once("../core/templates/rodape.php");
?>