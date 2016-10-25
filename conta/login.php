<?php
include_once("../core/templates/cabecalho.php");
?>
<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <form class="form-signin" role="form" method="post" action="verificaLogin.php">
            <h3 class="form-signin-heading">Learn Alone : Login</h3>
            <input type="text" class="form-control" placeholder="Login" name="login" pattern="[a-zA-Z0-9]+" required autofocus>
            <input type="password" class="form-control" placeholder="Senha" name="passwd" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            <br>
            <button class="btn btn-lg btn-success btn-block" type="button" onclick="javascript:window.location.href='./registro.php'">Cadastrar-se</button>
        </form>
    </div>
</div>


<?php
    include_once("../core/templates/rodape.php");
?>