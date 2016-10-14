<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$cursos = cursos();
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Cursos</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_curso.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Curso</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th colspan="3">Cursos</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($cursos){
                foreach ($cursos as $curso){
        ?>
        <tr>
            <td><a href="./curso_edit.php?curso=<?php echo $curso['id']; ?>" colspan="2"> <?php echo utf8_decode($curso['nome']);?></a></td> 
            <td><a href="./curso_edit.php?curso=<?php echo $curso['id']; ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
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