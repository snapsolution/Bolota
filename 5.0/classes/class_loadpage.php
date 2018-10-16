<?php 

class loadpage{
	public function load_modulos(){
		echo"
		<script>
			function load_modulos(pagina)
			{

					var url = 'modulos/'+pagina+'.php';
					$.get(url, function(dataReturn) 	
					{
						$('#class_loadpage').html(dataReturn);
					}); 
			}
		</script>
		";
	}	

}

?>