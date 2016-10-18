<?php
    include_once("utils.php");
    session_start();
    testa_autenticacao();
       
    try{
        $nome = utf8_encode(htmlspecialchars($_POST['name']));
        $categoria = utf8_encode(htmlspecialchars($_POST['categoria']));
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));
        $sobre = utf8_encode(htmlspecialchars($_POST['sobre']));
        
        $instrutor = utf8_encode(htmlspecialchars($_POST['instrutor']));
        
        if(isset ($_FILES["file"])) {
            if($_FILES["file"]["tmp_name"]!= NULL) {
                $conteudo = file_get_contents($_FILES["file"]["tmp_name"]); 
                
                $tipo = NULL;
                $tipo = strtolower(trim($_FILES["file"]["name"]));
                $tipo = split("[/\\.]", $tipo) ;
                $str = count($tipo)-1;
                $tipo = $tipo[$str];
                $tipo = str_replace("jpg","jpeg",$tipo);
		

                if($conteudo != NULL && ($tipo == "jpeg" || $tipo == "png" || $tipo == "bmp" || $tipo == "gif")) {

                    $conexao = conn_mysql();
                    $SQLInsert = 'INSERT INTO curso (nome, categoria_id, descricao, sobre, instrutor_id, image) VALUES(?,?,?,?,?,?)';
                    

                    $operacao = $conexao->prepare($SQLInsert);					  
                    $atualiza = $operacao->execute(array($nome, $categoria, $descricao, $sobre, $instrutor, bin2hex($conteudo)));

                    $linha_afetada = $operacao->rowCount();

                    if($atualiza){
                        include_once("../core/templates/cabecalho_adm.php");
                        echo "<h1>Curso cadastrado com sucesso.</h1>\n";
                        echo "<p class=\"lead\"><a href=\"./modificar_curso.php\">Ir para a listagem dos cursos</a></p>\n";
                        include_once("../core/templates/rodape.php");
                    }
                    else{
                        include_once("../core/templates/cabecalho_adm.php");
                        echo "<h1>Erro na operacao.</h1>\n";
                        $arr = $operacao->errorInfo();
                        $erro = utf8_decode($arr[2]);
                        echo "<p>$erro</p>";						
                        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
                        include_once("../core/templates/rodape.php");
                    }
                    
                    $conexao = null; 
                   
                }
                else{
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Falha na abertura do arquivo.</h1>\n";
                    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
                    include_once("../core/templates/rodape.php");   
                }
                
            }
            else{
                $conexao = conn_mysql();
              
                $SQLInsert = 'INSERT INTO curso (nome, categoria_id, descricao, sobre, instrutor_id) VALUES(?,?,?,?,?)';


                $operacao = $conexao->prepare($SQLInsert);					  
                $atualiza = $operacao->execute(array($nome, $categoria, $descricao, $sobre, $instrutor));

                if($atualiza){
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Curso cadastrado com sucesso.</h1>\n";
                    echo "<p class=\"lead\"><a href=\"./modificar_curso.php\">Ir para a listagem dos cursos</a></p>\n";
                    include_once("../core/templates/rodape.php");
                }

                else{
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Erro na operacao.</h1>\n";
                    $arr = $operacao->errorInfo();
                    $erro = utf8_decode($arr[2]);
                    echo "<p>$erro</p>";						
                    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1)\">Voltar para a página anterior</a></p>\n";
                    include_once("../core/templates/rodape.php");
                }

                $conexao = null;
            }
        }
        
    }
    catch (PDOException $e){
        echo "Erro!: " . $e->getMessage() . "<br>";
        die();
    }
    
?>

