<?php
	include("../../../classes/class_outros.php");  
	include("../../../classes/class_config.php");  
	$outros = new outros();
	$config = new config();
	
	$modulos = $outros->checar_modulo();
		$modulos = explode('|', $modulos);
		foreach ( $modulos as $seu_valor ) {
			echo $seu_valor . '<br>';
		}
?>		

