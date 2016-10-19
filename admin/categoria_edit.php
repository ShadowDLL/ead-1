<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
   
    $categoria = get_categoria($_GET['categoria']);
    
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_categoria.php">Categorias</a></li>
        <li>Altera Categoria</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="salvar_categoria.php" enctype="multipart/form-data">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($categoria[0]['nome']);?>" pattern="[A-Za-zÀ-ú 0-9]+" required>
            </div>
    </div>
    
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="id_categoria" value="<?php echo $_GET['categoria'];?>">
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
        <a href="./categoria_del.php?categoria=<?php echo $_GET['categoria'];?>" style="color:red;"><span class="glyphicon glyphicon-erase">Apagar</span></a>
    </div>
</div>
<?php
    include_once("../core/templates/rodape.php");
?>