<?php 
	$dir=dirname(dirname(__DIR__), 1). '/5.0';
	include("$dir/config.php"); 
	class config{		
		public function conexaoBD($string, $excecao, $type, $dados){
			$configs = new configs();
			$con1 = $configs->con1();
			$host = $con1['host'];
			$base_de_dados = $con1['base_de_dados'];
			$password = $con1['password'];
			$user = $con1['user'];
			
			$pdo = new PDO ( "mysql:host=$host;dbname=$base_de_dados;charset=utf8mb4", $user, $password, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_PERSISTENT => false
			) );
			if($type == "update"){$query = $this->update($pdo, $string, $dados);}
			else if($type == "select"){$query = $this->select($pdo, $string, $dados);}
			else if($type == "delete"){$query = $this->delete($pdo, $string, $dados);}
			else if($type == "insert"){$query = $this->insert($pdo, $string, $dados);}
			
			$query->execute();
			
			if($excecao == "count")
			{
				$query = $query->fetch(PDO::FETCH_OBJ);
			}
		
			$pdo = null;

			return($query);
		}
		
		public function conexaoMZ($string, $excecao, $type, $dados){

			$configs = new configs();
			$con2 = $configs->con2();
			$host = $con2['host'];
			$base_de_dados = $con2['base_de_dados'];
			$password = $con2['password'];
			$user = $con2['user'];
			
			$pdo = new PDO ( "mysql:host=$host;dbname=$base_de_dados;charset=utf8mb4", $user, $password, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_PERSISTENT => false
			) );
			
			if($type == "update"){$query = $this->update($pdo, $string, $dados);}
			else if($type == "select"){$query = $this->select($pdo, $string, $dados);}
			else if($type == "insert"){$query = $this->insert($pdo, $string, $dados);}
			$query->execute();
			if($excecao == "count")
			{
				$query = $query->fetch(PDO::FETCH_OBJ);
			}
			$pdo = null;
			
			return($query);
		}
		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		public function select($pdo, $string, $dados){

			//////////////////////
			//Requisições_header//
			//////////////////////
			//dashboard
			if($string == "locacaoativa")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 3 OR STATUS_REQUISICAO = 4;");
			}
			//dashboard
			else if($string == "numerolocacoesexito")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE TIPO_REQUISICAO = 1;");
			}			
			
			//ajax_requisições
			else if($string == "requisicoes")
			{
				if($dados!=""){$dados="WHERE ID_REQUISICAO = $dados";}
				$query = $pdo->prepare("SELECT * FROM requisicoes_header $dados;");
			}
			
			//ajax_requisições, ajax_cliente/fornecedores
			else if($string == "requisicoesbody")
			{
				if($dados!=""){$dados="WHERE ID_REQUISICAO_HEADER = $dados";}
				$query = $pdo->prepare("SELECT * FROM requisicoes_body $dados;");
			}
			
			//ajax_cliente/fornecedores
			else if($string == "consultarequisicoes")
			{
				if($dados!=""){$dados="WHERE ID_FORNECEDOR = $dados";}
				$query = $pdo->prepare("SELECT * FROM requisicoes_header $dados;");
			}

			//ajax_requisições
			else if($string == "requisicoesstatus2")
			{
				if($dados=="status2"){$dados="WHERE STATUS_REQUISICAO = '2'";}
				$query = $pdo->prepare("SELECT * FROM requisicoes_body $dados;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 0;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes1")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 1;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes2")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 2;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes3")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 3;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes4")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 4;");
			}
			
			//dashboard
			else if($string == "numerorequisicoes5")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM requisicoes_header WHERE STATUS_REQUISICAO = 5;");
			}

			//////////////////////
			//Cliente_fornecedor//
			//////////////////////
			else if($string == "cliente-fornecedor")
			{
				//ajax_requisições
				if($dados != ""){$dados = "WHERE ID_CLIENTE = $dados";}

				//ajax_cliente-fornecedor, ajax_requisições,ajax_pdv_somenteativos
				$query = $pdo->prepare("SELECT * FROM cliente_fornecedor $dados;");
			}
			
			else if($string == "cliente_fornecedor_somenteativos")
			{
				//ajax_pdv_somenteativos
				$query = $pdo->prepare("SELECT * FROM cliente_fornecedor WHERE ATIVO_CLIENTE_FORNECEDOR = :ativo;");
				
				$query->bindValue(":ativo",1);
			}
			
			//dashboard
			else if($string == "numerocliente")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM cliente_fornecedor WHERE OCUPACAO_CLIENTE_FORNECEDOR = 1;");
			}
			
			else if($string == "numerofornecedor")
			{
				//dashboard
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM cliente_fornecedor WHERE OCUPACAO_CLIENTE_FORNECEDOR = 2;");
			}
			
			else if($string == "proximosaniver")
			{
				//dashboard
				$query = $pdo->prepare("SELECT * FROM cliente_fornecedor WHERE (MONTH(DATA_ABERTURA_CLIENTE) * 100 +  DAY(DATA_ABERTURA_CLIENTE)) >= (MONTH(NOW()) * 100 + DAY(NOW())) ORDER BY MONTH(DATA_ABERTURA_CLIENTE), DAY(DATA_ABERTURA_CLIENTE) LIMIT 6;");
			}
			
			else if($string == "proximosanivercount")
			{
				//dashboard
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM cliente_fornecedor WHERE (MONTH(DATA_ABERTURA_CLIENTE) * 100 +  DAY(DATA_ABERTURA_CLIENTE)) >= (MONTH(NOW()) * 100 + DAY(NOW())) ORDER BY MONTH(DATA_ABERTURA_CLIENTE), DAY(DATA_ABERTURA_CLIENTE) LIMIT 6;");
			}
			
			//////////////////////
			//////Funcionario/////
			//////////////////////
			else if($string == "funcionarios")
			{
				$query = $pdo->prepare("SELECT * FROM funcionario;");
			}

			//Menu
			else if($string == "funcionario")
			{
				$query = $pdo->prepare("SELECT * FROM funcionario WHERE ID_FUNCIONARIO = :id_func;");
				$query->bindValue(":id_func",$dados[id_funcionario]);
			}

			//dashboard
			else if($string == "numerofuncionario")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM funcionario;");
			}

			//ajax_funcionario
			else if($string == "historico_funcionario")
			{
				$query = $pdo->prepare("SELECT * FROM historico WHERE ID_FUNCIONARIO_HISTORICO = :id_func ORDER BY DATAHORA_HISTORICO DESC");
				$query->bindValue(":id_func",$dados);
			}
			
			//////////////////////
			//Produto_fornecedor//
			//////////////////////
			//ajax_produtos
			else if($string == "produto_fornecedor")
			{
				if($dados != "")
				{
					$dados = explode('|', $dados); 
					$tipo = $dados[0];
					$dados['id_produto'] = $dados[1];
					
					if($tipo == "sel-fornecedor")
					{
						$dados['id_fornecedor'] = $dados[2]; 
						$dados = "WHERE ID_PRODUTO = $dados[id_produto] AND ID_FORNECEDOR = $dados[id_fornecedor];";
					}
					else if($tipo == "vis-fornecedor")
					{
						$dados['id_usuario_session'] = $dados[2]; 
						$dados = "WHERE ID_PRODUTO = $dados[id_produto] AND (OK_PRODUTO_FORNECEDOR = 1 OR FUNCIONARIO_PRODUTO_FORNECEDOR = $dados[id_usuario_session]);";
					}
					else{}
				}
				$query = $pdo->prepare("SELECT * FROM produto_fornecedor $dados");
			}
			
			//////////////////////
			////////Estoque///////
			//////////////////////
			//dashboard, ajax_produtos
			else if($string == "produtos")
			{
				if($dados != ""){$dados = "WHERE ID_PRODUTO = $dados";}
				$query = $pdo->prepare("SELECT * FROM produtos $dados;");
			}
			
			//epi_ferramentas
			else if($string == "epi_ferramentas")
			{
				if($dados != ""){$dados = "WHERE ID_EPI_FERRAMENTAS = $dados";}
				$query = $pdo->prepare("SELECT * FROM epi_ferramentas $dados;");
			}
			
			//dashboard
			else if($string == "numeroestoque")
			{
				$query = $pdo->prepare("SELECT SUM(SALDO_ESTOQUE_PRODUTO) + SUM(SALDO_TRANSITO_PRODUTO) AS TOTAL FROM produtos;");
			}
			
			//dashboard
			else if($string == "produtossaldotransito")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM produtos WHERE SALDO_TRANSITO_PRODUTO > 0;");
			}
			
			//dashboard
			else if($string == "produtossaldoestoque")
			{
				$query = $pdo->prepare("SELECT count(*) AS TOTAL FROM produtos WHERE SALDO_ESTOQUE_PRODUTO = 0;");
			}
			
			//////////////////////
			////////Suporte////////
			//////////////////////

			else if($string == "ticketcabecalho")
			{
				//ajax_suporte
				$query = $pdo->prepare("SELECT * FROM tickets_cabecalho WHERE FILIAL_TICKET_CABECALHO = :filial;");
				$query->bindValue(":filial",$dados);
			}	

			else if($string == "ticketcabecalhoid")
			{
				//ajax_suporte
				$query = $pdo->prepare("SELECT * FROM tickets_cabecalho WHERE ID_TICKETS = :ticket_id;");
				$query->bindValue(":ticket_id",$dados['ticket_id']);
			}	

			else if($string == "ticketcorpo")
			{
				//ajax_suporte
				$query = $pdo->prepare("SELECT * FROM tickets_corpo WHERE ID_TICKET_CABECALHO = :ticket_id;");
				$query->bindValue(":ticket_id",$dados['ticket_id']);
			}	
			
			else if($string == "updatesistema")
			{
				//ajax_suporte
				$query = $pdo->prepare("SELECT * FROM update_sistema;");
			}
			//////////////////////
			////////Outros////////
			//////////////////////
			//dashboard
			else if($string == "numeropessoas")
			{
				$query = $pdo->prepare("SELECT count(*) + (select count(*) from funcionario) AS TOTAL FROM cliente_fornecedor;");
			}

			//configurações, dashboard, ajax_suporte,admin
			else if($string == "configuracoes")
			{
				
				$query = $pdo->prepare("SELECT * FROM configuracoes;");
			}
			
			else if($string == "login")
			{
				$dados[usuario];
				$query = $pdo->prepare("SELECT * FROM funcionario WHERE USUARIO_FUNCIONARIO = '$dados[usuario]' AND SENHA_USUARIO_FUNCIONARIO = '$dados[senha]';");
			}			

			//////////////////////
			////////manuais////////
			//////////////////////
			//dashboard
			
			else if($string == "manuais")
			{
				//ajax_manuais
				if($dados != ""){$dados = "WHERE ID_MANUAL = $dados";}
				$query = $pdo->prepare("SELECT * FROM manuais $dados;");
			}

			return($query);
		}

		public function update($pdo, $string, $dados){
			if($string == "teste")
			{
				$query = $this->conexaoBD("UPDATE funcionario SET NOME_FUNCIONARIO = '$dados' WHERE ID_FUNCIONARIO = 2;");
			}
			else if($string == "alterar_admin")
			{
				$query = $pdo->prepare("UPDATE configuracoes SET 
						TITULO_SITE_CONFIGURACAO = :TITULO_SITE_CONFIGURACAO, 
						FILIAL_CONFIGURACAO = :FILIAL_CONFIGURACAO WHERE ID_CONFIGURACOES = 1;");
				$query->bindValue(":TITULO_SITE_CONFIGURACAO",$dados[1]);
				$query->bindValue(":FILIAL_CONFIGURACAO",$dados[0]);
			}
			
			else if($string == "editar_funcionario")
			{
				$nome = $_FILES[ 'img_func' ][ 'name' ];
				$extensao = pathinfo ( $_FILES[ 'img_func' ][ 'name' ], PATHINFO_EXTENSION );
				$extensao = strtolower ( $extensao );

				$query = $pdo->prepare("UPDATE funcionario SET 
					NOME_FUNCIONARIO = :nome_func, 
					SOBRENOME_FUNCIONARIO = :sobrenome_func, 
					RG_FUNCIONARIO = :rg_func, 
					CPF_FUNCIONARIO = :cpf_func, 
					TELEFONE1_FUNCIONARIO = :telefone1_func, 
					TELEFONE2_FUNCIONARIO = :telefone2_func, 
					CELULAR1_FUNCIONARIO = :celular1_func, 
					CELULAR2_FUNCIONARIO = :celular2_func, 
					DATANASCIMENTO_FUNCIONARIO = :nascimento_func, 
					EMAIL_FUNCIONARIO = :email_func, 
					RUA_FUNCIONARIO = :rua_func, 
					NUM_FUNCIONARIO = :num_func, 
					BAIRRO_FUNCIONARIO = :bairro_func, 
					COMPLEMENTO_FUNCIONARIO = :complemento_func, 
					CIDADE_FUNCIONARIO = :cidade_func, 
					ESTADO_FUNCIONARIO = :estado_func, 
					PAIS_FUNCIONARIO = :pais_func, 
					CEP_FUNCIONARIO = :cep_func, 
					USUARIO_FUNCIONARIO = :usuario_func, 
					ATIVO_FUNCIONARIO = :ativo_func,
					IMAGEM_FUNCIONARIO = :img_func,

					PESSOAS_PERMISSAO_FUNCIONARIO = :pessoas_permissao_funcionario,
					FUNCIONARIOS_PERMISSAO_FUNCIONARIO = :funcionarios_permissao_funcionario,
					VIZUALIZAR_FUNCIONARIOS_PERMISSAO_FUNCIONARIO = :vizualizar_funcionarios_permissao_funcionario,
					EDITAR_FUNCIONARIOS_PERMISSAO_FUNCIONARIO = :editar_funcionarios_permissao_funcionario,
					CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO = :clientefornecedor_permissao_funcionario,
					VIZUALIZAR_CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO = :vizualizar_clientefornecedor_permissao_funcionario,
					EDITAR_CLIENTEFORNECEDOR_PERMISSAO_FUNCIONARIO = :editar_clientefornecedor_permissao_funcionario,

					ESTOQUE_PERMISSAO_FUNCIONARIO = :estoque_permissao_funcionario,
					LOCACOES_PERMISSAO_FUNCIONARIO = :locacoes_permissao_funcionario,
					REQUISICOES_PERMISSAO_FUNCIONARIO = :requisicoes_permissao_funcionario,
					VIZUALIZAR_REQUISICOES_PERMISSAO_FUNCIONARIO = :vizualizar_requisicoes_permissao_funcionario,
					EDITAR_REQUISICOES_PERMISSAO_FUNCIONARIO = :editar_requisicoes_permissao_funcionario,
					PRODUTOS_PERMISSAO_FUNCIONARIO = :produtos_permissao_funcionario,
					VIZUALIZAR_PRODUTOS_PERMISSAO_FUNCIONARIO = :vizualizar_produtos_permissao_funcionario,
					EDITAR_PRODUTOS_PERMISSAO_FUNCIONARIO = :editar_produtos_permissao_funcionario,

					RELATORIO_PERMISSAO_FUNCIONARIO = :relatorio_permissao_funcionario,
					MERCADORIASMAISLOCADAS_PERMISSAO_FUNCIONARIO = :mercadoriasmaislocadas_permissao_funcionario,
					RANKINGDECLIENTES_PERMISSAO_FUNCIONARIO = :rankingdeclientes_permissao_funcionario,
					LOCACOESREALIZADAS_PERMISSAO_FUNCIONARIO = :locacoesrealizadas_permissao_funcionario,
					FINANCEIRO_PERMISSAO_FUNCIONARIO = :financeiro_permissao_funcionario,
					SUPORTE_PERMISSAO_FUNCIONARIO = :suporte_permissao_funcionario,
					CONFIGURACAO_PERMISSAO_FUNCIONARIO = :configuracao_permissao_funcionario WHERE ID_FUNCIONARIO = :id_func;");
				
			
				$query->bindValue(":id_func",$dados['cod_func']);
				$query->bindValue(":nome_func",$dados['nome_func']);
				$query->bindValue(":sobrenome_func",$dados['sobrenome_func']);
				$query->bindValue(":rg_func",$dados['rg_func']);
				$query->bindValue(":cpf_func",$dados['cpf_func']);
				$query->bindValue(":telefone1_func",$dados['telefone1_func']);
				$query->bindValue(":telefone2_func",$dados['telefone2_func']);
				$query->bindValue(":celular1_func",$dados['celular1_func']);
				$query->bindValue(":celular2_func",$dados['celular2_func']);
				$query->bindValue(":nascimento_func",$dados['nascimento_func']);
				$query->bindValue(":email_func",$dados['email_func']);
				$query->bindValue(":cep_func",$dados['cep_func']);
				$query->bindValue(":rua_func",$dados['rua_func']);
				$query->bindValue(":num_func",$dados['num_func']);
				$query->bindValue(":bairro_func",$dados['complemento_func']);
				$query->bindValue(":complemento_func",$dados['bairro_func']);
				$query->bindValue(":cidade_func",$dados['cidade_func']);
				$query->bindValue(":estado_func",$dados['estado_func']);
				$query->bindValue(":pais_func",$dados['pais_func']);
				$query->bindValue(":usuario_func",$dados['usuario_func']);
				
				$query->bindValue(":ativo_func",$dados['ativo_func']);
				$query->bindValue(":img_func",$dados['cod_func'].'.'.$extensao);

				$query->bindValue(":pessoas_permissao_funcionario",$dados['pessoas_permissao_funcionario']);
				$query->bindValue(":funcionarios_permissao_funcionario",$dados['funcionarios_permissao_funcionario']);
				$query->bindValue(":vizualizar_funcionarios_permissao_funcionario",$dados['vizualizar_funcionarios_permissao_funcionario']);
				$query->bindValue(":editar_funcionarios_permissao_funcionario",$dados['editar_funcionarios_permissao_funcionario']);
				$query->bindValue(":clientefornecedor_permissao_funcionario",$dados['clientefornecedor_permissao_funcionario']);
				$query->bindValue(":vizualizar_clientefornecedor_permissao_funcionario",$dados['vizualizar_clientefornecedor_permissao_funcionario']);
				$query->bindValue(":editar_clientefornecedor_permissao_funcionario",$dados['editar_clientefornecedor_permissao_funcionario']);
				
				$query->bindValue(":estoque_permissao_funcionario",$dados['estoque_permissao_funcionario']);
				$query->bindValue(":locacoes_permissao_funcionario",$dados['locacoes_permissao_funcionario']);
				$query->bindValue(":requisicoes_permissao_funcionario",$dados['requisicoes_permissao_funcionario']);
				$query->bindValue(":vizualizar_requisicoes_permissao_funcionario",$dados['vizualizar_requisicoes_permissao_funcionario']);
				$query->bindValue(":editar_requisicoes_permissao_funcionario",$dados['editar_requisicoes_permissao_funcionario']);
				$query->bindValue(":produtos_permissao_funcionario",$dados['produtos_permissao_funcionario']);
				$query->bindValue(":vizualizar_produtos_permissao_funcionario",$dados['vizualizar_produtos_permissao_funcionario']);
				$query->bindValue(":editar_produtos_permissao_funcionario",$dados['editar_produtos_permissao_funcionario']);
				
				$query->bindValue(":relatorio_permissao_funcionario",$dados['relatorio_permissao_funcionario']);
				$query->bindValue(":mercadoriasmaislocadas_permissao_funcionario",$dados['mercadoriasmaislocadas_permissao_funcionario']);
				$query->bindValue(":rankingdeclientes_permissao_funcionario",$dados['rankingdeclientes_permissao_funcionario']);
				$query->bindValue(":locacoesrealizadas_permissao_funcionario",$dados['locacoesrealizadas_permissao_funcionario']);
				$query->bindValue(":financeiro_permissao_funcionario",$dados['financeiro_permissao_funcionario']);
				
				$query->bindValue(":suporte_permissao_funcionario",$dados['suporte_permissao_funcionario']);
				$query->bindValue(":configuracao_permissao_funcionario",$dados['configuracao_permissao_funcionario']);
			
			}

			//////////////////////
			////////ADMIN/////////
			//////////////////////

			else if($string == "atualizar_modulo")
			{
				

				$query = $pdo->prepare("UPDATE configuracoes SET  
					MODULO_BANCO = :modulo_banco WHERE ID_CONFIGURACOES = :id_config;");

				$query->bindValue(":id_config",1);
				$query->bindValue(":modulo_banco",$dados['modulo_pasta']);
			}
	
			//////////////////////
			///////Estoque////////
			//////////////////////

			else if($string == "editar_produtos")
			{

				$query = $pdo->prepare("UPDATE produtos SET 
					CODIGO_BARRAS_PRODUTO = :codigo_barras_produto, 
					CODIGO_BARRAS_FORNECEDOR_PRODUTO = :codigo_barras_fornecedor_produto, 
					COR_PRODUTO = :cor_produto, 
					DESCRICAO_PRODUTO = :descricao_produto, 
					TIPO_CONTAGEM_PRODUTO = :volume_produto, 
					GRUPO_PRODUTO = :grupo_produto, 
					PESO_PRODUTO = :peso_produto, 
					ALTURA_PRODUTO = :altura_produto, 
					LARGURA_PRODUTO = :largura_produto, 
					PROFUNDIDADE_PRODUTO = :profundidade_produto, 
					OBS_PRODUTO = :obs_produto, 
					ATIVO_PRODUTO = :ativo_produto WHERE ID_PRODUTO = :id_produto;");

				$query->bindValue(":id_produto",$dados['id_produto']);	
				$query->bindValue(":codigo_barras_produto",$dados['codigo_barras_produto']);	
				$query->bindValue(":codigo_barras_fornecedor_produto",$dados['codigo_barras_fornecedor_produto']);
				$query->bindValue(":cor_produto",$dados['cor_produto']);
				$query->bindValue(":descricao_produto",$dados['descricao_produto']);
				$query->bindValue(":volume_produto",$dados['volume_produto']);
				$query->bindValue(":grupo_produto",$dados['grupo_produto']);
				$query->bindValue(":peso_produto",$dados['peso_produto']);
				$query->bindValue(":altura_produto",$dados['altura_produto']);
				$query->bindValue(":largura_produto",$dados['largura_produto']);
				$query->bindValue(":profundidade_produto",$dados['profundidade_produto']);
				$query->bindValue(":obs_produto",$dados['obs_produto']);
				$query->bindValue(":ativo_produto",$dados['ativo_produto']);			
			}

			else if($string == "editar_epi_ferramentas")
			{

				$query = $pdo->prepare("UPDATE epi_ferramentas SET 
					CODIGO_BARRAS_EPI_FERRAMENTAS = :cod_barras_epi_ferramentas, 
					CODIGO_BARRAS_FORNECEDOR_EPI_FERRAMENTAS = :cod_barras_fornecedor_epi_ferramentas, 
					FINALIDADE_EPI_FERRAMENTAS = :finalidade_epi_ferramentas, 
					DESCRICAO_EPI_FERRAMENTAS = :descricao_epi_ferramentas, 
					TIPO_CONTAGEM_EPI_FERRAMENTAS = :volume_epi_ferramentas, 
					GRUPO_EPI_FERRAMENTAS = :grupo_epi_ferramentas, 
					PESO_EPI_FERRAMENTAS = :peso_epi_ferramentas, 
					ALTURA_EPI_FERRAMENTAS = :altura_epi_ferramentas, 
					LARGURA_EPI_FERRAMENTAS = :largura_epi_ferramentas, 
					PROFUNDIDADE_EPI_FERRAMENTAS = :profundidade_epi_ferramentas, 
					OBS_EPI_FERRAMENTAS = :obs_epi_ferramentas, 
					ATIVO_EPI_FERRAMENTAS = :ativo_epi_ferramentas WHERE ID_EPI_FERRAMENTAS = :id_epi_ferramentas;");

				$query->bindValue(":id_epi_ferramentas",$dados['id_epi-ferramentas']);	
				$query->bindValue(":cod_barras_epi_ferramentas",$dados['cod_barras_epi-ferramentas']);	
				$query->bindValue(":cod_barras_fornecedor_epi_ferramentas",$dados['cod_barras_fornecedor_epi-ferramentas']);
				$query->bindValue(":finalidade_epi_ferramentas",$dados['finalidade_epi-ferramentas']);
				$query->bindValue(":descricao_epi_ferramentas",$dados['descricao_epi-ferramentas']);
				$query->bindValue(":volume_epi_ferramentas",$dados['volume_epi-ferramentas']);
				$query->bindValue(":grupo_epi_ferramentas",$dados['grupo_epi-ferramentas']);
				$query->bindValue(":peso_epi_ferramentas",$dados['peso_epi-ferramentas']);
				$query->bindValue(":altura_epi_ferramentas",$dados['altura_epi-ferramentas']);
				$query->bindValue(":largura_epi_ferramentas",$dados['largura_epi-ferramentas']);
				$query->bindValue(":profundidade_epi_ferramentas",$dados['profundidade_epi-ferramentas']);
				$query->bindValue(":obs_epi_ferramentas",$dados['obs_epi-ferramentas']);
				$query->bindValue(":ativo_epi_ferramentas",$dados['ativo_epi-ferramentas']);			
			}

			else if($string == "editar_senha_funcionario")
			{
				$query = $pdo->prepare("UPDATE funcionario SET 
					SENHA_USUARIO_FUNCIONARIO = :senha_func WHERE ID_FUNCIONARIO = :id_func;");
				
				$query->bindValue(":id_func",$dados['cod_func']);
				$query->bindValue(":senha_func",$dados['senha_func']);
			}
			
			else if($string == "editar_cliente-fornecedor")
			{
				$query = $pdo->prepare("UPDATE cliente_fornecedor SET 
					RAZAO_SOCIAL_CLIENTE = :razaosocial_cliente_fornecedor, 
					NOME_FANTASIA_CLIENTE = :nomefantasia_cliente_fornecedor, 
					TIPO_EMPRESA_CLIENTE = :tipoempresa_cliente_fornecedor, 
					OCUPACAO_CLIENTE_FORNECEDOR = :ocupacao_cliente_fornecedor, 
					DATA_ABERTURA_CLIENTE = :dataabertura_cliente_fornecedor, 
					CNPJ_CPF_CLIENTE = :cnpjcpf_cliente_fornecedor, 
					INSCRICAO_ESTADUAL_CLIENTE = :inscricao_cliente_fornecedor, 
					EMAIL_CLIENTE = :email_cliente_fornecedor, 
					TELEFONE1_CLIENTE = :telefone1_cliente_fornecedor, 
					TELEFONE2_CLIENTE = :telefone2_cliente_fornecedor, 
					CELULAR1_CLIENTE = :celular1_cliente_fornecedor,
					CELULAR2_CLIENTE = :celular2_cliente_fornecedor, 
					RUA_CLIENTE = :rua_cliente_fornecedor, 
					NUM_CLIENTE = :num_cliente_fornecedor, 
					BAIRRO_CLIENTE = :bairro_cliente_fornecedor, 
					COMPLEMENTO_CLIENTE = :complemento_cliente_fornecedor, 
					CIDADE_CLIENTE = :cidade_cliente_fornecedor, 
					ESTADO_CLIENTE = :estado_cliente_fornecedor, 
					PAIS_CLIENTE = :pais_cliente_fornecedor,
					CEP_CLIENTE = :cep_cliente_fornecedor WHERE ID_CLIENTE = :id_cliente;");
					//ATIVO_CLIENTE_FORNECEDOR = :ativo_cliente_fornecedor
					
					
				$query->bindValue(":id_cliente",$dados['id_cliente']);
				$query->bindValue(":razaosocial_cliente_fornecedor",$dados['razao_cliente']);
				$query->bindValue(":nomefantasia_cliente_fornecedor",$dados['fantasia_cliente']);
				$query->bindValue(":tipoempresa_cliente_fornecedor",$dados['tipo_empresa_cliente']);
				$query->bindValue(":ocupacao_cliente_fornecedor",$dados['ocupacao_cliente_fornecedor']);
				$query->bindValue(":dataabertura_cliente_fornecedor",$dados['data_abertura_cliente']);
				$query->bindValue(":cnpjcpf_cliente_fornecedor",$dados['cnpj_cpf_cliente']);
				$query->bindValue(":inscricao_cliente_fornecedor",$dados['ie_cliente']);
				$query->bindValue(":email_cliente_fornecedor",$dados['email_cliente']);
				$query->bindValue(":telefone1_cliente_fornecedor",$dados['telefone1_cliente']);
				$query->bindValue(":telefone2_cliente_fornecedor",$dados['telefone2_cliente']);
				$query->bindValue(":celular1_cliente_fornecedor",$dados['celular1_cliente']);
				$query->bindValue(":celular2_cliente_fornecedor",$dados['celular2_cliente']);
				$query->bindValue(":rua_cliente_fornecedor",$dados['rua_cliente']);
				$query->bindValue(":num_cliente_fornecedor",$dados['num_cliente']);
				$query->bindValue(":bairro_cliente_fornecedor",$dados['bairro_cliente']);
				$query->bindValue(":complemento_cliente_fornecedor",$dados['complemento_cliente']);
				$query->bindValue(":cidade_cliente_fornecedor",$dados['cidade_cliente']);
				$query->bindValue(":estado_cliente_fornecedor",$dados['estado_cliente']);
				$query->bindValue(":pais_cliente_fornecedor",$dados['pais_cliente']);
				$query->bindValue(":cep_cliente_fornecedor",$dados['cep_cliente']);
				//$query->bindValue(":ativo_cliente_fornecedor",$dados['ativo_func']);
				
				
			}
				
			else if($string == "editar_requisicao_header")
			{
				parse_str($dados, $dados);
				$query = $pdo->prepare("UPDATE requisicoes_header SET 
					DESCRICAO_REQUISICAO = :descricao_produto, 
					ID_FORNECEDOR = :id_cliente_fornecedor, 
					TIPO_REQUISICAO = :tipo_requisicao, 
					OBS_REQUISICAO = :obs_requisicao WHERE ID_REQUISICAO = :id_requisicao;");
					
				$query->bindValue(":id_requisicao",$dados['id_requisicao']);
				$query->bindValue(":descricao_produto",$dados['descricao_produto']);
				$query->bindValue(":id_cliente_fornecedor",$dados['id_cliente_fornecedor']);
				$query->bindValue(":tipo_requisicao",$dados['tipo_requisicao']);
				$query->bindValue(":obs_requisicao",$dados['obs_requisicao']);
				
			}

			else if($string == "editar_requisicao_body")
			{
				parse_str($dados, $dados);
				$query = $pdo->prepare("UPDATE requisicoes_body SET 
					ID_FUNCIONARIO = :id, 
					QUANTIDADE_PRODUTO = :qtd_produto, 
					VALOR_PRODUTO_REQUISICAO = :valor_produto_requisicao, 
					DESCONTO_PRODUTO = :desc_produto, 
					STATUS_REQUISICAO = :status_requisicao WHERE ID_REQUISICAO_BODY = :id_requisicao_body;");
					
				$query->bindValue(":id_requisicao_body",$dados['id_requisicao_body']);
				$query->bindValue(":id",$dados['id']);
				$query->bindValue(":qtd_produto",$dados['qtd_produto']);
				$query->bindValue(":valor_produto_requisicao",$dados['valor_produto_requisicao']);
				$query->bindValue(":desc_produto",$dados['desc_produto']);
				$query->bindValue(":status_requisicao","1");
			}
				
			else if($string == "ativadesativa_funcionario")
			{
				$query = $pdo->prepare("UPDATE funcionario SET 
					ATIVO_FUNCIONARIO = :opcao WHERE ID_FUNCIONARIO = :id_func;");
					
				$query->bindValue(":id_func",$dados['id']);
				$query->bindValue(":opcao",$dados['opcao']);
				
			}

			else if($string == "ativadesativa_cliente_fornecedor")
			{
				$query = $pdo->prepare("UPDATE cliente_fornecedor SET 
					ATIVO_CLIENTE_FORNECEDOR = :opcao WHERE ID_CLIENTE = :id_clieforn;");
					
				$query->bindValue(":id_clieforn",$dados['id']);
				$query->bindValue(":opcao",$dados['opcao']);
				
			}
			
			else if($string == "editar_configuracoes")
			{				
				$query = $pdo->prepare("UPDATE configuracoes SET 
					RAZAO_SOCIAL_CONFIGURACAO = :razao_config,
					NOME_FANTASIA_CONFIGURACAO = :fantasia_config,
					CNPJ_CONFIGURACAO = :cnpj_config,
					IE_CONFIGURACAO = :ie_config,
					EMAIL_CONFIGURACAO = :email_config,
					SENHA_CONFIGURACAO = :senha_config,
					SMTP_CONFIGURACAO = :smtp_config,
					PORTA_CONFIGURACAO = :porta_config,
					TELEFONE1_CONFIGURACAO = :telefone1_config,
					TELEFONE2_CONFIGURACAO = :telefone2_config,
					CELULAR1_CONFIGURACAO = :celular1_config,
					CELULAR2_CONFIGURACAO = :celular2_config,
					RUA_CONFIGURACAO = :rua_config,
					NUMERO_CONFIGURACOES = :numero_config,
					BAIRRO_CONFIGURACOES = :bairro_config,
					COMPLEMENTO_CONFIGURACAO = :complemento_config,
					CEP_CONFIGURACAO = :cep_config,
					CIDADE_CONFIGURACAO = :cidade_config,
					UF_CONFIGURACAO = :estado_config,
					PAIS_CONFIGURACAO = :pais_config,
					VALOR_FRETE_CONFIGURACAO = :valor_frete_config,
					DATA_PRODUTO_OBSOLETO = :data_produto_obsoleto_config,
					DADOS_ADICIONAIS_CONFIGURACAO = :dados_adicionais_recibo_config WHERE ID_CONFIGURACOES = :id_config;");
					
				$query->bindValue(":id_config",1);
				$query->bindValue(":razao_config",$dados['razao_config']);
				$query->bindValue(":fantasia_config",$dados['fantasia_config']);
				$query->bindValue(":cnpj_config",$dados['cnpj_config']);
				$query->bindValue(":ie_config",$dados['ie_config']);
				$query->bindValue(":email_config",$dados['email_config']);
				$query->bindValue(":senha_config",$dados['senha_config']);
				$query->bindValue(":smtp_config",$dados['smtp_config']);
				$query->bindValue(":porta_config",$dados['porta_config']);
				$query->bindValue(":telefone1_config",$dados['telefone1_config']);
				$query->bindValue(":telefone2_config",$dados['telefone2_config']);
				$query->bindValue(":celular1_config",$dados['celular1_config']);
				$query->bindValue(":celular2_config",$dados['celular2_config']);
				$query->bindValue(":rua_config",$dados['rua_config']);
				$query->bindValue(":numero_config",$dados['numero_config']);
				$query->bindValue(":bairro_config",$dados['bairro_config']);
				$query->bindValue(":complemento_config",$dados['complemento_config']);
				$query->bindValue(":cep_config",$dados['cep_config']);
				$query->bindValue(":cidade_config",$dados['cidade_config']);
				$query->bindValue(":estado_config",$dados['estado_config']);
				$query->bindValue(":pais_config",$dados['pais_config']);
				$query->bindValue(":valor_frete_config",$dados['valor_frete_config']);
				$query->bindValue(":data_produto_obsoleto_config",$dados['data_produto_obsoleto_config']);
				$query->bindValue(":dados_adicionais_recibo_config",$dados['dados_adicionais_recibo_config']);
				
			}
			
			return($query);
		}
		
		public function delete($pdo, $string, $dados){
			$outros = new outros();
			
			if($string == "teste")
			{
				$query = $pdo->prepare("INSERT INTO funcionario (`NOME_FUNCIONARIO`) VALUES ('$dados');");
			}
			
			else if($string == "funcionario_edit_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_funcionario_historico, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_funcionario_historico",$dados['cod_func']);
				$query->bindValue(":titulo_historico","Pessoas");
				$query->bindValue(":contexto_historico","O funcionario <strong>".$dados['nome_func']."</strong> foi editado pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome</strong>");
			}

			else if($string == "delete_manual")
			{
				$query = $pdo->prepare("DELETE FROM manuais WHERE ID_MANUAL = :id_manual;");
				$query->bindValue(":id_manual",$dados);
			}

			//////////////////////
			//fornecedor_funcoes//
			//////////////////////

			//ajax_produtos
			else if($string == "desvincular_fornecedor")
			{
				$query = $pdo->prepare("DELETE FROM produto_fornecedor WHERE ID_PRODUTO_FORNECEDOR = :idprodutforn;");
				$query->bindValue(":idprodutforn", $idprodutforn);
			}

			return($query);
		}

		public function insert($pdo, $string, $dados){

			$outros = new outros();
			
			if($string == "teste")
			{
				$query = $pdo->prepare("INSERT INTO funcionario (`NOME_FUNCIONARIO`) VALUES ('$dados');");
			}
			
			//////////////////////
			///////Historico//////
			//////////////////////

			else if($string == "funcionario_edit_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_funcionario_historico, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_funcionario_historico",$id);
				$query->bindValue(":titulo_historico","Pessoas");
				$query->bindValue(":contexto_historico","O funcionario <strong>".$dados['nome_func']."</strong> foi editado pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome</strong>.");
			}
			
			else if($string == "epi_ferramentas_edit_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_usuario_sessao, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_usuario_sessao", $id);
				$query->bindValue(":titulo_historico","Estoque");
				$query->bindValue(":contexto_historico","O EPI/Ferramenta <strong>".$dados['descricao_epi-ferramentas']."</strong> foi editado pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome<;strong>.");
			
			
			
			}
						
			else if($string == "epi_ferramentas_inse_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_usuario_sessao, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_usuario_sessao", $id);
				$query->bindValue(":titulo_historico","Estoque");
				$query->bindValue(":contexto_historico","O EPI/Ferramenta <strong>".$dados['descricao_epi-ferramentas']."</strong> foi inserido pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome</strong>");
			}

			else if($string == "produto_inse_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_usuario_sessao, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_usuario_sessao", $id);
				$query->bindValue(":titulo_historico","Estoque");
				$query->bindValue(":contexto_historico","O produto <strong>".$dados['descricao_produto']."</strong> foi inserido pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome</strong>");
			}

			else if($string == "produto_edit_historico")
			{
				$id = $outros->asession('id');
				$nome = $outros->asession('nome');
				
				$query = $pdo->prepare("INSERT INTO historico (ID_FUNCIONARIO_HISTORICO, TITULO_HISTORICO, CONTEXTO_HISTORICO)
					VALUES (
					:id_usuario_sessao, 
					:titulo_historico, 
					:contexto_historico);");
					
				$query->bindValue(":id_usuario_sessao", $id);
				$query->bindValue(":titulo_historico","Estoque");
				$query->bindValue(":contexto_historico","O produto <strong>".$dados['descricao_produto']."</strong> foi editado pelo funcionario de codigo: <strong>$id</strong> e nome: <strong>$nome</strong>");
			}
					
			//////////////////////
			///////Estoque////////
			//////////////////////

			else if($string == "inserir_produtos")
			{
				$query = $pdo->prepare("INSERT INTO produtos (
					CODIGO_BARRAS_PRODUTO, 
					CODIGO_BARRAS_FORNECEDOR_PRODUTO, 
					COR_PRODUTO, 
					DESCRICAO_PRODUTO, 
					TIPO_CONTAGEM_PRODUTO, 
					GRUPO_PRODUTO, 
					PESO_PRODUTO, 
					ALTURA_PRODUTO, 
					LARGURA_PRODUTO, 
					PROFUNDIDADE_PRODUTO, 
					OBS_PRODUTO,
					ATIVO_PRODUTO, 
					DATA_CADASTRO_PRODUTO)
					VALUES (
					:codigo_barras_produto, 
					:codigo_barras_fornecedor_produto, 
					:cor_produto,
					:descricao_produto, 
					:volume_produto, 
					:grupo_produto, 
					:peso_produto, 
					:altura_produto, 
					:largura_produto, 
					:profundidade_produto, 
					:obs_produto, 
					:ativo_produto, 
					:data_cadastro_produto);");
					
				$query->bindValue(":codigo_barras_produto",$dados['codigo_barras_produto']);	
				$query->bindValue(":codigo_barras_fornecedor_produto",$dados['codigo_barras_fornecedor_produto']);
				$query->bindValue(":cor_produto",$dados['cor_produto']);
				$query->bindValue(":descricao_produto",$dados['descricao_produto']);
				$query->bindValue(":volume_produto",$dados['volume_produto']);
				$query->bindValue(":grupo_produto",$dados['grupo_produto']);
				$query->bindValue(":peso_produto",$dados['peso_produto']);
				$query->bindValue(":altura_produto",$dados['altura_produto']);
				$query->bindValue(":largura_produto",$dados['largura_produto']);
				$query->bindValue(":profundidade_produto",$dados['profundidade_produto']);
				$query->bindValue(":obs_produto",$dados['obs_produto']);
				$query->bindValue(":ativo_produto","0");
				$query->bindValue(":data_cadastro_produto",$dados['data_cadastro_produto']);
			}

			else if($string == "inserir_epi_ferramentas")
			{
				$query = $pdo->prepare("INSERT INTO epi_ferramentas (
					CODIGO_BARRAS_EPI_FERRAMENTAS, 
					CODIGO_BARRAS_FORNECEDOR_EPI_FERRAMENTAS, 
					FINALIDADE_EPI_FERRAMENTAS, 
					DESCRICAO_EPI_FERRAMENTAS, 
					TIPO_CONTAGEM_EPI_FERRAMENTAS, 
					GRUPO_EPI_FERRAMENTAS, 
					PESO_EPI_FERRAMENTAS, 
					ALTURA_EPI_FERRAMENTAS, 
					LARGURA_EPI_FERRAMENTAS, 
					PROFUNDIDADE_EPI_FERRAMENTAS, 
					OBS_EPI_FERRAMENTAS,
					ATIVO_EPI_FERRAMENTAS, 
					DATA_CADASTRO_EPI_FERRAMENTAS)
					VALUES (
					:cod_barras_epi_ferramentas, 
					:cod_barras_fornecedor_epi_ferramentas, 
					:finalidade_epi_ferramentas, 
					:descricao_epi_ferramentas, 
					:volume_epi_ferramentas, 
					:grupo_epi_ferramentas, 
					:peso_epi_ferramentas, 
					:altura_epi_ferramentas, 
					:largura_epi_ferramentas, 
					:profundidade_epi_ferramentas, 
					:obs_epi_ferramentas, 
					:ativo_epi_ferramentas, 
					:data_cadastro_epi_ferramentas);");
					
				$query->bindValue(":cod_barras_epi_ferramentas",$dados['cod_barras_epi-ferramentas']);	
				$query->bindValue(":cod_barras_fornecedor_epi_ferramentas",$dados['cod_barras_fornecedor_epi-ferramentas']);
				$query->bindValue(":finalidade_epi_ferramentas",$dados['finalidade_epi-ferramentas']);
				$query->bindValue(":descricao_epi_ferramentas",$dados['descricao_epi-ferramentas']);
				$query->bindValue(":volume_epi_ferramentas",$dados['volume_epi-ferramentas']);
				$query->bindValue(":grupo_epi_ferramentas",$dados['grupo_epi-ferramentas']);
				$query->bindValue(":peso_epi_ferramentas",$dados['peso_epi-ferramentas']);
				$query->bindValue(":altura_epi_ferramentas",$dados['altura_epi-ferramentas']);
				$query->bindValue(":largura_epi_ferramentas",$dados['largura_epi-ferramentas']);
				$query->bindValue(":profundidade_epi_ferramentas",$dados['profundidade_epi-ferramentas']);
				$query->bindValue(":obs_epi_ferramentas",$dados['obs_epi-ferramentas']);
				$query->bindValue(":ativo_epi_ferramentas","0");
				$query->bindValue(":data_cadastro_epi_ferramentas",$dados['data_cadastro_epi-ferramentas']);
			}

			//////////////////////
			//fornecedor_funcoes//
			//////////////////////

			//ajax_produtos
			else if($string == "vincular_fornecedor")
			{
				$id = $outros->asession('id');
				$query = $pdo->prepare("INSERT INTO produto_fornecedor (
					ID_FORNECEDOR, 
					ID_PRODUTO, 
					FUNCIONARIO_PRODUTO_FORNECEDOR)
					VALUES (
					:id_fornecedor, 
					:id_produto, 
					:id_usuario_session);");
					
				$query->bindValue(":id_fornecedor",$dados['id_fornecedor']);	
				$query->bindValue(":id_produto",$dados['id_produto']);
				$query->bindValue(":id_usuario_session",$id);
			}

			else if($string == "inserir_funcionario")
			{
				$query = $pdo->prepare("INSERT INTO funcionario (NOME_FUNCIONARIO, SOBRENOME_FUNCIONARIO, RG_FUNCIONARIO, CPF_FUNCIONARIO, TELEFONE1_FUNCIONARIO, TELEFONE2_FUNCIONARIO, CELULAR1_FUNCIONARIO, CELULAR2_FUNCIONARIO, DATANASCIMENTO_FUNCIONARIO, EMAIL_FUNCIONARIO, RUA_FUNCIONARIO, NUM_FUNCIONARIO, BAIRRO_FUNCIONARIO, COMPLEMENTO_FUNCIONARIO, CIDADE_FUNCIONARIO, ESTADO_FUNCIONARIO, PAIS_FUNCIONARIO, CEP_FUNCIONARIO, USUARIO_FUNCIONARIO, SENHA_USUARIO_FUNCIONARIO)
					VALUES (
					:nome_func, 
					:sobrenome_func, 
					:rg_func, 
					:cpf_func, 
					:telefone1_func, 
					:telefone2_func, 
					:celular1_func, 
					:celular2_func, 
					:nascimento_func, 
					:email_func, 
					:rua_func, 
					:num_func, 
					:bairro_func, 
					:complemento_func, 
					:cidade_func, 
					:estado_func, 
					:pais_func, 
					:cep_func, 
					:usuario_func, 
					:senha_func);");
					
				$query->bindValue(":nome_func",$dados['nome_func']);
				$query->bindValue(":sobrenome_func",$dados['sobrenome_func']);
				$query->bindValue(":rg_func",$dados['rg_func']);
				$query->bindValue(":cpf_func",$dados['cpf_func']);
				$query->bindValue(":telefone1_func",$dados['telefone1_func']);
				$query->bindValue(":telefone2_func",$dados['telefone2_func']);
				$query->bindValue(":celular1_func",$dados['celular1_func']);
				$query->bindValue(":celular2_func",$dados['celular2_func']);
				$query->bindValue(":nascimento_func",$dados['nascimento_func']);
				$query->bindValue(":email_func",$dados['email_func']);
				$query->bindValue(":cep_func",$dados['cep_func']);
				$query->bindValue(":rua_func",$dados['rua_func']);
				$query->bindValue(":num_func",$dados['num_func']);
				$query->bindValue(":bairro_func",$dados['complemento_func']);
				$query->bindValue(":complemento_func",$dados['bairro_func']);
				$query->bindValue(":cidade_func",$dados['cidade_func']);
				$query->bindValue(":estado_func",$dados['estado_func']);
				$query->bindValue(":pais_func",$dados['pais_func']);
				$query->bindValue(":usuario_func",$dados['usuario_func']);
				$query->bindValue(":senha_func",$dados['senha_func']);
			}

			else if($string == "bug_snapcloud")
			{
				$dados2 = $dados;
				unset($dados2['erro']);
				$dados2 = implode($dados2, ", ");
				
				$query = $pdo->prepare("INSERT INTO bugs (
					DESCRICAO_BUG,
					ERRO_BUG,
					FILIAL_CONFIGURACAO,
					RAZAO_CONFIGURACAO,
					DATA_CRIACAO_BUG)
					VALUES (
					:descricao_bug,
					:erro_bug,
					:filial_configuracao,
					:razao_configuracao,
					:hora_atual);");
					
				$query->bindValue(":descricao_bug",$dados2);	
				$query->bindValue(":erro_bug",$dados['erro']);	
				$query->bindValue(":filial_configuracao",$dados['filial_configuracao']);	
				$query->bindValue(":razao_configuracao",$dados['razao_configuracao']);	
				$query->bindValue(":hora_atual",$dados['hora_atual']);	
			}
			
			else if($string == "inserir_cliente-fornecedor")
			{
				$query = $pdo->prepare("INSERT INTO cliente_fornecedor (RAZAO_SOCIAL_CLIENTE, NOME_FANTASIA_CLIENTE, TIPO_EMPRESA_CLIENTE, OCUPACAO_CLIENTE_FORNECEDOR, DATA_ABERTURA_CLIENTE, CNPJ_CPF_CLIENTE, INSCRICAO_ESTADUAL_CLIENTE, EMAIL_CLIENTE, TELEFONE1_CLIENTE, TELEFONE2_CLIENTE, CELULAR1_CLIENTE, CELULAR2_CLIENTE, RUA_CLIENTE, NUM_CLIENTE, BAIRRO_CLIENTE, COMPLEMENTO_CLIENTE, CIDADE_CLIENTE, ESTADO_CLIENTE, PAIS_CLIENTE, CEP_CLIENTE)
					VALUES (
					:razaosocial_cliente_fornecedor, 
					:nomefantasia_cliente_fornecedor, 
					:tipoempresa_cliente_fornecedor, 
					:ocupacao_cliente_fornecedor, 
					:dataabertura_cliente_fornecedor, 
					:cnpjcpf_cliente_fornecedor, 
					:inscricao_cliente_fornecedor, 
					:email_cliente_fornecedor, 
					:telefone1_cliente_fornecedor, 
					:telefone2_cliente_fornecedor, 
					:celular1_cliente_fornecedor, 
					:celular2_cliente_fornecedor, 
					:rua_cliente_fornecedor, 
					:num_cliente_fornecedor, 
					:bairro_cliente_fornecedor, 
					:complemento_cliente_fornecedor, 
					:cidade_cliente_fornecedor, 
					:estado_cliente_fornecedor, 
					:pais_cliente_fornecedor, 
					:cep_cliente_fornecedor);");
					
				$query->bindValue(":razaosocial_cliente_fornecedor",$dados['razao_cliente']);
				$query->bindValue(":nomefantasia_cliente_fornecedor",$dados['fantasia_cliente']);
				$query->bindValue(":tipoempresa_cliente_fornecedor",$dados['tipo_empresa_cliente']);
				$query->bindValue(":ocupacao_cliente_fornecedor",$dados['ocupacao_cliente_fornecedor']);
				$query->bindValue(":dataabertura_cliente_fornecedor",$dados['data_abertura_cliente']);
				$query->bindValue(":cnpjcpf_cliente_fornecedor",$dados['cnpj_cpf_cliente']);
				$query->bindValue(":inscricao_cliente_fornecedor",$dados['ie_cliente']);
				$query->bindValue(":email_cliente_fornecedor",$dados['email_cliente']);
				$query->bindValue(":telefone1_cliente_fornecedor",$dados['telefone1_cliente']);
				$query->bindValue(":telefone2_cliente_fornecedor",$dados['telefone2_cliente']);
				$query->bindValue(":celular1_cliente_fornecedor",$dados['celular1_cliente']);
				$query->bindValue(":celular2_cliente_fornecedor",$dados['celular2_cliente']);
				$query->bindValue(":rua_cliente_fornecedor",$dados['rua_cliente']);
				$query->bindValue(":num_cliente_fornecedor",$dados['num_cliente']);
				$query->bindValue(":bairro_cliente_fornecedor",$dados['bairro_cliente']);
				$query->bindValue(":complemento_cliente_fornecedor",$dados['complemento_cliente']);
				$query->bindValue(":cidade_cliente_fornecedor",$dados['cidade_cliente']);
				$query->bindValue(":estado_cliente_fornecedor",$dados['estado_cliente']);
				$query->bindValue(":pais_cliente_fornecedor",$dados['pais_cliente']);
				$query->bindValue(":cep_cliente_fornecedor",$dados['cep_cliente']);
			}
			
			else if($string == "inserir_produto_requisicao")
			{
				$id_usuario_session = $outros->asession('id');
				$query = $pdo->prepare("INSERT INTO requisicoes_body (ID_REQUISICAO_HEADER, ID_FUNCIONARIO, ID_PRODUTO, QUANTIDADE_PRODUTO, DESCONTO_PRODUTO)
					VALUES (
					:idrequisicao, 
					:id_usuario_session, 
					:idprodut, 
					:quantidade_produto, 
					:desconto_produto);");
				$query->bindValue(":idrequisicao",$dados['idrequisicao']);
				$query->bindValue(":id_usuario_session",$id_usuario_session);
				$query->bindValue(":idprodut",$dados['idprodut']);
				$query->bindValue(":quantidade_produto","0");
				$query->bindValue(":desconto_produto","0");
			}
			
			else if($string == "abrir_ticket_cabecalho_suporte")
			{
				$nome = $outros->asession('nome');
				$query = $pdo->prepare("INSERT INTO tickets_cabecalho(`ASSUNTO_TICKETS`, `DESCRICAO_TICKETS`, `FILIAL_TICKET_CABECALHO`, `TIPO_TICKETS`, `ESTADO_TICKETS`,`AUTOR_TICKETS`)
					VALUES (
					:assunto_ticket, 
					:descricao_ticket, 
					:filial_configuracoes, 
					:tipo_ticket, 
					:estado_ticket,
					:autor_ticket);");
					
				$query->bindValue(":assunto_ticket",$dados['assunto_ticket']);
				$query->bindValue(":descricao_ticket",$dados['descricao_ticket']);
				$query->bindValue(":filial_configuracoes",$dados['filial_configuracoes']);
				$query->bindValue(":tipo_ticket",$dados['tipo_ticket']);
				$query->bindValue(":estado_ticket","0");
				$query->bindValue(":autor_ticket",$nome);
				
			}

			else if($string == "responder_ticket_suporte")
			{
				$nome = $outros->asession('nome');
				$extensao = pathinfo ( $_FILES[ 'img_func' ][ 'name' ], PATHINFO_EXTENSION );
				$extensao = strtolower ( $extensao );

				$query = $pdo->prepare("INSERT INTO tickets_corpo(`ID_TICKET_CABECALHO`, `TIPO_TICKET_CORPO`, `USUARIO_TICKET_CORPO`, `TEXTO_TICKET_CORPO`, `ANEXO_TICKETS`)
					VALUES (
					:ticket_id, 
					:tipo_ticket_corpo, 
					:nome_funcionario, 
					:descricao_ticket, 
					:anexo_tickets);");

				$query->bindValue(":ticket_id",$dados['ticket_id']);
				$query->bindValue(":tipo_ticket_corpo","0");
				$query->bindValue(":nome_funcionario",$nome);
				$query->bindValue(":descricao_ticket",$dados['mensagem']);
				$query->bindValue(":anexo_tickets",$extensao);
				
			}

			else if($string == "inserir_manual")
			{
				$id_session = $outros->asession('id');
				$extensao = pathinfo ( $_FILES[ 'pdf_manu' ][ 'name' ], PATHINFO_EXTENSION );
				$extensao = strtolower ( $extensao );
				$novoNome = $dados['nome_manu'] . '.' . $extensao;

				$query = $pdo->prepare("INSERT INTO manuais( `DESCRICAO_MANUAL`, `CAMINHO_MANUAL`, `ID_CRIADOR`)
					VALUES (
					:descricao_manual, 
					:caminho_manual, 
					:id_criador);");

				$query->bindValue(":descricao_manual",$dados['nome_manu']);
				$query->bindValue(":caminho_manual",$novoNome);
				$query->bindValue(":id_criador",$id_session);
			}

			return($query);
		}
		
	}
?>