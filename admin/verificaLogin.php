<?php
    session_start();
    require_once("../core/conf/confBD.php");
   
    if(isset($_POST["login"])){
        $log = utf8_encode(htmlspecialchars($_POST["login"]));
        $senha = utf8_encode(htmlspecialchars($_POST["passwd"]));
    }
   
    else{
        header("Location:./erroLogin.php");
        die();
    }         
    
    $conexao = conn_mysql();
    
    $SQLSelect = 'SELECT * FROM usuario INNER JOIN tipo_usuario on tipo_usuario.id=usuario.tipo_id '
               . 'WHERE password=MD5(?) AND login=? AND usuario.tipo_id=?';
    $operacao = $conexao->prepare($SQLSelect);					  
    $pesquisar = $operacao->execute(array($senha, $log, '2'));
    $resultados = $operacao->fetchAll();
    
    $conexao = null;

    if (count($resultados)!=1){	
        header("Location:./erroLogin.php");
        die();
    }
    
    else{    
        $_SESSION['auth']=true;
        $_SESSION['email'] = $resultados[0]['email'];
        $_SESSION['id'] = $resultados[0]['id'];
        $_SESSION['adm'] = $resultados[0]['tipo_id'];
        $_SESSION['usuario'] = $log;

        header("Location: ../admin/admin.php");
        die();
    }
    
?>