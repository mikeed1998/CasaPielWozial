<?=$head?>
<?=$header?>

<?php 
require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 
?>
<?=$jquery?>

<script>
	// Eliminar carpeta
	$(function() {
		$(".eliminarpedido").click(function() {
			var statusConfirm = confirm("Realmente desea eliminar este pedido?");
			var id=$(this).data('id');
			if (statusConfirm == true) { 
				window.location = ("index.php?seccion=<?=$seccion?>&borrarPedido&id="+id);
			} 
		});
	});

	function checkForm(form)
	{
		form.enviar.value = "Espere...";
		form.enviar.disabled = true;
		setTimeout(function(){ 
			form.enviar.value = "Reintentar";
			form.enviar.disabled = false;
		}, 3000);
		return true;
	}

	<?=$scripts?>

</script>

<?=$footer?>
