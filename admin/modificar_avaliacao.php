<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$avaliacoes = atividades();
//print_r($materiais);
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Avaliações</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_avaliacao.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Avaliação</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th>Avaliação</th>
        <th colspan>Curso</th>
        <th>Unidade</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($avaliacoes){
                foreach ($avaliacoes as $avaliacao){
        ?>
        <tr>
            <td><a href="./avaliacao_edit.php?avaliacao=<?php echo utf8_decode($avaliacao['id']); ?>"> <?php echo utf8_decode($avaliacao['atividade_nome']);?></a></td>
            <td><?php echo utf8_decode($avaliacao['curso']);?></td>
            <td><?php echo utf8_decode($avaliacao['unidade_nome']);?></td>
            <td><a href="./avaliacao_edit.php?avaliacao=<?php echo $avaliacao['id']; ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
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