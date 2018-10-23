<?php
echo"
<aside class='main-sidebar'>
    <section class='sidebar'>
	";
		$id = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['id']);
		$dados[id_funcionario]= $id;
		$nome = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['nome']);
		
		$id_sessao = $outros->asession('id');
		
		$query = $config->conexaoBD("funcionario","","select",$dados);
		$obj = $query->fetch (PDO::FETCH_OBJ); 
			$nome_funcionario = $obj->NOME_FUNCIONARIO;
				if($nome_funcionario == ""){$nome_funcionario = $nome;}
			$data_cadastro_funcionario = $obj->DATACADASTRO_FUNCIONARIO;
			$imagem_funcionario= $obj->IMAGEM_FUNCIONARIO;
				if(($imagem_funcionario == "") || ($imagem_funcionario == null)){$imagem_funcionario = "anonimo.jpg";}
			
			$pessoas_permissao_funcionario = $obj->PESSOAS_PERMISSAO_FUNCIONARIO;
			$funcionarios_permissao_funcionario = $obj->FUNCIONARIOS_PERMISSAO_FUNCIONARIO;
			$vizualizar_funcionarios_permissao_funcionario = $obj->VIZUALIZAR_FUNCIONARIOS_PERMISSAO_FUNCIONARIO;
			$editar_funcionarios_permissao_funcionario = $obj->EDITAR_FUNCIONARIOS_PERMISSAO_FUNCIONARIO;
			$clientefornecedor_permissao_funcionario = $obj->CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO;
			$vizualizar_clientefornecedor_permissao_funcionario = $obj->VIZUALIZAR_CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO;
			$editar_clientefornecedor_permissao_funcionario = $obj->EDITAR_CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO;
			
			$estoque_permissao_funcionario = $obj->ESTOQUE_PERMISSAO_FUNCIONARIO;
			$locacoes_permissao_funcionario = $obj->LOCACOES_PERMISSAO_FUNCIONARIO;
			$requisicoes_permissao_funcionario = $obj->REQUISICOES_PERMISSAO_FUNCIONARIO;
			$produtos_permissao_funcionario = $obj->PRODUTOS_PERMISSAO_FUNCIONARIO;
			
			$relatorio_permissao_funcionario = $obj->RELATORIO_PERMISSAO_FUNCIONARIO;
			$mercadoriasmaislocadas_permissao_funcionario = $obj->MERCADORIASMAISLOCADAS_PERMISSAO_FUNCIONARIO;
			$rankingdeclientes_permissao_funcionario = $obj->RANKINGDECLIENTES_PERMISSAO_FUNCIONARIO;
			$locacoesrealizadas_permissao_funcionario = $obj->LOCACOESREALIZADAS_PERMISSAO_FUNCIONARIO;
			$financeiro_permissao_funcionario = $obj->FINANCEIRO_PERMISSAO_FUNCIONARIO;
			
			$suporte_permissao_funcionario = $obj->SUPORTE_PERMISSAO_FUNCIONARIO;
			$configuracao_permissao_funcionario = $obj->CONFIGURACAO_PERMISSAO_FUNCIONARIO;

			echo"
		<div class='user-panel'>
			<div class='pull-left image' height='50px'>
				<img src='img_usuario/$imagem_funcionario' class='img-circle' alt='User Image' >
			</div>
			<div class='pull-left info'>
				<p>$nome_funcionario</p>
				<a href='javascript:void(0);'><i class='fa fa-circle text-success'></i> Online</a>
			</div>
		</div>
		<ul class='sidebar-menu'>
			<li class='header'>Menu</li>
				";
			if($pessoas_permissao_funcionario=='on' || $id_sessao == 1)
			{
				echo"
				<li class='treeview'>
					<a href='javascript:void(0);' ";?>onclick="exibir('ajax_pdv', '')"<?php echo"><i class='glyphicon glyphicon-th'></i> <span>Pdv</span></a>
				</li>
				";
			}
			if($pessoas_permissao_funcionario=='on' || $id_sessao == 1)
			{
				echo"
				<li class='treeview'>
					<a href='#'><i class='fa fa-user'></i> <span>Pessoas</span> <i class='fa fa-angle-left pull-right'></i></a>
					<ul class='treeview-menu'>
					";
						if($funcionarios_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_funcionario', '')"<?php echo">Funcionarios</a></li>";}
						if($clientefornecedor_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_cliente-fornecedor', '')"<?php echo">Clientes / Fornecedores</a></li>";}
				echo"
					</ul>
				</li>
				";
			}
			if($estoque_permissao_funcionario=='on' || $id_sessao == 1)
			{
				echo"
				<li class='treeview'>
					<a href='#'><i class='fa fa-codepen'></i> <span>Estoque</span> <i class='fa fa-angle-left pull-right'></i></a>
					<ul class='treeview-menu'>
					";
						if($requisicoes_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_requisicao', '')"<?php echo">Requisições</a></li>";}
						if($produtos_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_produtos', '')"<?php echo">Produtos</a></li>";}
						if($produtos_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_epi-ferramentas', '')"<?php echo">EPI/Ferramentas</a></li>";}
				echo"
					</ul>
				</li>
					";
			}
			if($relatorio_permissao_funcionario=='on' || $id_sessao == 1)
			{
				echo"
				<li class='treeview'>
					<a href='#'><i class='fa fa-line-chart'></i> <span>Relatórios</span> <i class='fa fa-angle-left pull-right'></i></a>
					<ul class='treeview-menu'>
					";
						if($mercadoriasmaislocadas_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'>Mercadorias mais locadas</a></li>";}
						if($rankingdeclientes_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'>Ranking de clientes</a></li>";}
						if($locacoesrealizadas_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'>Locações Realizadas</a></li>";}
						if($financeiro_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'>Financeiro</a></li>";}
				echo"
					</ul>
				</li>
					";
			}
			if($suporte_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_suporte', '')"<?php echo"><i class='fa fa-bug'></i> <span>Suporte</span></a></li>";}
			if($configuracao_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_configuracoes', '')"<?php echo"><i class='fa fa-gear'></i> <span>Configurações</span></a></li>";}
			if($configuracao_permissao_funcionario=='on' || $id_sessao == 1)
			{
				echo"
				<li class='treeview'>
					<a href='#'><i class='fa fa-question-circle'></i> <span>Ajuda</span> <i class=' fa fa-angle-left pull-right'></i></a>
					<ul class='treeview-menu'>
					";
						if($configuracao_permissao_funcionario=='on' || $id_sessao == 1){echo"<li class='li_menu'><a class='' href='javascript:void(0);'";?>onclick="exibir('ajax_manuais', '')"<?php echo">Manuais</a></li>";}
				echo"
					</ul>
				</li>
					";
			}
		echo"
		</ul>
    </section>
</aside>
			";
?>





