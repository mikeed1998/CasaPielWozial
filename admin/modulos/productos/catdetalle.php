<?php
	$Consulta = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $cat");
	$row_Consulta = $Consulta -> fetch_assoc();
	$catNAME=$row_Consulta['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=categorias">Líneas</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=catdetalle&cat='.$cat.'" class="color-red">'.$catNAME.'</a></li>
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


// TABLA DE SUBCATEGORÍAS
	echo '
	<div class="uk-width-1-1 margin-bottom-50">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
				<thead>
					<tr class="uk-text-muted">
						<th onclick="sortTable(0)" class="uk-text-left">Sublínea</th>
						<th onclick="sortTable(0)" class="uk-text-left">Sublínea Inglés</th>
						<th width="100px" onclick="sortTable(1)" class="uk-text-center">Productos</th>
						<th width="100px" ></th>
					</tr>
				</thead>
				<tbody class="sortable" data-tabla="'.$seccioncat.'">';
		// Obtener subcategorías
		$numeroProds=0;
		$subcatsNum=0;
		$productos_subcat = $CONEXION -> query("SELECT * FROM $seccioncat WHERE parent = $cat ORDER BY orden,txt");
		$numeroSubcats = $productos_subcat->num_rows;
		while ($row_productos_subcat = $productos_subcat -> fetch_assoc()) {
			$categoriaMENU=$row_productos_subcat['id'];
			$filas = $CONEXION -> query("SELECT * FROM $seccion WHERE categoria = '$categoriaMENU'");
			$numeroProdsThis = $filas->num_rows;
			$numeroProds+=$numeroProdsThis;
			$row_Filas = $filas -> fetch_assoc();
			$subcatsNum=$row_Filas;


			$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=items&cat='.$categoriaMENU;

			$borrarSubcat='<a href="javascript:eliminaCat(id='.$categoriaMENU.')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash"></a>';
			if ($numeroProdsThis>0) {
				$borrarSubcat='<a class="uk-icon-button uk-button-default" uk-tooltip title="No puede eliminar<br>Elimine antes su contenido" uk-icon="icon:trash"></a>';
			}
			echo '
					<tr id="'.$row_productos_subcat['id'].'">
						<td class="uk-text-left">
							<input type="text" value="'.$row_productos_subcat['txt'].'" class="editarajax uk-input uk-form-blank" data-tabla="'.$seccioncat.'" data-campo="txt" data-id="'.$row_productos_subcat['id'].'" tabindex="10">
						</td>
						<td class="uk-text-left">
							<input type="text" value="'.$row_productos_subcat['txt_en'].'" class="editarajax uk-input uk-form-blank" data-tabla="'.$seccioncat.'" data-campo="txt_en" data-id="'.$row_productos_subcat['id'].'" tabindex="10">
						</td>
						<td class="uk-text-center">
							'.$numeroProdsThis.'
						</td>
						<td class="uk-text-nowrap">
							'.$borrarSubcat.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="'.$link.'" class="uk-icon-button uk-button-primary"><i class="fa fa-search-plus"></i></a>
						</td>
					</tr>';
		}


		echo '
				</tbody>
			</table>
		</div>
	</div>
	';


// MODAL NUEVO
	echo '
	<div id="add" uk-modal="center: true" class="modal">
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<form action="index.php" class="uk-width-1-1 uk-text-center uk-form" method="post" name="editar" onsubmit="return checkForm(this);">

				<input type="hidden" name="nuevasubcategoria" value="1">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="subseccion" value="'.$subseccion.'">
				<input type="hidden" name="cat" value="'.$cat.'">

				<label for="categoria">Nombre de la sublínea</label><br><br>
				<input type="text" name="categoria" class="uk-input" required><br><br>
				<input type="text" name="categoriaEn" class="uk-input" required><br><br>
				<a class="uk-button uk-button-white uk-modal-close">Cerrar</a>
				<input type="submit" name="send" value="Agregar" class="uk-button uk-button-primary">
			</form>
		</div>
	</div>
	';


$scripts='
	// Eliminar
		function eliminaCat () { 
			var statusConfirm = confirm("Realmente desea eliminar esta categoria?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&eliminarCat&cat='.$cat.'&id="+id);
			} 
		};
		';

