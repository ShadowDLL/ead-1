<?php
    include_once("../core/templates/cabecalho.php");
?>

<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <h3 class="form-signin-heading">Learn Alone : Cadastro</h3>
            <form class="form" method="post" action="./novo_usuario.php">
                <fieldset>	
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Login" name="login" required pattern="[a-zA-Z0-9]+" autofocus>
                        <input type="password" class="form-control" placeholder="Senha" name="passwd1" pattern=".{4,8}" required>
                        <input type="password" class="form-control" placeholder="Confirmação de Senha" name="passwd2" pattern=".{4,8}" required>
                        <input type="email" class="form-control" placeholder="email@exemplo.com" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                        <br>
                        <button class="btn btn-sm btn-primary" type="submit">Cadastrar</button>
                    </div>
                </fieldset>
            </form>
    </div>
</div>

<?php
    include_once("../core/templates/rodape.php");
?>