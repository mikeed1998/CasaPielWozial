<?php
	$CONSULTA = $CONEXION -> query("SELECT * FROM productosclasif WHERE id = $id");
	$rowCONSULTA = $CONSULTA -> fetch_assoc();
	$tipo=$rowCONSULTA['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgclasif">Tallas</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgtallas&id='.$id.'" class="color-red">'.$tipo.'</a></li>
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
			<div class="uk-container uk-container-xsmall">
				<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
					<thead>
						<tr>
							<th width="auto">Talla</th>
							<th width="10px"></th>
						</tr>
					</thead>
					<tbody class="sortable" data-tabla="productostalla">';
					// Obtener tipos
					$CONSULTA = $CONEXION -> query("SELECT * FROM productostalla WHERE tipo = '$tipo' ORDER BY orden");
					while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
						$thisID=$rowCONSULTA['id'];

						echo '
						<tr id="'.$thisID.'">
							<td>
								<input class="editarajax uk-input uk-form-blank" type="text" data-tabla="productostalla" data-campo="txt" data-id="'.$thisID.'" value="'.$rowCONSULTA['txt'].'">
							</td>
							<td class="uk-text-nowrap">
								<button data-id="'.$thisID.'" data-tabla="productostalla" data-campo="talla" class="borrarexistencias uk-icon-button uk-button-danger" uk-icon="trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="#editar" uk-toggle data-id="'.$thisID.'" data-txt="'.$rowCONSULTA['txt'].'" data-tipo="'.$tipo.'" class="editar uk-icon-button uk-button-primary" uk-icon="pencil"></a>
							</td>
						</tr>';
					}
					echo '
					</tbody>
				</table>
			</div>
		</div>';


// VENTANAS MODALES 
	// NUEVO
		echo '
		<div id="add" uk-modal class="modal">
			<div class="uk-modal-dialog uk-modal-body">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h4>Nueva talla</h4>
				<form action="index.php" method="get">
					<input type="hidden" name="nuevatalla" value="1">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="subseccion" value="'.$subseccion.'">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="tipo" value="'.$tipo.'">

					<div class="uk-margin ">
						<input type="text" name="txt" class="uk-input uk-text-uppercase" required>
					</div>
					<div class="uk-margin uk-text-center">
						<a class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</a>
						<button class="uk-button uk-button-primary uk-button-large">Agregar</button>
					</div>
				</form>
			</div>
		</div>';

	// EDITAR
		echo '
		<div id="editar" uk-modal class="modal">
			<div class="uk-modal-dialog uk-modal-body">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<h4>Editar talla</h4>
				<form action="index.php" method="get">
					<input type="hidden" name="editartalla" value="1">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="subseccion" value="'.$subseccion.'">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="tallaid" id="tallaid">

					<div class="uk-margin ">
						<input id="tallatxt" type="text" name="txt" class="uk-input uk-text-uppercase" placeholder="Editar talla" required>
					</div>
					<div class="uk-margin uk-text-center">
						<a class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</a>
						<button class="uk-button uk-button-primary uk-button-large">Agregar</button>
					</div>
				</form>
			</div>
		</div>';


$scripts='
	// Eliminar existencias
		$(".borrarexistencias").click(function(){
			var id = $(this).attr("data-id");
			var tabla = $(this).attr("data-tabla");
			var campo = $(this).attr("data-campo");
			UIkit.modal.confirm("Se eliminará esta talla y todas sus existencias").then(function() {
				var statusConfirm = confirm("Esta operación no se puede deshacer. Está seguro?"); 
				if (statusConfirm == true){
					window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&eliminargeneral=1&eliminarexistencias=1&tabla="+tabla+"&campo="+campo+"&id="+id);
				}
			}, function () {
			    console.log("Rejected.")
			});
		});	

	// Asignar valores a la ventana de editar
		$(".editar").click(function(){
			var id = $(this).attr("data-id");
			$("#tallaid").val(id);
			
			var txt = $(this).attr("data-txt");
			$("#tallatxt").val(txt);

			var tipo = $(this).attr("data-tipo");
			$(".tallaoption").attr("selected",false);
			$("#talla"+tipo).attr("selected","selected");
		});


	';










