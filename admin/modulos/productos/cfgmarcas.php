<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgmarcas" class="color-red">Marcas</a></li>
		</ul>
	</div>';

// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';

// TABLA DE TALLAS
	echo '
		<div class="uk-width-1-1 margin-v-20">
			<div class="uk-container uk-container-small">
				<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
					<thead>
						<tr class="uk-text-muted">
							<th class="uk-text-left">Marca</th>
							<th width="100px" class="uk-text-center">Logotipo</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tbody class="sortable" data-tabla="productosmarcas">';
					// Obtener tipos
					$CONSULTA = $CONEXION -> query("SELECT * FROM productosmarcas ORDER BY orden");
					while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
						$thisID=$rowCONSULTA['id'];

						$pic=$rutaFinal.$rowCONSULTA['imagen'];
						$fichaIcon='<i class="fa-lg far fa-square uk-text-muted pointer"></i>';
						if(file_exists($pic) AND strlen($rowCONSULTA['imagen'])>0){
							$fichaIcon='
								<div class="uk-inline">
									<i class="fa-lg fas fa-check-square uk-text-primary pointer"></i>
									<div uk-drop="pos: right-justify">
										<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
									</div>
								</div>';
						}

						echo '
										<tr id="'.$thisID.'">
											<td class="uk-text-left">
												<input class="editarajax uk-input uk-form-blank" type="text" data-tabla="productostalla" data-campo="txt" data-id="'.$rowCONSULTA['id'].'" value="'.$rowCONSULTA['txt'].'">
											</td>
											<td class="uk-text-center">
												<a href="#ficha" uk-toggle data-id="'.$thisID.'" class="fichalink">'.$fichaIcon.'</a>
											</td>
											<td class="uk-text-right">
												<button data-id="'.$thisID.'" data-tabla="productosmarcas" data-campo="marca" class="borrar uk-icon-button uk-button-danger" uk-icon="trash"></button>
											</td>
										</tr>';
					}


					echo '
					</tbody>
				</table>
			</div>
		</div>
	</div>';


// Ventanas modales 
	echo '
	<div id="ficha" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<input type="hidden" id="fichaid">
			<p>JPG 160 x 110 px</p>
			<div id="fileupload">
				Cargar
			</div>
		</div>
	</div>';



	echo '
	<div id="add" uk-modal class="modal">
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h4>Nueva marca</h4>
			<form action="index.php" method="get">
				<input type="hidden" name="nuevamarca" value="1">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="subseccion" value="'.$subseccion.'">

				<div class="uk-margin ">
					<input type="text" name="txt" class="uk-input" placeholder="Nueva marca" required>
				</div>
				<div class="uk-margin uk-text-center">
					<a class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</a>
					<button class="uk-button uk-button-primary uk-button-large">Agregar</button>
				</div>
			</form>
		</div>
	</div>';


$scripts='
	// Eliminar
		$(".borrar").click(function(){
			var id = $(this).attr("data-id");
			var tabla = $(this).attr("data-tabla");
			var activo = $(this).attr("data-activo");
			UIkit.modal.confirm("Desea eliminar esto?").then(function() {
				window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&activo="+activo+"&eliminargeneral=1&tabla="+tabla+"&id="+id);
			}, function () {
			    console.log("Rejected.")
			});
		});

	// Eliminar
		$(".borrarexistencias").click(function(){
			var id = $(this).attr("data-id");
			var tabla = $(this).attr("data-tabla");
			var campo = $(this).attr("data-campo");
			UIkit.modal.confirm("Desea eliminar esto?").then(function() {
				window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&eliminargeneral=1&eliminarexistencias=1&tabla="+tabla+"&campo="+campo+"&id="+id);
			}, function () {
			    console.log("Rejected.")
			});
		});
		

		$(".fichalink").click(function(){
			var id = $(this).attr("data-id");
			$("#fichaid").val(id);
		})

		$("#fileupload").uploadFile({
			url: "../library/upload-file/php/upload.php",
			fileName: "myfile",
			maxFileCount: 1,
			showDelete: \'false\',
			allowedTypes: "jpg",
			maxFileSize: 10000000,
			showFileCounter: false,
			showPreview: false,
			returnType: \'json\',
			onSuccess:function(data){
				var id = $("#fichaid").val();
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&activo=2&position=iconomarcas&id=\'+id+\'&filename=\'+data);
			}
		});

		$("#fileuploadclasif").uploadFile({
			url: "../library/upload-file/php/upload.php",
			fileName: "myfile",
			maxFileCount: 1,
			showDelete: \'false\',
			allowedTypes: "jpg",
			maxFileSize: 10000000,
			showFileCounter: false,
			showPreview: false,
			returnType: \'json\',
			onSuccess:function(data){
				var id = $("#fichaid").val();
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&activo=3&position=iconoclasif&id=\'+id+\'&filename=\'+data);
			}
		});

		$("#fileuploadclasiftxt").uploadFile({
			url: "../library/upload-file/php/upload.php",
			fileName: "myfile",
			maxFileCount: 1,
			showDelete: \'false\',
			allowedTypes: "png",
			maxFileSize: 10000000,
			showFileCounter: false,
			showPreview: false,
			returnType: \'json\',
			onSuccess:function(data){
				var id = $("#fichaid").val();
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&activo=3&position=iconoclasiftxt&id=\'+id+\'&filename=\'+data);
			}
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










