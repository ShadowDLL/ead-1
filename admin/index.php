<?php
include_once("../core/templates/cabecalho_adm.php");

?>

<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <form class="form-signin" role="form" method="post" action="verificaLogin.php">
            <h4 class="form-signin-heading">Learn Alone Administração: Login</h4>
            <input type="text" class="form-control" placeholder="Login" name="login" required autofocus>
            <input type="password" class="form-control" placeholder="Senha" name="passwd" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        </form>
    </div>
</div>

<?php
include_once("../core/templates/rodape.php");
?>