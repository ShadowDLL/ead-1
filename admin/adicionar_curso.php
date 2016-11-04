<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
    
    
    //print_r($_SESSION);
    
    $instrutores = get_instrutores();
    $categorias = get_categorias();
?>
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_curso.php">Cursos</a></li>
        <li>Adicionar Curso</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="curso_add.php" enctype="multipart/form-data">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-zÀ-ú 0-9]+" required>
            </div>
    </div>
    <div class="form-group">
            <label for="descricao" class="col-sm-2 control-label">Descrição Simples</label>
            <div class="col-sm-10">
                    <input type="text" class="form-control" id="descricao" name="descricao" value="">
            </div>
    </div>
    <script src="../ckeditor/ckeditor.js"></script>
    <div class="form-group">
            <label for="sobre" class="col-sm-2 control-label">Sobre o Curso</label>
            <div class="col-sm-10">
                    <textarea class="form-control" rows="10" name="sobre"></textarea><script> CKEDITOR.replace( 'sobre' );</script>
            </div>
    </div>
    <div class="form-group">
        <label for="instrutor" class="col-sm-2 control-label">Instrutor</label>
        <div class="col-sm-10">
            <select class="form-control" name="instrutor" id="instrutor" required>
                <?php
                    foreach ($instrutores as $instrutor){
                      
                        
                ?>
                <option value="<?php echo $instrutor['id'];?>"><?php echo utf8_decode($instrutor['nome']);?></option>
                <?php
                        
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="categoria" class="col-sm-2 control-label">Categoria</label>
        <div class="col-sm-10">
            <select class="form-control" name="categoria" id="categoria" required>
                <?php
                    foreach ($categorias as $categoria){
                        
                ?>
                        <option value="<?php echo $categoria['id'];?>"><?php echo utf8_decode($categoria['nome']);?></option>
                <?php
                        
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
            <label for="keywords" class="col-sm-2 control-label">Palavras-Chave</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="keywords" name="keywords" required>
            </div>
    </div>
    <div class="form-group">
            <label for="file" class="col-sm-2 control-label">Imagem</label>
            <div class="col-sm-10">
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
                    <! Will be used to display an alert to the user>
            </div>
    </div>
</form>

<?php
    include_once("../core/templates/rodape.php");
?>