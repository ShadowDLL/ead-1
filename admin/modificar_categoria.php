<?php
include_once("../core/templates/cabecalho_adm.php");
include_once("utils.php");
testa_autenticacao();
$categorias = get_categorias();
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Categorias</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-offset-10">
        <a href="./adicionar_categoria.php"><span class="glyphicon glyphicon-plus-sign"> Adicionar Categoria</span></a>
    </div>
</div>

<table border="1" class="table table-bordered">
    <thead>
      <tr>
        <th colspan="3">Categoria</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if($categorias){
                foreach ($categorias as $categoria){
        ?>
        <tr>
            <td colspan="2"><a href="./categoria_edit.php?categoria=<?php echo utf8_decode($categoria['id']); ?>"> <?php echo utf8_decode($categoria['nome']);?></a></td>
            <td><a href="./categoria_edit.php?categoria=<?php echo utf8_decode($categoria['id']); ?>"><span class="glyphicon glyphicon-pencil"> Modificar</span></a></td>
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