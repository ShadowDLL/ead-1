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
        $palavras_chave = split(" ",utf8_encode(htmlspecialchars($_POST['keywords'])));
        $id = utf8_encode(htmlspecialchars($_POST['id_curso']));
       
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

                    $SQLInsert = 'UPDATE curso SET nome = ?, categoria_id = ?, descricao = ?, sobre = ?, instrutor_id = ?, image = ? WHERE id = ?';


                    $operacao = $conexao->prepare($SQLInsert);					  
                    $atualiza = $operacao->execute(array($nome, $categoria, $descricao, $sobre, $instrutor, bin2hex($conteudo),$id));

                    if($atualiza){
                        /**************/
                        $SQLInsert = 'DELETE FROM palavra_curso WHERE curso_id = ?';
                        $operacao = $conexao->prepare($SQLInsert);					  
                        $atualiza = $operacao->execute(array($id));
                        foreach ($palavras_chave as $palavra){
                            $palavra = trim($palavra);

                            $SQLInsert = 'INSERT INTO palavra_chave(nome) VALUES (?)';
                            $operacao = $conexao->prepare($SQLInsert);					  
                            $atualiza = $operacao->execute(array($palavra));

                            if($atualiza){
                                $palavra_chave_id = $conexao->lastInsertId();

                                $SQLInsert = 'INSERT INTO palavra_curso(curso_id, keyword_id) VALUES (?,?)';
                                $operacao = $conexao->prepare($SQLInsert);
                                $atualiza = $operacao->execute(array($id, $palavra_chave_id));
                            }
                            else{
                                //Palavra chave já existe e necessário descobrir qual é o id dela
                                $SQLSelect = 'SELECT id FROM palavra_chave WHERE nome LIKE ?';
                                $operacao = $conexao->prepare($SQLSelect);	
                                $operacao->execute(array("%$palavra%"));

                                $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
                                $SQLInsert = 'INSERT INTO palavra_curso(curso_id, keyword_id) VALUES (?,?)';
                                $operacao = $conexao->prepare($SQLInsert);
                                $atualiza = $operacao->execute(array($id, $resultados[0]['id']));
                            }
                        }
                    /*************/
                        
                        include_once("../core/templates/cabecalho_adm.php");
                        echo "<h1>Dados alterados com sucesso.</h1>\n";
                        echo "<p class=\"lead\"><a href=\"./curso_edit.php?curso=$id\">Voltar para a página anterior</a></p>\n";
                        
                        include_once("../core/templates/rodape.php");
                    }
                    else{
                        include_once("../core/templates/cabecalho_adm.php");
                        echo "<h1>Erro na operacao.</h1>\n";
                        $arr = $operacao->errorInfo();
                        $erro = utf8_decode($arr[2]);
                        echo "<p>$erro</p>";						
                        echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1);self.location.reload();)\">Voltar para a página anterior</a></p>\n";
                        include_once("../core/templates/rodape.php");
                    }
                    
                    $conexao = null; 
                   
                }
                else{
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Falha na abertura do arquivo.</h1>\n";
                    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1);self.location.reload();\">Voltar para a página anterior</a></p>\n";
                    include_once("../core/templates/rodape.php");   
                }
                
            }
            else{
                $conexao = conn_mysql();
               
                $SQLInsert = 'UPDATE curso SET nome = ?, categoria_id = ?, descricao = ?, sobre = ?, instrutor_id = ? WHERE id = ?';


                $operacao = $conexao->prepare($SQLInsert);					  
                $atualiza = $operacao->execute(array($nome, $categoria, $descricao, $sobre, $instrutor, $id));

                if($atualiza){
                    $SQLInsert = 'DELETE FROM palavra_curso WHERE curso_id = ?';
                    $operacao = $conexao->prepare($SQLInsert);					  
                    $atualiza = $operacao->execute(array($id));
                    /**************/
                    foreach ($palavras_chave as $palavra){
                        $palavra = trim($palavra);

                        $SQLInsert = 'INSERT INTO palavra_chave(nome) VALUES (?)';
                        $operacao = $conexao->prepare($SQLInsert);					  
                        $atualiza = $operacao->execute(array($palavra));

                        if($atualiza){
                            $palavra_chave_id = $conexao->lastInsertId();

                            $SQLInsert = 'INSERT INTO palavra_curso(curso_id, keyword_id) VALUES (?,?)';
                            $operacao = $conexao->prepare($SQLInsert);
                            $atualiza = $operacao->execute(array($id, $palavra_chave_id));
                        }
                        else{
                            //Palavra chave já existe e necessário descobrir qual é o id dela
                            $SQLSelect = 'SELECT id FROM palavra_chave WHERE nome LIKE ?';
                            $operacao = $conexao->prepare($SQLSelect);	
                            $operacao->execute(array("%$palavra%"));

                            $resultados = $operacao->fetchAll(PDO::FETCH_ASSOC);
                            $SQLInsert = 'INSERT INTO palavra_curso(curso_id, keyword_id) VALUES (?,?)';
                            $operacao = $conexao->prepare($SQLInsert);
                            $atualiza = $operacao->execute(array($id, $resultados[0]['id']));
                        }
                    }
                    /*************/
                    
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Curso alterado com sucesso.</h1>\n";
                    //echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1);self.location.reload();\">Voltar para a página anterior</a></p>\n";
                    echo "<p class=\"lead\"><a href=\"./curso_edit.php?curso=$id\">Voltar para a página anterior</a></p>\n";
                        
                    include_once("../core/templates/rodape.php");
                }

                else{
                    include_once("../core/templates/cabecalho_adm.php");
                    echo "<h1>Erro na operacao.</h1>\n";
                    $arr = $operacao->errorInfo();
                    $erro = utf8_decode($arr[2]);
                    echo "<p>$erro</p>";						
                    echo "<p class=\"lead\"><a href=\"javascript:window.history.go(-1);self.location.reload();\">Voltar para a página anterior</a></p>\n";
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

