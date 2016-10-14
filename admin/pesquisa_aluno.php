<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>
$(document).ready(function(){
    $("#buscar_usuario").click(function(){
        var usuario = $("#pesquisa_usuario").val();

        //passar as datas também
        $.ajax({  					
           url: "usuario_ajax.php", 
           dataType: 'html',
           data: {usuario:usuario},
           type: "POST", 

                beforeSend: function ()   { 
                        $('#carregando').show();
                },
                success: function(data){
                        $('#carregando').hide();
                        $("#resBusca").html(data);

                },
                error: function(data){
                        $('#carregando').html(data);
                }			
        });
    });
});
</script>

<?php
include_once("../core/templates/cabecalho_adm.php");
include_once ("../admin/utils.php");
testa_autenticacao();
?>

<div class="col-sm-14">
    <ul class="breadcrumb">
        <li><a href="./admin.php">Início</a></li>
        <li>Relatório</li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-12">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" id="pesquisa_usuario" class="form-control"  placeholder="Pesquisar usuário por login" >
                <span class="input-group-addon">
                    <button type="button" id="buscar_usuario">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
        </div>
    </div>
</div>

<div id="resBusca"></div>

<div class="row"></div>
<?php
    include_once("../core/templates/rodape.php");
?>