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
        <li><a href="./excluir_conta.php"><span class="glyphicon glyphicon-remove"> Excluir Conta</span></a></li>
        <li><a href="./editar_senha.php"><span class="glyphicon glyphicon-lock"> Editar Senha</span></a></li>
    </ul>
</div>
<div class="col-sm-9">
    Você tem certeza de que deseja encerrar a conta?

    <fieldset>	               
        <div class="btn-group">
            <a href="javascript:window.history.go(-1)" class="btn btn-success">Não</a>
            <a href="./remove_usuario.php" class="btn btn-danger">Sim</a>
        </div>
    </fieldset>

    <?php
       //print_r($_SESSION);
    ?>
</div>

<div class="row"></div>
<?php
    include_once("../core/templates/rodape.php");
?>