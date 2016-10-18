<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $material = $_GET['material'];
    try{
        $conexao = conn_mysql();
    }
    catch(PDOException $excep){
        echo "Erro!: " . $excep->getMessage() . "\n";
        die();
    }
    
    $SQLSelect = 'SELECT unidade.nome as unidade_nome, material.nome as material_nome, material.id, material.embedded, material.filepath, curso.nome as curso, curso.id as curso_id  FROM unidade inner join material on unidade.id = material.unidade_id '
               . 'INNER JOIN curso ON unidade.curso_id = curso.id WHERE material.id = ?';
   
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);	
    $operacao->execute(array($material));

    //captura TODOS os resultados obtidos
    $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
  // print_r($resultados);
    //libera a conexão (dados já foram capturados)
    $conexao=null;
    //echo "<br>";
    $aulas = aulas_curso($resultados[0]['curso_id']);
   //print_r($aulas); 
   
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_material.php">Materiais</a></li>
        <li>Editar Material</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="salvar_material.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nome</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($resultados[0]['material_nome']);?>" pattern="[A-Za-zÀ-ú 0-9]+" required>
        </div>
    </div>
    <div class="form-group">
        <label for="video" class="col-sm-2 control-label">Vídeo embedded</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="10" name="video"><?php echo utf8_decode($resultados[0]['embedded']);?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="file" class="col-sm-2 control-label">Arquivo</label>
        <div class="col-sm-10">
            <input type="file" name="file" />
            <?php 
            if (!empty($resultados[0]['filepath'])){
            ?>
                
                Atualmente:<?php echo utf8_decode($resultados[0]['filepath']); ?>
                
            <?php
            }
            ?>
        </div>
    </div>
    
    <div class="form-group">
        <label for="aula" class="col-sm-2 control-label">Unidade</label>
        <div class="col-sm-10">
            <select class="form-control" name="aula" id="aula">
                <?php
                    foreach ($aulas as $aula){
                         if($aula['nome']==$resultados[0]['unidade_nome']){
                        
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
                    <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
            </div>
    </div>
    
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="id" value="<?php echo $material;?>">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>
<div class="row">
    <div class="col-sm-2">
        <a href="./material_del.php?material=<?php echo $material;?>" style="color:red;"><span class="glyphicon glyphicon-erase">Apagar</span></a>
    </div>
</div>
<?php
    include_once("../core/templates/rodape.php");
?>