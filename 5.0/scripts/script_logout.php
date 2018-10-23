<?php
	$opcao = $_REQUEST['opcao'];
	if($opcao == "logoff")
	{
		$dir=dirname(dirname(__DIR__), 1). '/5.0/classes';
		include("$dir/class_outros.php");  
		include("$dir/class_config.php");  
		$outros = new outros();
		$config = new config();
		$id_usuario = $outros->asession('id');
		$outros->session('login', 'ok2');
		$outros->session('id', $id_usuario);
		header("location:/5.0/index.php");
	}
	else
	{
		ob_start();
		session_start();
		session_unset();
	}

	header("location:/5.0/index.php");
?>