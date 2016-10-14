<?php
include_once("../core/templates/cabecalho.php");
//include_once("./utils.php");
include_once("../cursos/utils.php");
testa_autenticacao();

?>


<div class="col-sm-3">
    <ul class="breadcrumb">
        <li><a href="./painel.php">Meu Painel</a></li>
    </ul>
    
    <div class="well">
        <ul class="nav nav-pills">
            <li>Bem-vindo, <?php echo $_SESSION['usuario'];?></li>
        </ul>
        <ul class="nav nav-pills nav-stacked">
            <li class="nav-header disabled"><a href="#">MEUS CURSOS</a></li>
            <?php gera_menu_cursos($_SESSION['id']); ?>
        </ul>
        <ul class="nav nav-pills nav-stacked">
          <li class="nav-header disabled"><a href="#">MINHA CONTA</a></li>
          <li><a href="./editar_conta.php"><span class="glyphicon glyphicon-cog"> Editar Conta</span></a></li>
          <li><a href="./editar_senha.php"><span class="glyphicon glyphicon-lock"> Editar Senha</span></a></li>
        </ul>
    </div>
    
</div>


<div class="col-sm-9">
    <h2>Meus Cursos</h2>
    <?php lista_cursos_inscritos($_SESSION['id']); ?>
</div>

<div class="row"></div>

<?php
    include_once("../core/templates/rodape.php");
?>