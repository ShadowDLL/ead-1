<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
   
    $instrutor = get_instrutor($_GET['instrutor']);
    
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_instrutor.php">Instrutores</a></li>
        <li>Altera Instrutor</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="salvar_instrutor.php" enctype="multipart/form-data">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($instrutor[0]['nome']);?>" pattern="[a-zA-Z 0-9]+" required>
            </div>
    </div>
    
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="id_instrutor" value="<?php echo $_GET['instrutor'];?>">
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
        <a href="./instrutor_del.php?instrutor=<?php echo $_GET['instrutor'];?>" style="color:red;"><span class="glyphicon glyphicon-erase">Apagar</span></a>
    </div>
</div>
<?php
    include_once("../core/templates/rodape.php");
?>