<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    //print_r($_SESSION);
    $curso = detalhes();
    //print_r($curso[0]['instrutor']);
    $instrutores = get_instrutores();
    $categorias = get_categorias();
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_curso.php">Cursos</a></li>
        <li><?php echo utf8_decode($curso[0]['nome']);?></li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="salvar.php" enctype="multipart/form-data">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo utf8_decode($curso[0]['nome']);?>" pattern="[A-Za-zÀ-ú 0-9]+" required>
            </div>
    </div>
    <div class="form-group">
            <label for="descricao" class="col-sm-2 control-label">Descrição Simples</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo utf8_decode($curso[0]['descricao']);?>">
            </div>
    </div>
    <script src="../ckeditor/ckeditor.js"></script> 
    <div class="form-group">
            <label for="sobre" class="col-sm-2 control-label">Sobre o Curso</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="10" name="sobre" id="sobre"><?php echo utf8_decode($curso[0]['sobre']);?></textarea><script> CKEDITOR.replace( 'sobre' );</script>
            </div>
    </div>
    <div class="form-group">
        <label for="instrutor" class="col-sm-2 control-label">Instrutor</label>
        <div class="col-sm-10">
            <select class="form-control" name="instrutor" id="instrutor">
                <?php
                    foreach ($instrutores as $instrutor){
                        if($instrutor['nome']==$curso[0]['instrutor']){
                ?>
                <option selected value="<?php echo $instrutor['id'];?>"><?php echo utf8_decode($instrutor['nome']);?></option>
                <?php
                        }
                        else{
                ?>
                <option value="<?php echo $instrutor['id'];?>"><?php echo utf8_decode($instrutor['nome']);?></option>
                <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="categoria" class="col-sm-2 control-label">Categoria</label>
        <div class="col-sm-10">
            <select class="form-control" name="categoria" id="categoria">
                <?php
                    foreach ($categorias as $categoria){
                        if($categoria['nome']==$curso[0]['categoria']){
                ?>
                <option selected value="<?php echo $categoria['id'];?>"><?php echo utf8_decode($categoria['nome']);?></option>
                <?php
                        }
                        else{
                ?>
                            <option value="<?php echo $categoria['id'];?>"><?php echo utf8_decode($categoria['nome']);?></option>
                <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
            <label for="file" class="col-sm-2 control-label">Imagem</label>
            <div class="col-sm-10">
                <img src="data:image/jpg;base64,<?php echo utf8_decode(base64_encode(hex2bin($curso[0]['image']))); ?>" class="img-responsive" style="width:100px" alt="<?php echo utf8_decode($curso[0]['nome']); ?>"> 
                    <input type="file" name="file" />
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
            </div>
    </div>
    <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="id_curso" value="<?php echo $_GET['curso'];?>">
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
        <a href="./curso_del.php?curso=<?php echo $_GET['curso'];?>" style="color:red;"><span class="glyphicon glyphicon-erase">Apagar</span></a>
    </div>
</div>
<?php
    include_once("../core/templates/rodape.php");
?>