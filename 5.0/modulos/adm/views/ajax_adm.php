
<STYLE type="text/css">
	.files input {
		outline: 2px dashed #CCC;
		outline-offset: -10px;
		-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
		transition: outline-offset .15s ease-in-out, background-color .15s linear;
		padding: 120px 0px 85px 35%;
		text-align: center !important;
		margin: 0;
		width: 100% !important;
	}
	.files input:focus{     outline: 2px dashed #CCC;  outline-offset: -10px;
		-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
		transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #CCC;
	 }
	.files{ position:relative}
	.files:after {  pointer-events: none;
		position: absolute;
		top: 60px;
		left: 0;
		width: 50px;
		right: 0;
		height: 56px;
		content: "";
		background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
		display: block;
		margin: 0 auto;
		background-size: 100%;
		background-repeat: no-repeat;
	}
	.color input{ background-color:#f1f1f1;}
	
.image-preview-input {
    position: relative;
	overflow: hidden;
	margin: 0px;    
    color: #333;
    background-color: #fff;
    border-color: #ccc;    
}
.image-preview-input input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
.image-preview-input-title {
    margin-left:2px;
}
</STYLE>

<script>
$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
</script>

<?php 
	$dir=dirname(dirname(__DIR__), 2). '/classes';
	include("$dir/class_outros.php");
	include("$dir/class_config.php");
	include("$dir/class_loadpage.php");  
	$outros = new outros();
	$config = new config();
	$outros->formfile();
	
	$dados = $_GET['dados'];
	$dados = explode('|', $dados);
	$dados['opcao'] = $dados[0];
	$dados['id_epi-ferramentas'] = $dados[1];
	$id_usuario_session = $outros->asession('id');
	$data_atual = $outros->horaatual("datahora_ptbr");
	
	
	
	if($dados['opcao'] == "")
	{
		$obj = $config->conexaoBD("configuracoes","count","select","");
		$filial_config = $obj->FILIAL_CONFIGURACAO;
		$titulo_site_config = $obj->TITULO_SITE_CONFIGURACAO;
		echo"	
		<div id='msg' class='hidden'></div>
		<form action='javascript:func()' id='ajax_form' method='POST'>
			<section class='content-header'>
				<h1>
					Administrador
				</h1>
				<ol class='breadcrumb'>
					<li><a href='index.php?pagina=painel'><i class='fa fa-dashboard'></i> Inicio</a></li>
					<li class='active'>Administrador</li>
				</ol>
			</section>
			<br>
			<div class='nav-tabs-custom'>
				<ul class='nav nav-tabs'>
					<li class='active'><a href='#tab_0' data-toggle='tab'>Empresa</a></li>
					<li><a href='#tab_1' data-toggle='tab'>Modulos</a></li>
					<li><a href='#tab_2' data-toggle='tab'>nfe_teste</a></li>
				</ul>
				<div class='tab-content'>
					<div class='tab-pane active' id='tab_0'>
						<fieldset id='pessoal' class='form-group' ";if($opcao == "visualizar"){echo"disabled";} echo ">
							<div class='row'>
								<div class='col-md-1'>
									<label for='rua_func'>Filial</label>
									<input type='text' class='form-control' value='$filial_config' name='filial_config'>
								</div>
								<div class='col-md-3'>
									<label for='nome_func' id='razaonome'>Titulo do sistema</label>
									<input type='text' class='form-control' id='titulo_site_config' name='titulo_site_config' value='$titulo_site_config'>
								</div>
							</div>
						</fieldset>
					</div>
					<div class='tab-pane' id='tab_1'>
						<fieldset id='pessoal' class='form-group' ";if($opcao == "visualizar"){echo"disabled";} echo ">
							<div class='row'>
								<div class='col-md-8'>
									<a class='btn btn-primary form-control'";?> onclick="load_tabela('adm/views/_load_modulos')"<?php echo">Atualizar</a>
								</div>
							</div>
							<div class='row'>
								<div class='col-md-8'>
									<center><div id='load_tabela'></div></center>
								</div>
							</div>
						</fieldset>  
					</div>
					<div class='tab-pane' id='tab_2'>
						<fieldset id='pessoal' class='form-group' ";if($opcao == "visualizar"){echo"disabled";} echo ">
								<div class='row'>
									<div class='col-xs-12 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2'>
										<form id='ajax_form' method='POST'>
											<input type='hidden' id='opcao2' name='opcao2' value='adm'>
											<input type='hidden' id='opcao' name='opcao' value='carregar-nf'>
											<div class='form-group files'>
												<label>Upload Your File </label>
												<input type='file' class='form-control' name='opcao' multiple=''>
											</div>
											<button type='submit' class='btn btn-primary form-control'>Carregar nf-e</button>
										</form>
								  </div>
								</div>
							
							";
								//$dir = '41180304200198000108550010006184021187635401-procNFe.xml'; // Diretório do arquivo
								$dir = '../integra'; // Diretório do arquivo
								$pasta = opendir($dir); // Abrindo o diretório
								while ($arquivo = readdir($pasta))
								{ // lendo os arquivos do diretorio
									//Verificacao para pegar apenas os arquivos e ignorar as pastas
									if ($arquivo != '.' && $arquivo != '..')
									{
										
										//Começamos agora a leitura do arquivo XML.
										$arquivo = simplexml_load_file("../integra/$arquivo");
										foreach($arquivo->NFe as $key => $xml)
										{
											$NUMERO = "".$xml->infNFe->ide->nNF.""; //NUMERO NFE
											
											$RZ_EMITENTE = "".$xml->infNFe->emit->xNome.""; //RAZÃO EMITENTE
											$CNPJ_EMIT = "".$xml->infNFe->emit->CNPJ.""; // CNPJ EMITENTE
											
											
											$RZ_DESTIN = "".$xml->infNFe->dest->xNome.""; // RAZÃO DESTINATÁRIO
											$CNPJ_DEST = "".$xml->infNFe->dest->CNPJ.""; // CNPJ DESTINATÁRIO
											
											$DATA_EMIT = "".$xml->infNFe->ide->dhEmi.""; // DATA EMISSÃO
											$VALOR_TOT = "".$xml->infNFe->total ->ICMSTot->vNF."";//VALOR NF-E
											// exibindo os dados coletados
											echo "Numero: "."$NUMERO <br>";
											
											echo "Emitente: "."$RZ_EMITENTE <br>";
											echo "CNPJ: "."$CNPJ_EMIT <br> ";
											
											echo "Destinatário: "."$RZ_DESTIN <br>";
											echo "CNPJ: "."$CNPJ_DEST <br>";
											
											echo "Data Emissão: "."$DATA_EMIT <br> ";
											echo "Valor Total: "."$VALOR_TOT <br>";
											
											echo "<br>";
											
											if ($item->infNFe->det->imposto->ICMS->ICMS00){
												echo $orig = $item->infNFe->det->imposto->ICMS->ICMS00->orig;
												echo $CST = $item->infNFe->det->imposto->ICMS->ICMS00->CST;
												echo $modBC = $item->infNFe->det->imposto->ICMS->ICMS00->modBC;
												echo $pRedBC = 0.00;
												echo $vBC = $item->infNFe->det->imposto->ICMS->ICMS00->vBC;
												echo $pICMS = $item->infNFe->det->imposto->ICMS->ICMS00->pICMS;
												echo $vICMS = $item->infNFe->det->imposto->ICMS->ICMS00->vICMS;
												echo $modBCST = 0.00;
												echo $pMVAST = 0.00;
												echo $pREDBCST = 0.00;
												echo $vBCST = 0.00;
												echo $pICMSST = 0.00;
												echo $vICMSST = 0;
												echo $UFST = 0;
												echo $pBCop = 0;
												echo $vBCSTRet = 0.00;
												echo $vICMSSTRet = 0.00;
												echo $motDesICMS = 0.00;
												echo $vBCSTDest = 0.00;
												echo $vICMSSTDest = 0.00;
												echo $pCredSN = 0;
												echo $vCredICMSSN = 0.00;
											}
											
											if ($item->infNFe->det->imposto->ICMS->ICMS10){
												echo $orig = $item->infNFe->det->imposto->ICMS->ICMS10->orig;
												echo $CST = $item->infNFe->det->imposto->ICMS->ICMS10->CST;
												echo $modBC = $item->infNFe->det->imposto->ICMS->ICMS10->modBC;
												echo $pRedBC = 0.00;
												echo $vBC = $item->infNFe->det->imposto->ICMS->ICMS10->vBC;
												echo $pICMS = $item->infNFe->det->imposto->ICMS->ICMS10->pICMS;
												echo $vICMS = $item->infNFe->det->imposto->ICMS->ICMS10->vICMS;
												echo $modBCST = $item->infNFe->det->imposto->ICMS->ICMS10->modBCST;
												echo $pMVAST = $item->infNFe->det->imposto->ICMS->ICMS10->pMVAST;
												echo $pREDBCST = 0.00; //informa se quizer
												echo $vBCST = $item->infNFe->det->imposto->ICMS->ICMS10->vBCST;
												echo $pICMSST = $item->infNFe->det->imposto->ICMS->ICMS10->pICMSST;
												echo $vICMSST = $item->infNFe->det->imposto->ICMS->ICMS10->vICMSST;
												echo $UFST = 0;
												echo $pBCop = 0;
												echo $vBCSTRet = 0.00;
												echo $vICMSSTRet = 0.00;
												echo $motDesICMS = 0.00;
												echo $vBCSTDest = 0.00;
												echo $vICMSSTDest = 0.00;
												echo $pCredSN = 0;
											}	
										}
										
									}
								}
							echo"
							
						</fieldset>  
					</div>
				</div>
				<div class='box-footer'>
					<div class='row'>
						<div class='col-md-3'>
							<br><button type='submit' class='btn btn-primary form-control' name='enviar' value='enviar'>Salvar</button>
						</div>
						<div class='col-md-2'>
							<br><a class='btn btn-primary form-control' ";?>onclick="load_modulos('adm/views/ajax_adm','')"<?php echo">Voltar</a>
						</div>
					</div> 
				</div>
			</div>
		</form>";
	}
?>