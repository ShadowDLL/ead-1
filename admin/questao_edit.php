<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $avaliacao = $_GET['atividade'];
    $questao = $_GET['questao'];
    
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
    $atividade_nome = $resultados[0]['atividade_nome'];
    $unidade_nome = $resultados[0]['unidade_nome'];
    $conexao=null;
    
    $aulas = aulas_curso($resultados[0]['curso_id']);
   
    //Seleciona todas as alternativa de uma questão
    
    $conexao = conn_mysql();
    $SQLSelect = 'SELECT * FROM pergunta WHERE id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($questao));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    $conexao=null;
    
    $pergunta = $resultados[0]['pergunta'];
    
    //Seleciona todas as alternativa de uma questão
    
    $conexao = conn_mysql();
    $SQLSelect = 'SELECT * FROM alternativa WHERE pergunta_id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($questao));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    $conexao=null;
    
    $alternativas = $resultados;
    
    
    $conexao = conn_mysql();
    $SQLSelect = 'SELECT * FROM correta WHERE pergunta_id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($questao));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    $conexao=null;
    
    $correta = $resultados[0]['alternativa_id'];
    //print_r($alternativas); die;
    
?>
<script src="../ckeditor/ckeditor.js"></script> 
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_avaliacao.php">Avaliações</a></li>
        <li><a href="javascript:window.history.go(-1)">Editar Avaliação</a></li>
        <li>Editar Questão</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="salvar_questao.php">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($atividade_nome);?>" disabled>
            </div>
    </div>
    
    <div class="form-group">
        <label for="aula" class="col-sm-2 control-label">Unidade</label>
        <div class="col-sm-10">
            <select class="form-control" name="aula" id="aula" disabled>
                <?php
                    foreach ($aulas as $aula){
                         if($aula['nome']==$unidade_nome){
                        
                ?>
                <option selected value="<?php echo $aula['id'];?>"><?php echo utf8_decode($aula['nome']." - ".$aula['curso']);?></option>
                <?php
                         }
                         else{
                ?>
                <option value="<?php echo $aula['id'];?>"><?php echo utf8_decode($aula['nome']." - ".$aula['curso']);?></option>
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
            <textarea name="pergunta" id="pergunta"><?php echo html_entity_decode($pergunta); ?></textarea><script> CKEDITOR.replace( 'pergunta' );</script>
        </div>
    </div>
    
    <div class="form-group">
        <label for="pergunta" class="col-sm-2 control-label">Respostas</label>
    </div>
    <?php 
        $contador = 0;
        foreach ($alternativas as $alternativa){
    ?>
            <div class="form-group">
                <?php
                    if($correta == $alternativa['id']){
                ?>
                <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="<?php echo $contador; ?>" checked required></label>
                <?php    
                    }
                    else{
                ?>
                        <label class="col-sm-2 control-label"><input type="radio" name="resposta" value="<?php echo $contador; ?>" required></label>
                <?php
                    }
                ?>
                
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="alternativa[]" value="<?php echo utf8_decode($alternativa['sentenca']); ?>">
                </div>    
            </div>
    <?php
            $contador++;
        }
    ?>
    
    
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="questao" value="<?php echo $questao;?>">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="well">
         <a href="./questao_del.php?questao=<?php echo $questao;?>" style="color:red;"><span class="glyphicon glyphicon-erase"> Apagar</span></a>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>

<!--
<div class="row">
    <div class="col-sm-2">
        <a href="./adicionar_questao.php?atividade=<?php echo $avaliacao;?>" style="color:blue;"><span class="glyphicon glyphicon-list-alt"> Adicionar Questão</span></a>
    </div>
</div>
-->
<?php
    include_once("../core/templates/rodape.php");
?>