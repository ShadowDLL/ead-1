<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$instrutores = get_instrutores();
//print_r($materiais);
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Instrutores</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_instrutor.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Instrutor</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th colspan="3">Instrutor</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($instrutores){
                foreach ($instrutores as $instrutor){
        ?>
        <tr>
            <td colspan="2"><a href="./instrutor_edit.php?instrutor=<?php echo utf8_decode($instrutor['id']); ?>"> <?php echo utf8_decode($instrutor['nome']);?></a></td>
            <td><a href="./instrutor_edit.php?instrutor=<?php echo utf8_decode($instrutor['id']); ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
        </tr>
        <?php
                }
            }                            
        ?>
    </tbody>
</table>

<?php
    include_once("../core/templates/rodape.php");
?>  