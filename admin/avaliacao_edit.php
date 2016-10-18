<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $avaliacao = $_GET['avaliacao'];
    
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT unidade.nome as unidade_nome, atividade.nome as atividade_nome, atividade.id, curso.nome as curso, curso.id as curso_id '
               . 'FROM unidade inner join atividade on unidade.id = atividade.unidade_id '
               . 'INNER JOIN curso ON unidade.curso_id = curso.id '
               . 'WHERE atividade.id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($avaliacao));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
    $atividade_nome = $resultados[0]['atividade_nome'];
    $unidade_nome = $resultados[0]['unidade_nome'];
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
        <li>Editar Avaliação</li>
    </ul>
</div>
<div class="row">
    <div class="col-sm-offset-10">
        <a href="./avaliacao_del.php?avaliacao=<?php echo $avaliacao;?>" style="color:red;"><span class="glyphicon glyphicon-erase"> Remover Avaliação</span></a>
    </div>
</div>
<form class="form-horizontal" role="form" method="post" action="salvar_avaliacao.php">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($atividade_nome);?>" pattern="[a-zA-Z 0-9]+" required>
            </div>
    </div>
    
    <div class="form-group">
        <label for="aula" class="col-sm-2 control-label">Unidade</label>
        <div class="col-sm-10">
            <select class="form-control" name="aula" id="aula">
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
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="id" value="<?php echo $avaliacao;?>">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>

<?php
    $contador = 1;
    $questoes = lista_perguntas_avaliacao($avaliacao);
    foreach ($questoes as $questao) {
?>
    <div class="well">
<?php
        echo "<h4>Questão ".$contador."</h4>";
        echo "<p>".html_entity_decode($questao['pergunta'])."</p>";
        echo "<p>Resposta: ".  utf8_decode($questao['sentenca'])."</p>";
        $contador++;
?>      
       
        <a href="./questao_del.php?questao=<?php echo $questao['id'];?>" style="color:red;"><span class="glyphicon glyphicon-erase"> Apagar</span></a>
        <a href="./questao_edit.php?questao=<?php echo $questao['id'];?>&atividade=<?php echo $avaliacao;?>"><span class="glyphicon glyphicon-pencil"> Editar</span></a>
    </div> 
<?php
    }
?>

<div class="row">
    <div class="col-sm-2">
        <a href="./adicionar_questao.php?atividade=<?php echo $avaliacao;?>" style="color:blue;"><span class="glyphicon glyphicon-list-alt"> Adicionar Questão</span></a>
    </div>
</div>


<?php
    include_once("../core/templates/rodape.php");
?>