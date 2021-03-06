<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    $cursos = cursos();
    
    
   
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_aula.php">Unidades</a></li>
        <li>Adicionar Unidade</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="aula_add.php" enctype="multipart/form-data">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="" pattern="[A-Za-zÀ-ú 0-9]+" required>
            </div>
    </div>
    <div class="form-group">
            <label for="descricao" class="col-sm-2 control-label">Descrição</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="descricao" name="descricao" value="">
            </div>
    </div>
    <div class="form-group">
        <label for="curso" class="col-sm-2 control-label">Curso</label>
        <div class="col-sm-10">
            <select class="form-control" name="curso" id="instrutor" required>
            <?php
                foreach ($cursos as $curso){
            ?>
                <option value="<?php echo $curso['id'];?>"><?php echo utf8_decode($curso['nome']);?></option>
            <?php
                        
                    }
            ?>
            </select>
        </div>
    </div>
    <div class="form-group">
            <label for="ordem" class="col-xs-2 control-label">Ordem</label>
            <div class="col-xs-1">
                <input type="text" class="form-control" id="name" name="ordem">
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