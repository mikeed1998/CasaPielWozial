<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgcolores" class="color-red">Colores</a></li>
		</ul>
	</div>';


// COLORES Y TEXTURAS
	echo '
	<div class="uk-width-1-1">
		<div uk-grid>
			<div class="uk-width-1-2@s margin-v-20">
				<div class="uk-card uk-card-default uk-card-body uk-border-rounded">
					<form action="index.php" method="post">
						<div uk-grid>
							<div class="uk-width-expand">
								<input type="hidden" name="nuevocolor" value="1">
								<input type="hidden" name="seccion" value="'.$seccion.'">
								<input type="hidden" name="subseccion" value="'.$subseccion.'">
								<input type="color" name="txt" class="uk-input" value="#ffffff" required><br><br>
							</div>
							<div class="uk-width-auto">
								<input type="submit" name="send" value="Agregar" class="uk-button uk-button-primary">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="uk-width-1-2@s margin-v-20 uk-text-center">
				<div class="uk-card uk-card-default uk-card-body uk-border-rounded">
					<a href="#colorpic" uk-toggle class="uk-button uk-button-primary">Nueva textura</a>
				</div>
			</div>
		</div>
		<div class="uk-width-1-1">
			<div>
				<div uk-grid class="uk-flex-center">';

				// Obtener colores
				$CONSULTA = $CONEXION -> query("SELECT * FROM productoscolor ORDER BY txt");
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					$thisID   = $rowCONSULTA['id'];
					$imagen   = $rutaFinal.$rowCONSULTA['imagen'];
					$colorTxt = (strlen($rowCONSULTA['imagen'])>0 AND file_exists($imagen))?'<div class="uk-border-circle uk-container" style="background:url('.$imagen.');background-size:cover;width:70px;height:70px;border:solid 1px #999;">&nbsp;</div>':'<input type="color" class="editarcolor uk-input uk-form-width-xsmall" data-tabla="productoscolor" data-campo="txt" data-id="'.$rowCONSULTA['id'].'" placeholder="Color" value="'.$rowCONSULTA['txt'].'">';
					echo '
						<div style="max-width:200px;">
							<div class="uk-card-body">
								<div>
									<input class="editarajax uk-input" data-tabla="productoscolor" data-campo="name" data-id="'.$thisID.'" value="'.$rowCONSULTA['name'].'" tabindex="10">
								</div>
								<div class="uk-margin uk-flex uk-flex-center">
									'.$colorTxt.'
								</div>
								<div class="uk-text-center">
									<button data-id="'.$thisID.'" data-tabla="productoscolor" data-campo="color" class="borrarexistencias uk-icon-button uk-button-danger" uk-icon="trash"></button>
								</div>
							</div>
						</div>';
				}

				echo '
				</div>
			</div>
		</div>
	</div>';


// VENTANAS MODALES 
	echo '
	<div id="colorpic" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<p>JPG 50 x 50 px</p>
			<div id="colorupload">
				Cargar
			</div>
		</div>
	</div>
	';


$scripts='
	// Eliminar existencias
	$(".borrarexistencias").click(function(){
		var id = $(this).attr("data-id");
		var tabla = $(this).attr("data-tabla");
		var campo = $(this).attr("data-campo");
		UIkit.modal.confirm("Se eliminará este color y todas sus existencias").then(function() {
			var statusConfirm = confirm("Esta operación no se puede deshacer. Está seguro?"); 
			if (statusConfirm == true){
				window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&eliminargeneral=1&eliminarexistencias=1&tabla="+tabla+"&campo="+campo+"&id="+id);
			}
		}, function () {
		    console.log("Rejected.")
		});
	});

	$("#colorupload").uploadFile({
		url: "../library/upload-file/php/upload.php",
		fileName: "myfile",
		maxFileCount: 1,
		showDelete: \'false\',
		allowedTypes: "jpg,jpeg",
		maxFileSize: 20000000,
		showFileCounter: false,
		showPreview: false,
		returnType: \'json\',
		onSuccess:function(data){
			window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&activo=0&position=color&filename=\'+data);
		}
	});

	// Editor color
	$(".editarcolor").change(function() {
		var id = $(this).attr("data-id");
		var tabla = $(this).attr("data-tabla");
		var campo = $(this).attr("data-campo");
		var valor = $(this).val();

		$.ajax({
			method: "POST",
			url: "modulos/varios/acciones.php",
			data: { 
				editarajax: 1,
				id: id,
				tabla: tabla,
				campo: campo,
				valor: valor
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});


	';










