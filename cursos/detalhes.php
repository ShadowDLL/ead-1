<?php
include_once("../core/templates/cabecalho.php");
include_once ("utils.php");
//print_r($_SESSION);
$curso_id = $_GET['curso'];

?>

<div class="jumbotron">
    <div class="jumbotron-content">
        <h1>
            <?php echo utf8_decode(detalhes($curso_id)[0]['nome']);  ?>
        </h1>      
        <h2 class="text-muted">
            <?php echo utf8_decode(detalhes($curso_id)[0]['descricao']); ?>
        </h2>
        <h4>Instrutor: <?php echo utf8_decode(detalhes($curso_id)[0]['instrutor']); ?></h4>
        <h4>Categoria: <?php echo utf8_decode(detalhes($curso_id)[0]['categoria_nome']); ?></h4>
        <p>
            <a href="./inscrever.php?curso=<?php echo detalhes($curso_id)[0]['id'];?>" class="btn-info btn-lg">Inscreva-se</a>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <a href="">
            <img src="data:image/jpg;base64,<?php echo utf8_decode(base64_encode(hex2bin(detalhes($curso_id)[0]['image'])));?>" class="img-thumbnail" style="width:50%" alt="<?php detalhes()[0]['nome'];?>">
       	</a>
    </div>
    <div class="col-sm-8">
	<h3 class="text-muted">Sobre o Curso</h3>
       	<?php echo html_entity_decode(detalhes($curso_id)[0]['sobre']); ?>
    </div>
</div>


<div class="row">
    <hr>
    <script type="text/javascript" src="../core/scripts/rating.js"></script>
    <link href="../core/css/rating.css" rel="stylesheet" type="text/css">
    <div class="col-sm-10">
    <table width="100%">
         <?php
            $avaliacoes = retorna_avaliacoes($curso_id);
            // print_r($avaliacoes);
            $cont = 1;
        foreach ($avaliacoes as $avaliacao) {
            echo "<tr>";
            $num_star = $avaliacao['rating_number'];
            
            $rating_star = "rating_star".$num_star;
            $hash_rating_star = "#".$rating_star;
    ?>
           
            <script language="javascript" type="text/javascript">
            $(function() {
                $("<?php echo $hash_rating_star?>").codexworld_rating_widget({
                    starLength: '5',
                    initialValue: '<?php echo $num_star; ?>',
                    callbackFunctionName: 'processRating',
                    imageDirectory: '../core/images/',
                    inputAttr: 'postID',
                });
            });
            </script>
            
            <td width="20%"><input name="rating" class="form-control" value="0" id="<?php echo $rating_star?>" type="hidden" postID="1"/></td>
            <td width="80%"><?php echo "<i>".$avaliacao['login']. '</i>: '. $avaliacao['comentario']; ?></td>
                
                
    <?php
            echo "</tr>";
    
        }
    ?>
    </table>
    </div>
</div>
<?php
include_once("../core/templates/rodape.php");
?>