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
		
		$query = $config->conexaoBD("configuracoes","","select","");
		while ($obj = $query->fetch (PDO::FETCH_OBJ)) 
		{
			$filial_config = $obj->TITULO_SITE_CONFIGURACAO;
		}
		echo"<title>$filial_config</title>";
?>
	</head>
	

		<body class="hold-transition skin-blue sidebar-mini" onload="exibir('dashboard'); startCountdown();">
		<?php
			echo "sdsd".$query = $outros->checar_modulo()."ss";
			
		?>
		</body>
</html>
