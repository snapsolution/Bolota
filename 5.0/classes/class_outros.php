<?php 
ob_start();
session_start();
class outros{

	public function checar_modulo(){
		$dir = "../../../modulos/";
		foreach (glob ($dir."*", GLOB_ONLYDIR) as $pastas) {
			if (is_dir ($pastas)) {
				$pastas = str_replace ($dir,"",$pastas);
				$modulos = $pastas."|".$modulos;
			}
		}

		return $modulos;
		
		
	}

	public function msg($tipo){
	
		if($tipo == "e"){$tipo = "<center><div id='msg' class='alert alert-danger'>Senha incorreta ou Usuario não existe!!</div></center>";}
		
		else if($tipo == "ac"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>Informações alteradas!!</div></center>";}
		else if($tipo == "ii"){$tipo = "<center><div id='msg' class='alert alert-success'><strong>Alerta! </strong>as informações foram alteradas, mas a imagem esta invalida e não pode ser carregada.</div></center>";}
		else{$tipo = "<center><div id='msg' class='alert alert-danger'>Erro desconhecido!!$tipo</div></center>";}
		return $tipo;
	}

	public function asession($sessao){
		if($sessao == 'login')
		{
			if(isset($_SESSION['login']) == null){
				return $login = "";
			}
			else{
				return $login = $_SESSION['login'];
			}
		}
		else if($sessao == 'id')
		{
			if(isset($_SESSION['id']) == null){
				return $id = "";
			}
			else{
				return $id = $_SESSION['id'];
			}
		}
		else if($sessao == 'nome')
		{
			if(isset($_SESSION['nome']) == null){
				return $nome = "";
			}
			else{
				return $nome = $_SESSION['nome'];
			}
		}
	}
	
	public function session($nome, $var){
	
		$_SESSION[$nome] = $var;
	}
	
	public function automes($mes){
	
		if($mes == 1){$mes = "Janeiro";}
		else if($mes == 2){$mes = "Fevereiro";}
		else if($mes == 3){$mes = "Março";}
		else if($mes == 4){$mes = "Abril";}
		else if($mes == 5){$mes = "Maio";}
		else if($mes == 6){$mes = "Junho";}
		else if($mes == 7){$mes = "Julho";}
		else if($mes == 8){$mes = "Agosto";}
		else if($mes == 9){$mes = "Setembro";}
		else if($mes == 10){$mes = "Outubro";}
		else if($mes == 11){$mes = "Novembro";}
		else if($mes == 12){$mes = "Dezembro";}
		else{$mes = "Mes incorreto";}
		
		return $mes;
	}
	
	public function uploadfile2($dados){
		
		

		if($dados['opcao2'] == 'manuais')
		{
			if ( isset( $_FILES[ 'pdf_manu' ][ 'name' ] ) && $_FILES[ 'pdf_manu' ][ 'error' ] == 0 )
			{
				$arquivo_tmp = $_FILES['pdf_manu']['tmp_name'];
				$nome = $_FILES['pdf_manu']['name'];

				$extensao = pathinfo($nome,PATHINFO_EXTENSION);
				$extensao = strtolower ($extensao);

				if (strstr ('.pdf', $extensao))
				{
					$novoNome = $dados['nome_manu'] . '.' . $extensao;
					$destino = '../manuais/' . $novoNome;
					move_uploaded_file($arquivo_tmp, $destino);
					
					$result = "ac";
					return $result;
				}
				else{
					$result = "ii";
					return $result;
				}
			}
			else
			{
				$result="ac";
				return $result;
			}
		}

	}

	public function uploadfile($dados){
		//https://php.eduardokraus.com/upload-de-imagens-com-php
		
		$arquivo_tmp = $_FILES['img_func']['tmp_name'];

		$nome = $_FILES['img_func']['name'];
		$extensao = pathinfo($nome,PATHINFO_EXTENSION);
		$extensao = strtolower ($extensao);
		if (strstr ('.jpg;.jpeg;.gif;.png;.svg;.bmp', $extensao)){
			$novoNome = $dados['cod_func'] . '.' . $extensao;
			$destino = '../img_usuario/' . $novoNome;
			move_uploaded_file($arquivo_tmp, $destino);
			
			$result = "ac";
			return $result;
		}
		else{
			$result = "ii";
			return $result;
		}

		/* if ( isset( $_FILES[ 'img_func' ][ 'name' ] ) && $_FILES[ 'img_func' ][ 'error' ] == 0 ) {
			echo 'Você enviou o arquivo: <strong>' . $_FILES[ 'img_func' ][ 'name' ] . '</strong><br />';
			echo 'Este arquivo é do tipo: <strong > ' . $_FILES[ 'img_func' ][ 'type' ] . ' </strong ><br />';
			echo 'Temporáriamente foi salvo em: <strong>' . $_FILES[ 'img_func' ][ 'tmp_name' ] . '</strong><br />';
			echo 'Seu tamanho é: <strong>' . $_FILES[ 'img_func' ][ 'size' ] . '</strong> Bytes<br /><br />';
		 
			$arquivo_tmp = $_FILES[ 'img_func' ][ 'tmp_name' ];
			$nome = $_FILES[ 'img_func' ][ 'name' ];
		 
			// Pega a extensão
			$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
		 
			// Converte a extensão para minúsculo
			$extensao = strtolower ( $extensao );
		 
			// Somente imagens, .jpg;.jpeg;.gif;.png
			// Aqui eu enfileiro as extensões permitidas e separo por ';'
			// Isso serve apenas para eu poder pesquisar dentro desta String
			if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
				// Cria um nome único para esta imagem
				// Evita que duplique as imagens no servidor.
				// Evita nomes com acentos, espaços e caracteres não alfanuméricos
				$novoNome = uniqid ( time () ) . '.' . $extensao;
		 
				// Concatena a pasta com o nome
				$destino = '../img_usuario/ ' . $novoNome;
		 
				// tenta mover o arquivo para o destino
				if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
					echo 'Arquivo salvo com sucesso em : <strong>' . $destino . '</strong><br />';
					echo ' < img src = "' . $destino . '" />';
				}
				else
					echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
			}
			else
				echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
		}
		else
			echo 'Você não enviou nenhum arquivo!';
 		*/
	}

	public function deletefile($caminho_manual){		
		
		$caminho = '../manuais/' . $caminho_manual;
		if(file_exists($caminho)){
			echo unlink($caminho);

			$result = "sdsdsdsdsdsd";
			return $result;
		}
		else{
			$result = "aaaaaaaaaaaaaa";
			return $result;
		}
	}

	public function horaatual($tipo){		
		date_default_timezone_set('America/Sao_Paulo');
		if($tipo=="datahora_ptbr")
		{
			$date = date('d-m-Y H:i');
		}
		
		else if($tipo=="datahora_eng")
		{
			$date = date('Y-m-d H:i');
		}

		return $date;
	}
	
	public function calcularidade(){
		echo"
		<script>
			function calcularidade(nascimento) 
			{
				alert
				var nascimento = nascimento.split('/');
				alert 2
				var dataNascimento = new Date(parseInt(nascimento[2], 10), parseInt(nascimento[1], 10) - 1, parseInt(nascimento[0], 10));
				var diferenca = Date.now() - dataNascimento.getTime();
				
				var idade = new Date(diferenca);
				idade = Math.abs(idade.getUTCFullYear() - 1970);
				document.getElementById('idade').value = idade;
				
			}
		</script>
		";
	}
	
	public function conferirsenha(){
		echo"
		<script>
			function conferirsenha()
			{
				senha2 = document.getElementById('senha2_func').value;
				senha = document.getElementById('senha_func').value;
				
				if(senha2)
				{
					if(senha2 != senha)
					{
						alert('Senha Invalida!');
						document.getElementById('senha_func').select();
					}
					
				}
			}	
		</script>
		";
	}
	
	public function lerxml(){
		//https://www.todoespacoonline.com/w/2014/07/arquivos-xml-com-php/
		//http://blog.clares.com.br/ler-xml-com-php/
		//http://php.net/manual/pt_BR/book.simplexml.php
		//https://pt.stackoverflow.com/questions/213483/ler-xml-em-php-e-pegar-seus-dados
		// Faz o load do arquivo XML e retorna um objeto
		/* 		$arquivo_xml = simplexml_load_file('meus_links.xml');
		 
		// Loop para ler o objeto
		for ( $j = 0; $j < count( $arquivo_xml ); $j++ ) {
		 // Imprime o valor o valor da tag <id></id>
		 echo $arquivo_xml->link[$j]->id . '<br>';
		 
		 // Imprime o valor o valor da tag <title></title>
		 echo $arquivo_xml->link[$j]->title . '<br>';
		 
		 // Imprime o valor o valor da description <description></description>
		 echo $arquivo_xml->link[$j]->description . '<br>';
		 
		 // Imprime o valor o valor da description <image></image>
		 echo $arquivo_xml->link[$j]->image . '<br>';
		 
		 // Apenas uma quebra de linha a mais
		 echo '<hr>';
		} */
		

	}
	
	public function checarcep(){
		echo"
		<script>
			$('#cep_1').blur(function(){

				$.ajax({
					url : '../scripts/script_buscar_cep.php',
					type : 'POST',
					data: 'cep=' + $('#cep_1').val(),
					dataType: 'json',
					success: function(data){
						if(data.sucesso == 1){
							$('#rua').val(data.rua);
							$('#bairro').val(data.bairro);
							$('#cidade').val(data.cidade);
								var estado = document.getElementById('estado');
								for (var i = 0; i < estado.options.length; i++)
								{
									if (estado.options[i].value == data.estado)
									{
										estado.options[i].selected = 'true';
										break;
									}
								}
							$('#numero').focus();
						}
					}
				});   
				return false;    
			})
		</script>
		";
	}
	
	public function imagemfile(){
		echo"
		<script>
			$('input[type=file]').on('change', function(){
				var file = document.getElementById('ajax_form');
				var formData = new FormData(file);
		 
				$.ajax({
				   url: 'scripts/script_imgfile.php',
				   type: 'POST',
				   data: formData,
				   dataType: 'json',
				   processData: false,  
				   contentType: false,
				   success: function(retorno){
						if (retorno.status == '0')
						{
							alert(retorno.mensagem);
						}
					}
				});
				
				var files = !!this.files ? this.files : [];
				if (!files.length || !window.FileReader) return;
				if (/^image/.test( files[0].type)){
					var reader = new FileReader();
					reader.readAsDataURL(files[0]);
		 
					reader.onload = function(){
						$('#imgperfil').attr('src', this.result);
					}
				}
		 
				return false;
			
			
			
			});
		</script>
		";
	}
	
	public function alterartipopessoa(){
		echo"
		<script>
			function Mudar_tipo_inicial(tipo_empresa_fornecedor)
			{
				if(tipo_empresa_fornecedor == 1)
				{
					Mudar_tipo_Fisico();
				}
				else
				{
					Mudar_tipo_Juridico();
				}
			}
			function Mudar_tipo_Fisico()
			{
				$('#cnpj_L').replaceWith(\"<label for='cpfcnpj' id='cpf_L'>Cpf</label>\");
					$('#cpfcnpj').mask('999.999.999-99');
				$('#ie_L').replaceWith(\"<label for='rgie' id='rg_L'>Rg</label>\");
					$('#rgie').mask('99.999.999-*');
				$('#razao_L').replaceWith(\"<label for='nome' id='nome_L'>Nome</label>\");
				$('#fantasia_L').replaceWith(\"<label for='sobrenome' id='sobrenome_L'>Sobrenome</label>\");
				$('#abertura_L').replaceWith(\"<label for='nascimento' id='nascimento_L'>Data de Nascimento</label>\");
			}
			function Mudar_tipo_Juridico()
			{
				$('#cpf_L').replaceWith(\"<label for='cpfcnpj' id='cnpj_L'>Cnpj</label>\");
					$('#cpfcnpj').mask('99.999.999/9999-99');
				$('#rg_L').replaceWith(\"<label for='rgie' id='ie_L'>Ie</label>\");
					$('#rgie').mask('999.999.999.999');
				$('#nome_L').replaceWith(\"<label for='ie' id='razao_L'>Razão Social</label>\");
				$('#sobrenome_L').replaceWith(\"<label for='ie' id='fantasia_L'>Nome Fanstasia</label>\");
				$('#nascimento_L').replaceWith(\"<label for='ie' id='abertura_L'>Data de Abertura</label>\");
			}
		</script>
		";
	}
	
	public function caractercheck($var){
	
		$var = preg_replace('/[^[:alnum:]!@#$%*-_]/', '',$var);
		
		return $var;
	}	
	
	public function exibir(){
		$this->fullscreen();
		//$this->autologoff();
		
		echo"
		<script>
			function exibir(pagina, dados)
			{
				
				var url = 'paginas/'+pagina+'.php?dados='+dados;
				$.get(url, function(dataReturn)
				{
					$('#load_pagina').html(dataReturn);
					if(pagina=='ajax_cliente-fornecedor'){var opcao3 = document.getElementById('opcao3').value; Mudar_tipo_inicial(opcao3);}
				});
			}
		</script>
		";
	}	

	public function exibir_delete(){		
		echo"
		<script>
			function exibir_delete(pagina, dados)
			{
				var url = 'scripts/script_'+pagina+'.php?dados='+dados;
				$.get(url, function(dataReturn)
				{
					var url = 'paginas/ajax_'+pagina+'.php';
					$.get(url, function(dataReturn)
					{
						$('#load_pagina').html(dataReturn);
						$('#msg').replaceWith(result);
						$('#msg').fadeIn('fast');
						$('#msg').fadeOut(5000);
					});
				});
			}
		</script>
		";
	}		
	
	public function script(){
		$this->fullscreen();
		echo"
		<script>
			function exibir(script, dados)
			{
				if(confirm('Voce deseja mesmo '+opcao+' este funcionario?'))
					{
						jQuery.ajax({
							url: 'scripts/script_'+script+'.php',
							type: 'POST',
							data: {
								ssd: 'yes',
								data: dados
							},
							dataType: 'json',
							success: function(result)
							{
								$('#load_pagina').html(dataReturn);
								$('#msg').replaceWith(result);
								$('#msg').fadeIn('fast');
								$('#msg').fadeOut(5000);
							}
						});
						return false;
					}
			}
		</script>
		";
	}	

	public function AtivarDesativar(){
		echo"
		<script>
			function AtivarDesativar(pagina, opcao, id)
			{
				if(pagina)
				{
					var url = 'paginas/ajax_ativa_desativa.php?pagina='+pagina+'&opcao='+opcao+'&id='+id;
					$.get(url, function(dataReturn) 	
					{
						$('#load_ativa_desativa').html(dataReturn);
					}); 
				}
			}
		</script>
		";
	}	

	public function fornecedor_funcoes(){
		echo"
		<script>
			function fornecedor_funcoes(pagina, opcao, dados)
			{
				dados = dados+'|'+ document.getElementById('fornecedor').value;

				var url = 'paginas/ajax_fornecedor_funcoes.php?pagina='+pagina+'&opcao='+opcao+'&dados='+dados;
				$.get(url, function(dataReturn) 	
				{
					$('#load_alterar_fornecedor').html(dataReturn);
				}); 
			}
		</script>
		";
	}	
	
	public function fornecedor_fueeeeencoes(){
		echo"
		<script>
			function fornecedor_funcoes(pagina, opcao, dados)
			{
				dados = dados+'|'+ document.getElementById('fornecedor').value;
				var url = 'scripts/script_'+pagina+'.php?opcao='+opcao+'&dados='+dados;
				$.get(url, function(dataReturn)
				{
					alert(dataReturn);
					var url = 'paginas/ajax_'+pagina+'.php?dados='+dados;
					alert(url);
					$.get(url, function(dataReturn)
					{
						alert('ok');
						$('#load_alterar_fornecedor').html(dataReturn);

					});
				});
			}
		</script>
		";
	}	
	
	public function adicionar_produto(){
		echo"
		<script>
			function Adicionar_produto(opcao)
			{
				opcao2 = document.getElementById('opcao2').value;
				
				if(document.getElementById('tipo_requisicao1').checked){requisicaotipo=1;}else if(document.getElementById('tipo_requisicao2').checked){requisicaotipo=2;} else{requisicaotipo=3;}
				idrequisicao = document.getElementById('id_requisicao').value ;
				idprodut = document.getElementById('id_produto').value ;
				dato = 'idrequisicao='+idrequisicao+'&idprodut='+idprodut+'&requisicaotipo='+requisicaotipo+'&opcao='+opcao;
				jQuery.ajax({
					url: 'scripts/script_'+opcao2+'.php',
					type: 'POST',
					data: {
						ssd: 'yes',
						data: dato
					},
					dataType: 'json',
					success: function(dato)
					{
						var url = 'paginas/ajax_'+opcao2+'.php?dados='+dato;
						$.get(url, function(dataReturn)
						{
							$('#load_adicionar_produto').html(dataReturn);
						});
					}
				});
				return false;
			}
		</script>
		";
	}	
	
	public function form(){
		//http://rafaelcouto.com.br/envio-de-formulario-sem-refresh-com-jquery-php/
		//http://www.diogomatheus.com.br/blog/php/serializacao-de-dados-no-php/
		$this->autologoff();
		echo"
		<script>
				$('#ajax_form').submit(function(){
					
					opcao = document.getElementById('opcao').value;
					opcao2 = document.getElementById('opcao2').value;
					if(confirm('Voce deseja mesmo '+opcao+' este funcionario?'))
					{
						dato = $(this).serialize();

						jQuery.ajax({
							url: 'scripts/script_'+opcao2+'.php',
							type: 'POST',
							data: {
								ssd: 'yes',
								data: dato
							},
							dataType: 'json',
							success: function(result)
							{
								$('#myModal1').modal('hide');
								
								if(opcao2=='emailsmtp'){var url = 'paginas/ajax_requisicoes.php';}
								else{var url = 'paginas/ajax_'+opcao2+'.php';}
								$.get(url, function(dataReturn)
								{
									$('#load_pagina').html(dataReturn);
									$('#msg').replaceWith(result);
									$('#msg').fadeIn('fast');
									$('#msg').fadeOut(5000);
								});
							}
						});
						return false;
					}
				});
		</script>
		";
	}
	
	public function formfile(){
		$this->autologoff();
		echo"
		<script>
			$('#ajax_form').submit(function() {
				var opcao2 = document.getElementById('opcao2').value;
				
				var formulario = document.getElementById('ajax_form');
				var formData = new FormData(formulario);
		
				$.ajax({
				url: 'scripts/script_'+opcao2+'.php',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,  
				contentType: false,
				success: function(result){
					if(opcao2=='emailsmtp'){var url = 'paginas/ajax_requisicoes.php';}
					else{var url = 'paginas/ajax_'+opcao2+'.php';}
					$.get(url, function(dataReturn)
					{
						
						$('#load_pagina').html(dataReturn);
						$('#msg').replaceWith(result);
						$('#msg').fadeIn('fast');
						$('#msg').fadeOut(5000);
						
					});
					}
				});
		
				return false;
			});
		</script>
		";
	}
	
	public function mascaras($mask, $n){
		for($i=1;$i<=$n;$i++){
			if($mask=="telefone"){echo"<script>$('#telefone_$i').mask('(99) 9999-9999');</script>";}
			else if($mask=="celular"){echo"<script>$('#celular_$i').mask('(99) 99999-9999');</script>";}
			else if($mask=="cep"){echo"<script>$('#cep_$i').mask('99.999.999');</script>";}
			else if($mask=="cpf"){echo"<script>$('#cpf_$i').mask('999.999.999-99');</script>";}
			else if($mask=="rg"){echo"<script>$('#rg_$i').mask('99.999.999-*');</script>";}
			else if($mask=="cnpj"){echo"<script>$('#cnpj_$i').mask('99.999.999/9999-99');</script>";}
		}
	}
	
	public function datatable(){
		echo"
		<script>
			$(document).ready(function() {
				$('#data-table').DataTable( {
					paging: true,
					lengthChange: true,
					iDisplayLength: 15,
					searching: true,
					ordering: true,
					info: true,
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'pdfHtml5',
							download: 'open',
							exportOptions: {
								columns: ':visible'
							},
						}, 
						{
							extend: 'excelHtml5',
							customize: function( xlsx ) {
								var sheet = xlsx.xl.worksheets['sheet1.xml'];
				 
								$('row c[r^=\"C\"]', sheet).attr( 's', '2' );
							}
						},
						{
							extend: 'colvis',
							text: 'Col Visiveis'
						}, 
						{
							text: 'Inserir',
							action: function ( e, dt, node, config ) {
								opcao = document.getElementById('opcao').value;
								exibir(opcao, 'inserir');
							}
						}
					],
					aaSorting: [[1, 'asc']],
					oLanguage:{
						sLengthMenu: 'Mostrar _MENU_ registros por página',
						sZeroRecords: 'Nenhum registro encontrado',
						sInfo: 'Mostrando _START_ / _END_ de _TOTAL_ registro(s)',
						sInfoEmpty: 'Mostrando 0 / 0 de 0 registros',
						sInfoFiltered: '(filtrado de _MAX_ registros)',
						sSearch: 'Pesquisar: ',
						oPaginate: {
							sFirst: 'Início',
							sPrevious: 'Anterior',
							sNext: 'Próximo',
							sLast: 'Último'
						}
					},
					autoWidth: false
				} );
				
				$('#data-table2').DataTable( {
					paging: false,
					lengthChange: false,
					iDisplayLength: 15,
					searching: false,
					ordering: true,
					info: true,
					aaSorting: [[1, 'asc']],
					oLanguage:{
						sLengthMenu: 'Mostrar _MENU_ registros por página',
						sZeroRecords: 'Nenhum registro encontrado',
						sInfo: 'Mostrando _START_ / _END_ de _TOTAL_ registro(s)',
						sInfoEmpty: 'Mostrando 0 / 0 de 0 registros',
						sInfoFiltered: '(filtrado de _MAX_ registros)',
						sSearch: 'Pesquisar: ',
						oPaginate: {
							sFirst: 'Início',
							sPrevious: 'Anterior',
							sNext: 'Próximo',
							sLast: 'Último'
						}
					},
					autoWidth: false
				} );
				
			} );
			$.extend($.fn.dataTable.defaults, { responsive: true } ); 
		</script>
		";
	}

	public function select(){
		echo"
		<script>
			 $(document).ready(function() { $('.select2').select2();});
		</script>
		";
	}
		
	public function fullscreen(){
		echo"
			<script>
				function Remote() {

				  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
				   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
					if (document.documentElement.requestFullScreen) {  
					  document.documentElement.requestFullScreen();  
					} else if (document.documentElement.mozRequestFullScreen) {  
					  document.documentElement.mozRequestFullScreen();  
					} else if (document.documentElement.webkitRequestFullScreen) {  
					  document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
					}  
				  } else {  
					if (document.cancelFullScreen) {  
					  document.cancelFullScreen();  
					} else if (document.mozCancelFullScreen) {  
					  document.mozCancelFullScreen();  
					} else if (document.webkitCancelFullScreen) {  
					  document.webkitCancelFullScreen();  
					}  
				  }  				
				}

			</script>
		";
	}	
	
	public function modal(){
		echo"
			<script>
				function modal(dados)
				{
					var url = 'paginas/ajax_modal.php?dados='+dados;
					$.get(url, function(dataReturn)
					{
						$('#load_modal').html(dataReturn);
					}); 
				}
			</script>
		";
	}
	
	public function datepicker(){
		echo"
		<script>
			$(function() {
				$('[data-toggle=\"datepicker\"]').datepicker({
				autoHide: true,
				buttonImageOnly: true,
				format: 'dd/mm/yyyy',
				language: 'pt-BR',
				zIndex: 2048,
			  });
			});
		</script>
		";
	}	
		
	public function autologoff(){
		echo"
			<script>
				var tempo = new Number();
				tempo = 900;
 
				function startCountdown()
				{
	 
					if((tempo - 1) >= 0)
					{
						var min = parseInt(tempo/60);
						var seg = tempo%60;
						if(min < 10)
						{
							min = \"0\"+min;
							min = min.substr(0, 2);
						}
						if(seg <=9)
						{
							seg = \"0\"+seg;
						}
						horaImprimivel = '00:' + min + ':' + seg;
						$(\"#sessao\").html(horaImprimivel);
						setTimeout('startCountdown()',1000);
						tempo--;
					} 
					else 
					{
						window.open('scripts/script_logout.php?opcao=logoff', '_self');
					}
		 
				}	
			</script>
		";
	}	
	
	public function plugins(){
	
			$login = $this->asession('login');
			$path = "";
		if($login == "ok")
		{
			//jqueryxD
			//echo"<script src='$path/plugins/jquery 3.2.1/jquery-3.2.1.min.js'></script>";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/703772ad/plugins/jquery%203.3.1/jquery-3.3.1.min.js'></script>";
			
			//BootstrapxD
			//echo"<link rel='stylesheet' href='$path/plugins/bootstrap 3.3.7/css/bootstrap.min.css'>";
			echo"<link rel='stylesheet' href='https://cdn.rawgit.com/snapsolution/SnapSolutions/490e8bb5/plugins/bootstrap-3.3.7/css/bootstrap.min.css'>";
			//echo"<script src='$path/plugins/bootstrap 3.3.7/js/bootstrap.min.js'></script>";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/490e8bb5/plugins/bootstrap-3.3.7/js/bootstrap.min.js'></script>";
			//echo"<script src='$path/plugins/outros/css/bootstrap.complemento.css'></script>";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/490e8bb5/plugins/outros/css/bootstrap.complemento.css'></script>";
			

			//PainelxD
			echo"<link rel='stylesheet' href='$path/plugins/dist/css/AdminLTE.min.css'>";
			echo"<link rel='stylesheet' href='$path/plugins/dist/css/skins/_all-skins.min.cs'>";
			echo"<link rel='stylesheet' href='$path/plugins/dist/css/skins/skin-blue.min.css'>";
			echo"<script src='$path/plugins/dist/js/app.min.js'></script>";
			echo"<script src='$path/plugins/dist/js/demo.js'></script>";

			//SelectxD
			echo"<link rel='stylesheet' href='$path/plugins/select2/select2.min.css'>";
			echo"<script src='$path/plugins/select2/select2.full.min.js'></script>";

			//Mascaras inputxD
			//echo"<script src='$path/plugins/mascaras/jquery.maskedinput.js'></script>";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/d0b03fc6/plugins/mascaras/jquery.maskedinput.js'></script>";

			//IconesxD
			echo"<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>";
			
			//FontexD
			echo"<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>";

			//GraficosxD
			//echo"<script src='$path/plugins/graficos/Chart.min.js'></script>";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/d0b03fc6/plugins/graficos/Chart.js'></script>";
		
			//datatable
			echo"<link rel='stylesheet' href='$path/plugins/datatables/jquery.dataTables.min.css'>";
			echo"<script src='$path/plugins/datatables/jquery.dataTables.min.js'></script>";
			echo"<script src='$path/plugins/datatables/dataTables.buttons.min.js'></script>";
			echo"<script src='$path/plugins/datatables/pdfmake.min.js'></script>";
			echo"<script src='$path/plugins/datatables/jszip.min.js'></script>";
			echo"<script src='$path/plugins/datatables/vfs_fonts.js'></script>";
			echo"<script src='$path/plugins/datatables/buttons.html5.min.js'></script>";
			echo"<script src='$path/plugins/datatables/buttons.colVis.min.js'></script>";

			//CalendarioxD
			echo"<link rel='stylesheet' href='$path/plugins/datepicker/datepicker.min.css'>";
			echo"<script src='$path/plugins/datepicker/datepicker.min.js'></script>";
			echo"<script src='$path/plugins/datepicker/bootstrap-datepicker.pt-BR.js'></script>";
			
			//Outros
			
			//<script type='text/javascript' src='cep.js'></script>
			echo"
			<link href='https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css' rel='stylesheet'>
			<script src='https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.min.js'></script>
			<link rel='stylesheet' href='$path/plugins/datatables/dataTables.bootstrap.css'>
			<link rel='stylesheet' href='$path/plugins/datatables/dataTables.responsive.css'>
			<script src='$path/plugins/datatables/dataTables.bootstrap.min.js'></script>
			<script src='$path/plugins/datatables/dataTables.responsive.js'></script>

			<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css'>

			";
		}
		
		else{
			echo"
			<link rel='stylesheet' href='$path/plugins/bootstrap/bootstrap.3.3.6.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
			<link rel='stylesheet' href='$path/plugins/dist/css/AdminLTE.min.css'>
			<link type='text/css' rel='stylesheet' href='$path/plugins/outros/signin.css' media='all'>
			";
			echo"<script src='https://cdn.rawgit.com/snapsolution/SnapSolutions/703772ad/plugins/jquery%203.3.1/jquery-3.3.1.min.js'></script>";
		}
	}
	
}

?>