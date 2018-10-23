<STYLE type="text/css">
	.material-switch > input[type="checkbox"] {
		display: none;   
	}

	.material-switch > label {
		cursor: pointer;
		height: 0px;
		position: relative; 
		width: 40px;  
	}

	.material-switch > label::before {
		background: rgb(0, 0, 0);
		box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
		border-radius: 8px;
		content: '';
		height: 16px;
		margin-top: -8px;
		position:absolute;
		opacity: 0.3;
		transition: all 0.4s ease-in-out;
		width: 40px;
	}
	.material-switch > label::after {
		background: rgb(255, 255, 255);
		border-radius: 16px;
		box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		content: '';
		height: 24px;
		left: -4px;
		margin-top: -8px;
		position: absolute;
		top: -4px;
		transition: all 0.3s ease-in-out;
		width: 24px;
	}
	.material-switch > input[type="checkbox"]:checked + label::before {
		background: inherit;
		opacity: 0.5;
	}
	.material-switch > input[type="checkbox"]:checked + label::after {
		background: inherit;
		left: 20px;
	}
</STYLE>

<?php
	$dir=dirname(dirname(__DIR__), 2). '/classes';
	include("$dir/class_outros.php");
	include("$dir/class_config.php");
	$outros = new outros();
	$config = new config();

	$obj = $config->conexaoBD("configuracoes","count","select","");
		$modulo_banco = $obj->MODULO_BANCO;

	$dados['modulo_pasta'] = $outros->checar_modulo();

	if($modulo_banco != $dados['modulo_pasta'])
	{
		$modulo_banco = $dados['modulo_pasta'];
		$config->conexaoBD("atualizar_modulo","","update",$dados);
		
	}

	echo "
		<table id='data-table' class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th class='col-md-2'><center>Icone</center></th>
					<th class='col-md-3'>Modulo</th>
					<th class='col-md-1'><center>Posição</center></th>
					<th class='col-md-1'>Ativo</th>	
				</tr>
			</thead>
			<tbody>
	";
	$modulo_banco = explode('|', $modulo_banco);
	foreach ( $modulo_banco as $seu_valor ) {
		if($seu_valor != "")
		{
			echo"
				<tr>
					<td>
						<center><input type='text' id='profundidade_epi-ferramentas' class='form-control' name='profundidade_epi-ferramentas'></center>
					</td>
					<td>
						<center>".$seu_valor."</center>
					</td>
					<td>
						<center><input type='text' id='profundidade_epi-ferramentas' class='form-control' name='profundidade_epi-ferramentas'></center>
					</td>
					<td>
						<div class='material-switch'>
							<input id='$seu_valor' name='$seu_valor' type='checkbox'"; if($ativo_epi_ferramentas=='on'){echo"checked";} echo">
							<label for='$seu_valor' class='label-primary'></label>
						</div>
					</td>
				</tr>
			";
		}
	}
	echo"
		</tbody>
	";
?>		

