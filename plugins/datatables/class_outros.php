<?php 
ob_start();
session_start();
class outros{
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
	
	public function msg($tipo){
	
		if($tipo == "e"){$tipo = "<center><div id='msg' class='alert alert-danger'>Senha incorreta ou Usuario não existe!!</div></center>";}
		
		else if($tipo == "ac"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>Informações alteradas!!</div></center>";}
		else{$tipo = "<center><div id='msg' class='alert alert-danger'>Erro desconhecido!!$tipo</div></center>";}
		return $tipo;
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
	
	public function calcularidade(){
		echo"
		<script>
			function calcularidade(nascimento) 
			{
				var nascimento = nascimento.split("/");
				var dataNascimento = new Date(parseInt(nascimento[2], 10), parseInt(nascimento[1], 10) - 1, parseInt(nascimento[0], 10));

				var diferenca = Date.now() - dataNascimento.getTime();
				var idade = new Date(diferenca);
				idade = Math.abs(idade.getUTCFullYear() - 1970);
				document.getElementById('idade').value = idade;
			}
		</script>
		";
	}
	
	public function caractercheck($var){
	
		$var = preg_replace('/[^[:alnum:]!@#$%*-_]/', '',$var);
		
		return $var;
	}	
	
	public function exibir(){
		echo"
		<script>
			function exibir(pagina, dados)
			{
				var url = 'paginas/'+pagina+'.php?dados='+dados;
				$.get(url, function(dataReturn)
				{
					$('#load_pagina').html(dataReturn);
				});
			}
		</script>
		";
	}	
	
	public function form(){
		//http://rafaelcouto.com.br/envio-de-formulario-sem-refresh-com-jquery-php/
		//http://www.diogomatheus.com.br/blog/php/serializacao-de-dados-no-php/
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
								var url = 'paginas/ajax_'+opcao2+'.php';
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
			} );
			$.extend($.fn.dataTable.defaults, { responsive: true } ); 
		</script>
		";
	}
	
	public function datepicker(){
		echo"
		<script>
			$('#datepicker').datepicker({
				format: 'dd/mm/yyyy',
				language: 'pt-BR',
				calendarWeeks: true,
				todayBtn: 'linked',
				autoclose: true,
				todayHighlight: true
			}); 
			$('#datepicker2').datepicker({
				format: 'dd/mm/yyyy',
				language: 'pt-BR',
				calendarWeeks: true,
				todayBtn: 'linked',
				autoclose: true,
				todayHighlight: true
			}); 
			$('#datepicker3').datepicker({
				format: 'dd/mm/yyyy',
				language: 'pt-BR',
				calendarWeeks: true,
				todayBtn: 'linked',
				autoclose: true,
				todayHighlight: true
			}); 
		</script>
		";
	}
	
	public function pluginss(){
	
			$login = $this->asession('login');
			
		if($login == "ok")
		{
			echo"
			<link rel='stylesheet' href='plugins/bootstrap/bootstrap.3.3.6.css'>
			<link rel='stylesheet' href='plugins/dist/css/AdminLTE.min.css'>
			<link rel='stylesheet' href='plugins/dist/css/skins/_all-skins.min.cs'>
			<script src='js/jquery-1.12.4.js'></script>
			<script src='js/bootstrap.min.js' ></script>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
			
			<link href='https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css' rel='stylesheet'>
			<script src='https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.min.js'></script>
			<script src='js/jquery.maskedinput.js'></script>	
			
			<link rel='stylesheet' href='plugins/datatables/dataTables.bootstrap.css'>
			<link rel='stylesheet' href='plugins/datatables/dataTables.responsive.css'>

			
			<script src='plugins/datatables/dataTables.bootstrap.min.js'></script>
			<script src='plugins/datatables/dataTables.responsive.js'></script>
			
			<script src='plugins/chartjs/Chart.min.js'></script>
			<link rel='stylesheet' href='plugins/datepicker/datepicker.css'>
			<script src='plugins/datepicker/bootstrap-datepicker.js'></script>
			<script src='plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js'></script>
			<link rel='stylesheet' href='plugins/select2/select2.min.css'>

			<script src='plugins/select2/select2.full.min.js'></script>
			<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
			<link rel='stylesheet' href='plugins/dist/css/skins/skin-blue.min.css'>
			<script src='plugins/dist/js/app.min.js'></script>
			<script src='plugins/dist/js/demo.js'></script>
			<!--<script type='text/javascript' src='cep.js'></script>-->
			<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css'>
			

			";
		}
		
		else{
			echo"
			<link rel='stylesheet' href='plugins/bootstrap/bootstrap.3.3.6.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
			<link rel='stylesheet' href='plugins/dist/css/AdminLTE.min.css'>
			<link type='text/css' rel='stylesheet' href='plugins/outros/signin.css' media='all'>
			
			<script src='js/jquery-1.12.3.min.js'></script>
			<script src='js/bootstrap.min.js' ></script>
			";
		}
	}
	
	public function plugins(){
	
			$login = $this->asession('login');
			
		if($login == "ok")
		{
//jqueryxD
			echo"<script src='../plugins/jquery 3.2.1/jquery-3.2.1.min.js'></script>";
			
//BootstrapxD
			echo"<link rel='stylesheet' href='../plugins/bootstrap 3.3.7/css/bootstrap.min.css'>";
			echo"<script src='../plugins/bootstrap 3.3.7/js/bootstrap.min.js'></script>";
			

//PainelxD
			echo"<link rel='stylesheet' href='../plugins/dist/css/AdminLTE.min.css'>";
			echo"<link rel='stylesheet' href='../plugins/dist/css/skins/_all-skins.min.cs'>";
			echo"<link rel='stylesheet' href='../plugins/dist/css/skins/skin-blue.min.css'>";
			echo"<script src='../plugins/dist/js/app.min.js'></script>";
			echo"<script src='../plugins/dist/js/demo.js'></script>";

//SelectxD
			echo"<link rel='stylesheet' href='../plugins/select2/select2.min.css'>";
			echo"<script src='../plugins/select2/select2.full.min.js'></script>";

//Mascaras inputxD
			echo"<script src='../plugins/mascaras/jquery.maskedinput.js'></script>";

//IconesxD
			echo"<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>";
			
//FontexD
			echo"<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>";

//GraficosxD
			echo"<script src='../plugins/graficos/Chart.min.js'></script>";
		
//datatable
			echo"<link rel='stylesheet' href='../plugins/datatables/jquery.dataTables.min.css'>";
			echo"<script src='../plugins/datatables/jquery.dataTables.min.js'></script>";
			echo"<script src='../plugins/datatables/dataTables.buttons.min.js'></script>";
			echo"<script src='../plugins/datatables/pdfmake.min.js'></script>";
			echo"<script src='../plugins/datatables/jszip.min.js'></script>";
			echo"<script src='../plugins/datatables/vfs_fonts.js'></script>";
			echo"<script src='../plugins/datatables/buttons.html5.min.js'></script>";
			echo"<script src='../plugins/datatables/buttons.colVis.min.js'></script>";

//CalendarioxD
			echo"<link rel='stylesheet' href='/plugins/datepicker/datepicker.css'>";
			echo"<script src='/plugins/datepicker/bootstrap-datepicker.js'></script>";
			echo"<script src='/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js'></script>";
			
//Outros
			
			//<script type='text/javascript' src='cep.js'></script>
			echo"
			<link href='https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css' rel='stylesheet'>
			<script src='https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.min.js'></script>
			<link rel='stylesheet' href='../plugins/datatables/dataTables.bootstrap.css'>
			<link rel='stylesheet' href='../plugins/datatables/dataTables.responsive.css'>
			<script src='../plugins/datatables/dataTables.bootstrap.min.js'></script>
			<script src='../plugins/datatables/dataTables.responsive.js'></script>

			<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css'>

			";
		}
		
		else{
			echo"
			<link rel='stylesheet' href='plugins/bootstrap/bootstrap.3.3.6.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
			<link rel='stylesheet' href='plugins/dist/css/AdminLTE.min.css'>
			<link type='text/css' rel='stylesheet' href='plugins/outros/signin.css' media='all'>
			
			<script src='js/jquery-1.12.3.min.js'></script>
			<script src='js/bootstrap.min.js' ></script>
			";
		}
	}
	
}

?>