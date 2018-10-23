<?php 
	include("classes/class_outros.php");  
	include("classes/class_config.php");  
	include("classes/class_loadpage.php");  
	$outros = new outros();
	$config = new config();
	$loadpage = new loadpage();
?>

<!DOCTYPE html>

<html lang="pt_BR">
	<head>
		<meta http-equiv="refresh" charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="icon" type="image/png" href="img/icone.ico" />
		
<?php
		$login = $outros->asession('login');
		$outros->plugins();
		$outros->autologoff();
		$outros->exibir();
		$outros->fullscreen();
		$outros->select();
		$loadpage->load_modulos();
		$loadpage->load_tabela();
		
		$obj = $config->conexaoBD("configuracoes","count","select","");
			$filial_config = $obj->FILIAL_CONFIGURACAO;

		echo"<title>$filial_config</title>";
?>
	</head>
<?php
if($login == "ok")
{
?>
	<body class="hold-transition skin-blue sidebar-mini" onload="exibir('dashboard'); startCountdown();">
		<div class="wrapper">
			<?php include('menu.php'); ?> 
			<?php include('menu-esquerdo.php'); ?> 
			
			<div class="content-wrapper">
				<section class="content" id="load_modulos"></section>
			</div>

			<?php include('rodape.php'); ?> 
			<?php include('menu-direito.php'); ?> 
		</div>
	</body>
<?php
}

else if($login == "ok2")
{
	$id = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['id']);
	$dados[id_funcionario]= $id;
	
	$query = $config->conexaoBD("funcionario","","select",$dados[id_funcionario]);
	$obj = $query->fetch (PDO::FETCH_OBJ);
		$usuario_funcionario = $obj->USUARIO_FUNCIONARIO;
		$imagem_funcionario = $obj->IMAGEM_FUNCIONARIO;
		if(($imagem_funcionario == "") || ($imagem_funcionario == null)){$imagem_funcionario = "anonimo.jpg";}
	echo"
	<body class='hold-transition lockscreen'>
		<div class='lockscreen-wrapper'>
			<div class='lockscreen-logo'>
				<a href='../../index2.html'><b>Snap</b>Cloud</a>
			</div>
			<div class='lockscreen-name'>$usuario_funcionario</div>
			<div class='lockscreen-item'>
				<div class='lockscreen-image'>
					<img src='img_usuario/$imagem_funcionario' alt='User Image'>
				</div>
				<form class='lockscreen-credentials' action='scripts/script_login.php' method='post'>
					<div class='input-group'>
						<input type='hidden' name='usuario' value='$usuario_funcionario'>
						<input type='password' class='form-control' placeholder='password' name='senha'>
						<div class='input-group-btn'>
							<button type='submit' class='btn'><i class='fa fa-arrow-right text-muted'></i></button>
						</div>
					</div>
				</form>
			</div>
			<div class='help-block text-center'>
				Entre com o seu password para retornar a sessão!
			</div>
			<div class='text-center'>
				<a href='scripts/script_logout.php'>ou faça login com outro usuario</a>
			</div>
			<div class='lockscreen-footer text-center'>
				Copyright &copy; 2018 <b><a href='http://www.snapsolutions.com.br' class='text-black'>Snap Solutions</a></b>.<br>
				Todos os direitos reservados.
			</div>
		</div>
	</body>
	";
}
else
{
?>
	<body class='hold-transition login-page'>
	
		<div >
			<div class='div-login'>
				<?php $outros->msg($_REQUEST['sl']);?>
			</div>		
			<div class='login-box'>
				<div class='login-logo'>
					<b>Snap</b>Cloud
				</div>
				<div class='login-box-body' id='load_esqueci'>
					<p class='login-box-msg'>Logue para iniciar a sua Sessão</p>
					<form action='scripts/script_login.php' method='post'>
						<div class='form-group has-feedback'>
							<input type='text' id='inputEmail' class='form-control' placeholder='Usuario' name='usuario' maxlength='40' required autofocus>
							<span class='glyphicon glyphicon-envelope form-control-feedback'></span>
						</div>
						<div class='form-group has-feedback'>
							<input type='password' id='inputPassword' class='form-control' placeholder='Password' name='senha' maxlength='40' required>
							<span class='glyphicon glyphicon-lock form-control-feedback'></span>
						</div>
						<div class='row'>
							<div class='col-xs-8'>
								<a href='#' onclick='EsqueciEmail('usuario')'>Eu esqueci meu usuario</a><br>
								<a href='#' onclick='EsqueciEmail('senha')' class='text-center'>Eu esqueci meu password</a>
							</div>
							<div class='col-xs-4'>
							<button type='submit' class='btn btn-primary btn-block btn-flat'>Logar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
<?php
}
?>
</html>
