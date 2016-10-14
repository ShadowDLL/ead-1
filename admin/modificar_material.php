<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$materiais = materiais();
//print_r($materiais);
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Materiais</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_material.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Material</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th>Material</th>
        <th colspan>Curso</th>
        <th>Nome da Aula</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($materiais){
                foreach ($materiais as $material){
        ?>
        <tr>
            <td><a href="./material_edit.php?material=<?php echo utf8_decode($material['id']); ?>"> <?php echo utf8_decode($material['material_nome']);?></a></td>
            <td><?php echo utf8_decode($material['curso']);?></td>
            <td><?php echo utf8_decode($material['unidade_nome']);?></td>
            <td><a href="./material_edit.php?material=<?php echo $material['id']; ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
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