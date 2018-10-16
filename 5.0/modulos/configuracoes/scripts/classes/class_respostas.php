<?php 
ob_start();
session_start();
class respostas{
	public function epi_ferramentas($tipo, $dados){
	
		//editar
		if($tipo == "editar-incorreto"){$tipo = "<center><div id='msg' class='alert alert-danger'>O EPI ou a Ferramenta não foi alterada, ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo e encaminhado para a Snap Solutions estar analisando, tente novamente mais tarde.</div></center>";}
		else if($tipo == "editar-correto"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>O EPI ou a Ferramenta tiveram suas alterações!!</div></center>";}
		
		//inserir
		else if($tipo == "inserir-incorreto"){$tipo = "<center><div id='msg' class='alert alert-danger'>O EPI ou a Ferramenta não pode ser inserido, ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo e encaminhado para a Snap Solutions estar analisando, tente novamente mais tarde.</div></center>";}
		else if($tipo == "inserir-correto"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>O EPI ou a Ferramenta foram inseridas!!</div></center>";}
		
		//Desconhecido
		else{$tipo = "<center><div id='msg' class='alert alert-danger'>Erro desconhecido!!$tipo</div></center>";}
		return $tipo;
	}

	public function produtos($tipo, $dados){
	
		//editar
		if($tipo == "editar-incorreto"){$tipo = "<center><div id='msg' class='alert alert-danger'>O produto não foi alterado, ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo e encaminhado para a Snap Solutions estar analisando, tente novamente mais tarde.</div></center>";}
		else if($tipo == "editar-correto"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>O produto foi alterado!!</div></center>";}
		
		//inserir
		else if($tipo == "inserir-incorreto"){$tipo = "<center><div id='msg' class='alert alert-danger'>O produto não pode ser inserido, ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo e encaminhado para a Snap Solutions estar analisando, tente novamente mais tarde.</div></center>";}
		else if($tipo == "inserir-correto"){$tipo = "<center><div id='msg' class='alert alert-success' role='alert'><strong>Sucesso! </strong>O produto foi inserido!!</div></center>";}
		
		//Desconhecido
		else{$tipo = "<center><div id='msg' class='alert alert-danger'>Erro desconhecido!!$tipo</div></center>";}
		return $tipo;
	}
}
?>