<?php
	include("../../../../classes/class_outros.php");  
	include("../../../../classes/class_loadpage.php");  
	$outros = new outros();
	$loadpage = new loadpage();
	
	echo "sdsd".$query = $outros->checar_modulo()."ss";
	
	
	$pagina = $_GET['pagina'];
	$dados['opcao'] = $_GET['opcao'];
	$dados['id'] = $_GET['id'];
	
?>		

