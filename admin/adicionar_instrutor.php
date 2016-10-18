<?php
    include_once("../core/templates/cabecalho_adm.php");
    include_once("utils.php");
    testa_autenticacao();
?>
 
<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li><a href="./modificar_instrutor.php">Instrutores</a></li>
        <li>Adicionar Instrutor</li>
    </ul>
</div>

<form class="form-horizontal" role="form" method="post" action="instrutor_add.php">
    <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome do Instrutor</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name"  pattern="[A-Za-zÀ-ú 0-9]+" required>
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