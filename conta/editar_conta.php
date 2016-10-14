<?php
include_once("../core/templates/cabecalho.php");
require_once("../core/conf/confBD.php");
include_once("./utils.php");

testa_autenticacao();

try{
    $conexao = conn_mysql();
}
catch(PDOException $excep){
    echo "Erro!: " . $excep->getMessage() . "\n";
    die();
}

$usuario = "";
$email = "";
$first_name = "";
$last_name = "";

$SQLSelect = "SELECT * FROM usuario WHERE login ='".$_SESSION['usuario']."'";

$operacao = $conexao->prepare($SQLSelect);	
$operacao->execute();

$resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);

if($resultados){
    //percorre os resultados via o laço foreach
    foreach($resultados as $linha){
        $email = utf8_decode($linha['email']);
        $first_name = utf8_decode($linha['first_name']);
        $last_name = utf8_decode($linha['last_name']);
        $id = utf8_decode($linha['id']);
    }
}
$conexao=null;

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

<form class="form-horizontal" method="post" action="./salvar_usuario.php">
    <fieldset>	
        <div class="form-group">
            <label for="usuario" class="col-sm-2 control-label">Login</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $_SESSION['usuario'];?>" pattern="[a-zA-Z0-9]+" required>
            </div>
        </div>

        <div class="form-group">
            <label for="first_name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="last_name" class="col-sm-2 control-label">Sobrenome</label>
            <div class="col-sm-10">
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
            </div>
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