<?php
include_once("../cursos/utils.php");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
session_start();
testa_autenticacao();

$curso_id =  $_POST['curso'];
$curso = detalhes($curso_id);

?>

<html lang="pt-br">
    <head><meta charset="utf-8"></head>
    <div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
        <div style="width:750px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
            <span style="font-size:50px; font-weight:bold">Certificado de Conclusão</span>
            <br><br>
            <span style="font-size:25px"><i>Certificamos que o(a) estudante</i></span>
            <br><br>
            <span style="font-size:30px"><b><?php echo $_SESSION['usuario'] ?></b></span><br/><br/>
            <span style="font-size:25px"><i>completou o curso</i></span> <br/><br/>
            <span style="font-size:30px"><?php echo $curso[0]['nome'] ?></span> <br/><br/>
            <span style="font-size:20px">com êxito.</span> <br/><br/><br/> <?php echo strftime('%d de %B de %Y', strtotime('today'));?>
        </div>
    </div>
</html>

   