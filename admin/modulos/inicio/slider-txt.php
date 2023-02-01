

<div class="uk-width-1-1 margin-top-20">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">Slider superior</a></li>
		';
		?>
	</ul>
</div>

<div class="uk-width-medium-1-1 margen-v-20">
	<div class="uk-container">
		<div class="uk-text-right">
			<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
		</div>
		<div uk-grid class="sortable" data-tabla="slidertxt">
		<?php
		$consulta = $CONEXION -> query("SELECT * FROM slidertxt ORDER BY orden");
		while ($rowConsulta = $consulta -> fetch_assoc()) {
			$id=$rowConsulta['id'];

			echo '
			<div id="'.$id.'" style="width:350px;">
				<div class="uk-card uk-card-default uk-card-body">
					<div class="uk-text-center">
						<span data-id="'.$id.'" class="eliminaprod uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#editar" uk-toggle data-id="'.$id.'" class="editar uk-icon-button uk-button-primary" uk-icon="icon:pencil"></a>
					</div>

					
					<div class="uk-margin" id="txt4_'.$id.'">'.nl2br($rowConsulta['txt4']).'</div>
					<div class="uk-margin" id="txt6_'.$id.'">'.($rowConsulta['txt6']).'</div>
				</div>
			</div>';
		}
		?>

		</div>
	</div>
</div>


<div id="add" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<h2 class="Nuevo"></h2>
		<form method="post" action="index.php">
			<input type="hidden" name="seccion" value="<?=$seccion?>">
			<input type="hidden" name="subseccion" value="<?=$subseccion?>">
			<input type="hidden" name="nuevoslidedetexto" value="1">

			<div uk-grid class="uk-child-width-1-1">
				<div>
					<label>Texto</label>
					<textarea name="txt4" class="uk-textarea" style="height:100px;"></textarea>
				</div>
				<div>
					<label>Link</label>
					<input type="text" name="txt6" class="uk-input">
				</div>
			<div class="uk-text-center uk-margin">
				<span class="uk-button uk-button-default uk-button-large uk-modal-close" type="button">Cancelar</span>
				<button type="submit" class="uk-button uk-button-primary uk-button-large">Agregar</button>
			</div>
		</form>
	</div>
</div>


<div id="editar" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<h2 class="Editar"></h2>
		<form method="post" action="index.php">
			<input type="hidden" name="seccion" value="<?=$seccion?>">
			<input type="hidden" name="subseccion" value="<?=$subseccion?>">
			<input type="hidden" name="editarslidertexto" value="1">
			<input type="hidden" name="id" id="ideditar">

			<div uk-grid class="uk-child-width-1-1">
				<div>
					<label>Texto</label>
					<textarea name="txt4" id="txt4" class="uk-textarea" style="height:100px;"></textarea>
				</div>
				<div>
					<label>Link</label>
					<input type="text" name="txt6" id="txt6" class="uk-input">
				</div>
			</div>

			<div class="uk-margin uk-text-center">
				<span class="uk-button uk-button-default uk-button-large uk-modal-close" type="button">Cancelar</span>
				<button type="submit" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>

<?php
$scripts='

	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					borrarslidetexto: 1,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg, {pos: "bottom-right"});
				$("#"+id).addClass( "uk-invisible" );
			});
		}
	});

	$(".editar").click(function(){
		var id = $(this).attr("data-id");
		$("#ideditar").val(id);

		var campos = ["txt4","txt6"];
		campos.forEach(leerlineas);
		function leerlineas(item){
			var id = $("#ideditar").val();
			var valor = $("#"+item+"_"+id).text();
			console.log(valor);
			$("#"+item).val(valor);
		};
	});



	';



?>