<?php
// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgclasif" class="color-red">Tallas</a></li>
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

// TABLA DE CLASIFICACIONES
	echo '
	<div class="uk-width-1-1 margin-v-20">
		<div class="uk-container uk-container-xsmall">
			<div>
				<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
					<thead>
						<tr class="uk-text-muted">
							<th >Clasificación</th>
							<th width="10px"></th>
						</tr>
					</thead>
					<tbody class="sortable" data-tabla="productosclasif">';
					// Obtener tipos
					$CONSULTA = $CONEXION -> query("SELECT * FROM productosclasif ORDER BY orden");
					while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
						$thisID=$rowCONSULTA['id'];

						echo '
						<tr id="'.$thisID.'">
							<td class="uk-text-left">
								<input class="editarajax uk-input uk-form-blank" type="text" data-tabla="productosclasif" data-campo="txt" data-id="'.$rowCONSULTA['id'].'" value="'.$rowCONSULTA['txt'].'" tabindex="8">
							</td>
							<td class="uk-text-nowrap">
								<button data-id="'.$thisID.'" data-tabla="productosclasif" class="borrar uk-icon-button uk-button-danger" uk-icon="trash" data-activo="3"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgtallas&id='.$thisID.'" class="uk-icon-button uk-button-primary" uk-icon="search"></a>
							</td>
						</tr>';
					}
					echo '
					</tbody>
				</table>
			</div>
		</div>
	</div>';

// VENTANAS MODALES
	echo '
	<div id="add" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<form action="index.php" method="post">
				<input type="hidden" name="nuevaclasif" value="1">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="subseccion" value="'.$subseccion.'">
	
				<div class="uk-margin">
					<label>Nueva clasificación</label>
					<input type="text" name="txt" class="uk-input" required>
				</div>
				<div class="uk-margin uk-text-center">
					<a class="uk-button uk-button-white uk-button-large uk-modal-close">Cerrar</a>
					<button class="uk-button uk-button-primary uk-button-large">Agregar</button>
				</div>
	
			</form>
		</div>
	</div>
	';


$scripts='
	// Eliminar existencias
		$(".borrar").click(function(){
			var id = $(this).attr("data-id");
			var tabla = $(this).attr("data-tabla");
			var campo = $(this).attr("data-campo");
			UIkit.modal.confirm("<div class=\'uk-text-center\'><div class=\'uk-text-center bg-danger color-white padding-20 uk-text-bold text-lg\'>¡ATENCIÓN!</div><div class=\'padding-20\'>Puede desconfigurar el sitio</div>").then(function() {
				var statusConfirm = confirm("Esta operación no se puede deshacer. Está seguro?"); 
				if (statusConfirm == true){
					window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&eliminargeneral=1&eliminarexistencias=1&tabla="+tabla+"&campo="+campo+"&id="+id);
				}
			}, function () {
			    console.log("Rejected.")
			});
		});
	';










