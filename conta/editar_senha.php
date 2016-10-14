<?php
include_once("../core/templates/cabecalho.php");
require_once("../core/conf/confBD.php");
include_once("./utils.php");

testa_autenticacao();

?>


<div class="col-sm-3">
    <ul class="breadcrumb">
        <li><a href="./painel.php">Meu Painel</a></li>
        <li><a href="./editar_conta.php">Editar Conta</a></li>
    </ul>

    <ul class="nav nav-pills nav-stacked">
        <li><a href="./editar_conta.php"><span class="glyphicon glyphicon-cog"> Editar Conta</span></a></li>
        <li><a href="./editar_senha.php"><span class="glyphicon glyphicon-lock"> Editar Senha</span></a></li>
    </ul>
</div>
    
<form class="form-horizontal" method="post" action="./salvar_senha.php">
    <fieldset>	
        <div class="form-group">
            <label for="passwd-old" class="col-sm-2 control-label">Senha antiga</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="passwd-old" name="passwd-old" value="" required>
            </div>
        </div>

        <div class="form-group">
            <label for="passwd1" class="col-sm-2 control-label">Nova senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="first_name" name="passwd1" value="" required>
            </div>
        </div>

        <div class="form-group">
            <label for="passwd2" class="col-sm-2 control-label">Confirmacao da nova senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="passwd2" name="passwd2" value="" required   >
            </div>
        </div>

        <div class="form-group">
            <input type="hidden" name="usuario" value=<?php echo $_SESSION['usuario'];?>>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                    <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-sm btn-primary">
            </div>
        </div>
    </fieldset>
</form>

<?php
    include_once("../core/templates/rodape.php");
?>