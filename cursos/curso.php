<?php
include_once("../core/templates/cabecalho.php");
include_once("../cursos/utils.php");
testa_autenticacao();

$comentario = retorna_comentario($_GET['id'],$_SESSION['id']);
$num_star = 0;
$disabled = false;
$nota = recupera_nota($_GET['id'],$_SESSION['id']);
if($nota){
    $num_star = $nota[0]['rating_number'];
   
}

// codigo de terceiros
include_once '../core/conf/dbConfig.php';
$query = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM post_rating WHERE post_id = 1 AND status = 1";
$result = $db->query($query);
$ratingRow = $result->fetch_assoc();
?>
<!-- 
Código de terceiro
Author: CodexWorld
Author URL: http://www.codexworld.com/
Author Email: contact@codexworld.com
Tutorial Link: http://www.codexworld.com/star-rating-system-with-jquery-ajax-php/
-->
<script type="text/javascript" src="../core/scripts/rating.js"></script>
<link href="../core/css/rating.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '<?php echo $num_star; ?>',
        callbackFunctionName: 'processRating',
        imageDirectory: '../core/images/',
        inputAttr: 'postID',
    });
});

function processRating(val, attrVal){
    var usuario_id = $("#usuario_id").val();
    var curso_id = $("#curso_id").val();
    
    $.ajax({
        type: 'POST',
        url: 'rating.php',
        data: {postID:attrVal, ratingPoints:val, curso_id:curso_id, usuario_id:usuario_id},
        dataType: 'json',
        success : function(data) {
            if (data.status == 'ok') {
                //alert('You have rated '+val+' to CodexWorld');
                $('#avgrat').text(data.average_rating);
                $('#totalrat').text(data.rating_number);
            }else{
                alert('Some problem occured, please try again.');
            }
        }
        
    });
}
</script>
<style type="text/css">
    .overall-rating{font-size: 14px;margin-top: 5px;color: #8e8d8d;}
</style>
<!-- Fim do código de terceiro -->
<div class="col-sm-3">
    <?php //print_r($_SESSION);?>
    
        <ul class="breadcrumb">
            <li><a href="../conta/painel.php">Meu Painel</a></li>
            <li><a href="../cursos/curso.php?id=<?php echo $_GET['id']?>&nome=<?php echo $_GET['nome']; ?>"><?php echo utf8_decode($_GET['nome']); ?></a></li>

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
          <li><a href="../conta/editar_conta.php"><span class="glyphicon glyphicon-cog"> Editar Conta</span></a></li>
          <li><a href="../conta/editar_senha.php"><span class="glyphicon glyphicon-lock"> Editar Senha</span></a></li>
        </ul>
    </div>

</div>

<div class="col-sm-9">
<?php

    $unidades = lista_unidades_curso($_GET['id']);

    if($unidades){
        foreach ($unidades as $unidade){                            
            $videos = lista_video_unidade_curso($_GET['id'], $unidade['id']); 
            $arquivos = lista_material_unidade_curso($_GET['id'], $unidade['id']);
            $atividades = retorna_atividade_unidade($unidade['id']);

?>
            <div class="well">
<?php
                if(!empty(sizeof($videos))||!empty(sizeof($arquivos))||!empty(sizeof($atividades))){
?>
                    <h3><?php echo utf8_decode($unidade['nome']); ?>  <?php echo utf8_decode($unidade['descricao']); ?></h3>
                    <br>
<?php 
                }
            if($videos && ($videos[0]['embedded'] != NULL)){
                echo "<h4 style=\"color:red\">VÍDEOS</h4>";
                echo "<ul class=\"nav nav-pills nav-stacked\">";
                foreach($videos as $video){
                    if(!empty($video['embedded'])){
?>
                        <li><a href="./material.php?id=<?php echo $unidade['id']?>&unidade=<?php echo utf8_decode($unidade['nome']);?>&video=<?php echo $video['id'];?>"><span class="glyphicon glyphicon-facetime-video"> <?php echo utf8_decode($video['nome']);?></span></a></li>
<?php
                    }
                } 
                echo "</ul>";
            }
            
            if($arquivos){
                echo "<h4 style=\"color:red\">MATERIAL COMPLEMENTAR</h4>";
                echo "<ul class=\"nav nav-pills nav-stacked\">";
                
                 foreach($arquivos as $arquivo){
                    if(empty($arquivo['embedded'])){
                        echo '<li><a href="' . $arquivo['filepath'].'"><span class="glyphicon glyphicon-book"> '.utf8_decode($arquivo['nome']).'</span></a></li>';
                    }
                        
                }
                echo "</ul>";
            }
            
            
            if($atividades){
                echo "<h4 style=\"color:red\">ATIVIDADES</h4>";
                echo "<ul class=\"nav nav-pills nav-stacked\">";
                
                foreach($atividades as $atividade){
?>
                <li><a href="./atividade.php?unidade_id=<?php echo $unidade['id']?>&curso=<?php echo utf8_decode($unidade['nome']);?>&avaliacao=<?php echo $atividade['id'];?>"><span class="glyphicon glyphicon-list-alt"> <?php echo utf8_decode($atividade['nome']);?></span></a></li>
<?php
                }
                echo "</ul>";
            }
?>
            </div>

<?php
        }
    }
    else{
        echo "<h4>Não há material disponível.</h4>";
    }
?>      
    <div class="well">
        <h3>Avaliar Curso</h3>
        <?php
        if(viu_todos_videos($_SESSION['id'],$_GET['id'])){
        ?>
        <input name="curso_id" value="<?php echo $_GET['id'];?>" id="curso_id" type="hidden"/>
        <input name="usuario_id" value="<?php echo $_SESSION['id'];?>" id="usuario_id" type="hidden"/>
        <!-- codigo de terceiros-->
        <input name="rating" value="0" id="rating_star" type="hidden" postID="1"/>
        <!--Fim -->
        <form class="form-horizontal" method="post" action="salvar_comentario.php">
            <fieldset>	
                Insira um breve comentário
                <div class="form-group">
                    <div class="col-sm-6">
                        <?php 
                            if(sizeof($comentario) > 0){
                        ?>
                        <input type="text" class="form-control" id="usuario" name="comentario" value="<?php echo utf8_decode($comentario[0]['comentario']);?>">
                        <?php    
                            }
                            else{
                        ?>
                        <input type="text" class="form-control" id="usuario" name="comentario">    
                        <?php
                                
                            }
                        ?>
                        
                        <input type="hidden" name="curso" value="<?php echo $_GET['id'];?>">
                        <input name="curso_id" value="<?php echo $_GET['id'];?>" id="curso_id" type="hidden"/>
                        <input name="usuario_id" value="<?php echo $_SESSION['id'];?>" id="usuario_id" type="hidden"/>
                    </div>
                </div>
            </fieldset>
        </form>
        <?php
            }
            else{
                echo "Você precisar ver todos os vídeos para poder avaliar o curso";
            }
        ?>
    </div>
    <div class="well">
        <h3>CERTIFICADO</h3>
        
        <?php 
            if(testa_aptidao($_SESSION['id'],$_GET['id'])){
         ?>
        <form class="form" method="post" action="gera_certificado.php">
                <fieldset>	
                    <div class="form-group">
                        <input type="hidden" name="curso" value="<?php echo $_GET['id'];?>">
                        <button class="btn btn-sm btn-primary" type="submit">Obter Certificado</button>
                    </div>
                </fieldset>
        </form>
        <?php
            }
            else{
        ?>
                <form class="form" method="post" action="gera_certificado.php">
                <fieldset>	
                    <div class="form-group">
                        <input type="hidden" name="curso" value="<?php echo $_GET['id'];?>">
                        <button class="btn btn-sm btn-primary" type="submit" disabled>Obter Certificado</button>
                    </div>
                </fieldset>
                </form>
        <?php
            }
        ?>
        
    </div>

</div>

<div class="row"></div>
<?php
    include_once("../core/templates/rodape.php");
?>