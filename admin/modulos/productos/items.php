<?php
	$CATEGORIAS = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $cat");
	$row_CATEGORIAS = $CATEGORIAS -> fetch_assoc();
	$catNAME=$row_CATEGORIAS['txt'];
	$parent=$row_CATEGORIAS['parent'];
	$CATPARENT = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $parent");
	$row_CATPARENT = $CATPARENT -> fetch_assoc();
	$catParentName=$row_CATPARENT['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20 uk-text-left">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=categorias">Líneas</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=catdetalle&cat='.$parent.'">'.$catParentName.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=items&cat='.$cat.'" class="color-red">'.$catNAME.'</a></li>
		</ul>
	</div>
	';


// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<a href="index.php?rand='.rand(1,9999).'&seccion='.$seccion.'&subseccion=nuevo&cat='.$cat.'"" class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';


// TABLA DE INFORMACIÓN
	echo '
	<div class="uk-width-1-1 margin-v-50">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
				<thead>
					<tr class="uk-text-muted">
						<th width="40px"></th>
						<th class="pointer" onclick="sortTable(1)" width="10px">SKU</th>
						<th class="pointer" onclick="sortTable(2)" width="auto">Modelo</th>
						<th class="pointer" onclick="sortTable(3)" width="100px">Tipo de piel</th>
						<th width="10px"></th>
					</tr>
				</thead>
				<tbody>';
				$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE categoria = $cat ORDER BY sku");
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					$prodID=$rowCONSULTA['id'];

					$CONSULTA1 = $CONEXION -> query("SELECT * FROM $seccionpic WHERE producto = $prodID ORDER BY orden");
					$rowCONSULTA1 = $CONSULTA1 -> fetch_assoc();
					$picId=$rowCONSULTA1['id'];
					$picROW='';
					$pic=$rutaFinal.$picId.'-sm.jpg';
					if(file_exists($pic)){
						$picROW='
							<div class="uk-inline">
								<i uk-icon="camera"></i>
								<div uk-drop="pos: right-justify">
									<img uk-img data-src="'.$pic.'" class="uk-border-rounded">
								</div>
							</div>';
					}
					$link='index.php?seccion='.$seccion.'&subseccion=detalle&id='.$rowCONSULTA['id'];

					$estatusIcon=($rowCONSULTA['estatus']==1)?'off uk-text-muted':'on uk-text-primary';

					$clasePrecio='';
					$claseDescuento='';
					if ($rowCONSULTA['precio']==0) {
						$clasePrecio='bg-grey';
						$claseDescuento='bg-grey';
					}

					echo '
					<tr id="'.$rowCONSULTA['id'].'">
						<td class="uk-text-nowrap">
							'.$picROW.'
						</td>
						<td class="uk-text-nowrap">
							'.$rowCONSULTA['sku'].'
						</td>
						<td class="uk-text-truncate">
							'.$rowCONSULTA['titulo'].'
						</td>
						<td class="uk-text-nowrap">
							'.$rowCONSULTA['material'].'
						</td>
						<td class="uk-text-nowrap">
							<button data-id="'.$rowCONSULTA['id'].'" class="eliminaprod uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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


$scripts='
	// Eliminar producto
		$(".eliminaprod").click(function() {
			var id = $(this).attr(\'data-id\');
			//console.log(id);
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?seccion='.$seccion.'&subseccion=items&borrarPod&cat='.$cat.'&id="+id);
			} 
		});

	// Subir imagen 1
		$(document).ready(function() {
			$("#fileuploader").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				showDelete: \'false\',
				allowedTypes: "png,svg",
				maxFileSize: 6291456,
				showFileCounter: false,
				showPreview:false,
				returnType:\'json\',
				onSuccess:function(data){ 
					window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&cat='.$cat.'&position=cat&imagen=\'+data);
				}
			});

	// Subir imagen 2
			$("#fileuploaderhover").uploadFile({
				url:"../library/upload-file/php/upload.php",
				fileName:"myfile",
				maxFileCount:1,
				showDelete: \'false\',
				allowedTypes: "jpg,jpeg",
				maxFileSize: 6291456,
				showFileCounter: false,
				showPreview:false,
				returnType:\'json\',
				onSuccess:function(data){ 
					window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&cat='.$cat.'&position=cathover&imagen=\'+data);
				}
			});
		});

		';



