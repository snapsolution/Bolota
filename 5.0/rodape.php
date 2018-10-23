<footer class="main-footer">
	<div class="pull-right hidden-xs">
		&nbsp; &nbsp;
		<b>Versão</b> 5.0.0
	</div>
	<div class="pull-right">
		<?php 
			$id = $outros->asession('id');
			if($id == 1){echo"<a href='javascript:void(0);' ";?> onclick="load_modulos('adm/views/ajax_adm','')"<?php echo"><i class='fa fa-gears'></i></a>";} 
		?>
	</div>
	<strong>Copyright &copy; 2018 <a href="javascript:void(0);">SnapSolutions</a>.</strong> Todos os direitos reservados.
</footer>

       