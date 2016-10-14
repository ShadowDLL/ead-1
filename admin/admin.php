<?php
include_once("../core/templates/cabecalho_adm.php");
include_once ("../admin/utils.php");
testa_autenticacao();
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
    </ul>
</div>

<table border="1" class="table table-bordered">
  <thead>
    <tr>
        <th colspan="3">Cursos</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
        <td><a href="./modificar_curso.php">Cursos</a></td>
        <td><a href="./adicionar_curso.php"><span class="glyphicon glyphicon-plus"> Adicionar</span></a></td>
        <td><a href="./modificar_curso.php"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
    </tr>
    <tr>
        <td><a href="./modificar_aula.php">Unidades</a></td>
        <td><a href="./adicionar_aula.php"><span class="glyphicon glyphicon-plus"> Adicionar</span></a></td>
        <td><a href="./modificar_aula.php"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
    </tr>
    <tr>
        <td><a href="./modificar_material.php">Materiais</a></td>
        <td><a href="./adicionar_material.php"><span class="glyphicon glyphicon-plus"> Adicionar</span></a></td>
        <td><a href="./modificar_material.php"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
    </tr>
    <tr>
        <td><a href="./modificar_avaliacao.php">Avaliações</a></td>
        <td><a href="./adicionar_avaliacao.php"><span class="glyphicon glyphicon-plus"> Adicionar</span></a></td>
        <td><a href="./modificar_avaliacao.php"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
    </tr>
    <tr>
        <td colspan="3"><a href="./pesquisa_aluno.php">Relatórios</a></td>
    </tr>
  </tbody>
</table>

<?php
    include_once("../core/templates/rodape.php");
?>