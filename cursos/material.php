<?php
include_once("../core/templates/cabecalho.php");
include_once ("utils.php");
testa_autenticacao();
?>


<div class="col-sm-3">
    
    <ul class="breadcrumb">
        <li><a href="../conta/painel.php">Meu Painel</a></li>
        <li><a href="javascript:window.history.go(-1)"><?php echo $_GET['unidade'];?></a></li>
        <li>Vídeo</li>
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
    $videos = retorna_video($_GET['video']);
    
    if($videos){
        foreach($videos as $video){
            echo html_entity_decode($video['embedded']);

        }
        
        //tenho que testar se já existe tupla
        try{
            $usuario_id = utf8_encode(htmlspecialchars($_SESSION['id']));
            $unidade_id = utf8_encode(htmlspecialchars($_GET['id']));
            $material_id = $_GET['video'];
            
            $conexao = conn_mysql();
            $SQLSelect = "SELECT * FROM material_usuario WHERE usuario_id = ? AND material_id = ?";
            $operacao = $conexao->prepare($SQLSelect);					  
            $operacao->execute(array($usuario_id, $material_id));
            $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
            $conexao = null;
            if($resultados){
                echo "<h4><span class=\"label label-success\">Visualizado</span></h4>";    
            }
            else{
                $conexao = conn_mysql();
                $SQLInsert = 'INSERT INTO material_usuario (material_id, usuario_id, unidade_id) VALUES (?, ?, ?)';
                $operacao = $conexao->prepare($SQLInsert);					  
                $inserir = $operacao->execute(array($material_id, $usuario_id, $unidade_id));
                // fecha a conexão ao banco
                $conexao = null;
            }
        } 
        catch (Exception $ex) {
            $ex->getMessage();
            die;
        }
    }
    else{
            echo "<p>Erro</p>";
    }
?>    
</div>

<div class="row"></div>





<?php
   
    include_once("../core/templates/rodape.php");
?>