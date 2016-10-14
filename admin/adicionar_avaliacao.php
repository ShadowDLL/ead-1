<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $aulas = aulas();
    
    
   
?>
<script src="../ckeditor/ckeditor.js"></script> 
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_avaliacao.php">Avaliações</a></li>
        <li>Adicionar Avaliação</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="avaliacao_add.php">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name"  pattern="[a-zA-Z 0-9]+" required>
            </div>
    </div>
    
    <div class="form-group">
        <label for="aula" class="col-sm-2 control-label">Unidade</label>
        <div class="col-sm-10">
            <select class="form-control" name="aula" id="aula">
                <?php
                    foreach ($aulas as $aula){
                        
                ?>
                        <option value="<?php echo $aula['id'];?>"><?php echo utf8_encode($aula['nome']." - ".$aula['curso']);?></option>
                <?php
                        
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
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>

<?php
    include_once("../core/templates/rodape.php");
?>