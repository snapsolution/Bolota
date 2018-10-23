<?php 

class loadpage{
	public function load_tabela(){
		echo"
		<script>
			function load_tabela(pagina)
			{
				var url = 'modulos/'+pagina+'.php';
				$.get(url, function(dataReturn) 
				{
					$('#load_tabela').html(dataReturn);
				}); 
			}
		</script>
		";
	}
	
	public function load_modulos(){
		//$this->fullscreen();
		//$this->autologoff();
		
		echo"
		<script>
			function load_modulos(pagina, dados)
			{
				var url = 'modulos/'+pagina+'.php?dados='+dados;
				$.get(url, function(dataReturn)
				{
					$('#load_modulos').html(dataReturn);
				});
			}
		</script>
		";
	}

}

?>