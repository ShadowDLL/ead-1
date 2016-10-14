<?php
include_once("../core/templates/cabecalho.php");
include_once ("utils.php");
testa_autenticacao();
$avaliacao = $_GET['avaliacao'];
$usuario_id = $_SESSION['id'];
$avalicao_nome = "";

try{
   $resultados = retorna_atividades($avaliacao);
   $avaliacao_nome = $resultados[0]['nome']; 
   $avaliacao_id = $resultados[0]['id'];
   
   $atividade_realizada_bool = sizeof(atividade_foi_realizada($usuario_id, $avaliacao));
}
catch(Exception $excep){
   echo "Erro!: " . $excep->getMessage() . "\n";
   die();
}

?>

<div class="col-sm-3">
    
    <ul class="breadcrumb">
        <li><a href="../conta/painel.php">Meu Painel</a></li>
        <li><a href="javascript:window.history.go(-1)"><?php echo $_GET['curso'];?></a></li>
        <li>Atividade</li>
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
    <h3><?php echo $avaliacao_nome;?></h3>
    <?php
    if($atividade_realizada_bool > 0){
       $acertos = acima_70_por_cento_unidade($usuario_id, $_GET['unidade_id']) * 100;
       
       echo "<h5><span class=\"label label-info\">Taxa de acerto: ".$acertos."%</span></h5>";
    }
    ?>
    <form class="form-horizontal" role="form" method="post" action="salvar_avaliacao.php">
<?php
    $contador = 1;
    $questoes = retorna_questao_atividade($avaliacao);
    
    foreach ($questoes as $questao) {
?>
    <div class="well">
<?php
        echo "<h4>Questão ".$contador."</h4>";
        echo "<p>".html_entity_decode($questao['pergunta'])."</p>";
        
        try {
            $alternativas = retorna_alternativas($questao['id']);
            $resposta_usuario = retorna_resposta_usuario($questao['id'], $usuario_id);
            
            $num_respostas = sizeof($resposta_usuario);                     
?>
<?php 
            foreach ($alternativas as $alternativa){
                if(($num_respostas > 0) && ($alternativa['id'] == $resposta_usuario[0]['alternativa_id'])){
?>
                    <div class="form-group">
                        <label class="col-sm-10"><input type="radio" name="<?php echo $questao['id'];?>" value="<?php echo $alternativa['id']; ?>" required checked="checked"> <?php echo utf8_decode($alternativa['sentenca']);?></label>
                    </div>
<?php
                }
                else{  
?>
                    <div class="form-group">
                        <label class="col-sm-10"><input type="radio" name="<?php echo $questao['id'];?>" value="<?php echo $alternativa['id']; ?>" required> <?php echo utf8_decode($alternativa['sentenca']);?></label>                    
                    </div>
<?php
                }
                
            }
            
            if($atividade_realizada_bool > 0){
                confere_resposta($questao['id'], $usuario_id);
            }
            
                
            
        } 
        catch (Exception $ex) {
            print_r($ex->getMessage());  
        }
        $contador++;
?>      
    </div> 
<?php
    }
?>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="hidden" name="atividade" value="<?php echo $avaliacao_id;?>">
            </div>
        </div>
        <div class="form-group">
<?php 
        if($atividade_realizada_bool > 0){
?>    
            <div class="col-sm-10">
                <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary" disabled>
                <input id="submit" name="submit" type="submit" value="Enviar" class="btn btn-primary" disabled>
            </div>
<?php
        }
        else{
?>
            <div class="col-sm-10">
                <input id="submit" name="submit" type="submit" value="Salvar" class="btn btn-primary">
                <input id="submit" name="submit" type="submit" value="Enviar" class="btn btn-primary">
            </div>
<?php
        }
?>
        </div>
    </form>
</div>

<div class="row"></div>
<?php
    include_once("../core/templates/rodape.php");
?>