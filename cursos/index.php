<?php
include_once("../core/templates/cabecalho.php");
include_once ("utils.php");
?>

<?php
    $cursos = cursos();
    if($cursos){
        foreach($cursos as $curso){
?>
            
                <div class="col-sm-3">
                    <a href="../cursos/detalhes.php?curso=<?php echo utf8_decode($curso['id']);?>">
                        <img src="data:image/jpg;base64,<?php echo utf8_decode(base64_encode(hex2bin($curso['image']))); ?>" class="img-responsive" style="width:100px" alt="<?php echo utf8_decode($curso['nome']); ?>"> 
                    </a>
                </div> 
                <div class="col-sm-9">
                    <h3 class="text-muted"><a href="../cursos/detalhes.php?curso=<?php echo utf8_decode($curso['id']);?>" title=""> <?php echo utf8_decode($curso['nome']);?></a></h3>
                    <p><?php echo utf8_decode($curso['descricao']) ?></p>
                    <p>Instrutor: <?php echo utf8_decode($curso['instrutor']) ?></p>
                    <p>Categoria:<?php echo utf8_decode($curso['categoria_nome']) ?></p>
                </div>
            
<?php
        }
    }
?>

<div class="row"></div>
<?php
include_once("../core/templates/rodape.php");
?>