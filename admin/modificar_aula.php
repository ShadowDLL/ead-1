<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$aulas = aulas();
//print_r($aulas);
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Unidades</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_aula.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Unidade</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th>Aula</th>
        <th colspan>Curso</th>
        <th>Ordem da Aula</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($aulas){
                foreach ($aulas as $aula){
        ?>
        <tr>
            <td><a href="./aula_edit.php?aula=<?php echo $aula['id']; ?>"> <?php echo utf8_decode($aula['nome']);?></a></td>
            <td><?php echo utf8_decode($aula['curso']);?></td>
            <td><?php echo utf8_decode($aula['ordem']);?></td>
            <td><a href="./aula_edit.php?aula=<?php echo $aula['id']; ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
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