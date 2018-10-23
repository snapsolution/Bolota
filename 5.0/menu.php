<header class="main-header">
	<a href="#" onclick="exibir('dashboard')" class="logo"><span class="logo-mini"><b>S</b>nap</span><span class="logo-lg"><b>Snap Solutions</b></span></a>
    <nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span></a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<?php 
				$id = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['id']);
				$dados[id_funcionario]= $id;
				$nome = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['nome']);
				
				
				$query = $config->conexaoBD("funcionario","","select",$dados);
				$obj = $query->fetch (PDO::FETCH_OBJ); 
					$nome_funcionario = $obj->NOME_FUNCIONARIO;
						if($nome_funcionario == ""){$nome_funcionario = $nome;}
					$data_cadastro_funcionario = $obj->DATACADASTRO_FUNCIONARIO;
					$imagem_funcionario = $obj->IMAGEM_FUNCIONARIO;
						if(($imagem_funcionario == "") || ($imagem_funcionario == null)){$imagem_funcionario = "anonimo.jpg";}
				echo"
				<li>
					<a href='#'";?> onclick="Remote()"<?php echo"><i class='glyphicon glyphicon-fullscreen' ></i></a>
				</li>
				<li class='dropdown user user-menu'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						<img src='img_usuario/$imagem_funcionario' class='user-image' alt='User Image'>
						<span class='hidden-xs'>$nome_funcionario</span>
					</a>
					<ul class='dropdown-menu'>
						<li class='user-header'>
							<img src='img_usuario/$imagem_funcionario' class='img-circle' alt='User Image'>

							<p>
								$nome_funcionario - Web Developer
								<small>Membro desde $data_cadastro_funcionario</small>
							</p>
						</li>
						<li class='user-footer'>
							<div class='pull-left'>
								<a href='#' class='btn btn-default btn-flat'>Perfil</a>
							</div>
							<div class='pull-right'>
								<a href='/scripts/script_logout.php' class='btn btn-default btn-flat'>Sair</a>
							</div>
						</li>
						
					</ul>
				</li>
				<li>
					<a href='#' data-toggle='control-sidebar'><i class='fa fa-gears'></i></a>
				</li>
				";?>
			</ul>
		</div>
    </nav>
</header>
