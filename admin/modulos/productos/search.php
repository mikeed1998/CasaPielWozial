<?php 
$campo=$_GET['campo'];
$valor=$_GET['valor'];

$consulta = $CONEXION -> query("SELECT * FROM $seccion WHERE $campo LIKE '%$valor%' ORDER BY $campo");
$numItems=$consulta->num_rows;

echo '
<div class="uk-width-auto margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&campo='.$campo.'&valor='.$valor.'" class="color-red">Buscar '.$valor.' &nbsp; <span class="uk-text-muted uk-text-lowercase"> &nbsp; <b>'.$numItems.'</b> productos</span></a></li>
	</ul>
</div>

<div class="uk-width-expan@m">
	<div class="uk-container">
		<div uk-grid class="uk-grid-small uk-child-width-expand@m uk-child-width-1-2">
			<div><label class="pointer"><i uk-icon="search"></i> SKU<br><input type="text" class="uk-input search" data-campo="sku"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Modelo<br><input type="text" class="uk-input search" data-campo="titulo"></label></div>
			<div><label class="pointer"><i uk-icon="search"></i> Tipo de piel<br><input type="text" class="uk-input search" data-campo="material"></label></div>
		</div>
	</div>
</div>

<div class="uk-width-1-1">
	<div class="uk-container">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
			<thead>
				<tr class="uk-text-muted">
					<th width="40px"></th>
					<th width="10px"  class="pointer" onclick="sortTable(1)">SKU</th>
					<th width="auto"  class="pointer" onclick="sortTable(2)">Modelo</th>
					<th width="10px"  class="pointer" onclick="sortTable(3)">Tipo de piel</th>
					<th width="10px"  class="pointer" onclick="sortTable(6)">En inicio</th>
					<th width="10px"  class="pointer" onclick="sortTable(7)">Activo</th>
					<th width="10px"></th>
				</tr>
			</thead>
			<tbody id="conetent">';

			while ($rowCONSULTA = $consulta -> fetch_assoc()) {
				$prodID=$rowCONSULTA['id'];
				$catId=$rowCONSULTA['categoria'];

				$CONSULTA4 = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $catId");
				$row_CONSULTA4 = $CONSULTA4 -> fetch_assoc();
				$categoriaTxt=$row_CONSULTA4['txt'];
				$parent=$row_CONSULTA4['parent'];

				$CONSULTA5 = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $parent");
				$row_CONSULTA5 = $CONSULTA5 -> fetch_assoc();
				$marcaTxt=$row_CONSULTA5['txt'];

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


				$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=detalle&id='.$rowCONSULTA['id'];

				$inicioIcon=($rowCONSULTA['inicio']==0)?'off uk-text-muted':'on uk-text-primary';
				$estatusIcon=($rowCONSULTA['estatus']==0)?'off uk-text-muted':'on uk-text-primary';

				echo '
				<tr id="'.$prodID.'">
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
					<td class="uk-text-center@m">
						<i class="estatuschange pointer fas fa-lg fa-toggle-'.$inicioIcon.'" data-tabla="'.$seccion.'" data-campo="inicio" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['inicio'].'"></i> &nbsp;&nbsp;
					</td>
					<td class="uk-text-center@m">
						<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="'.$seccion.'" data-campo="estatus" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['estatus'].'"></i> &nbsp;&nbsp;
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
</div>';


$scripts='
	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		//console.log(id);
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			//window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&campo='.$campo.'&valor='.$valor.'&borrarPod&id="+id);
		} 
	});

	$(".search").keypress(function(e) {
		if(e.which == 13) {
			var campo = $(this).attr("data-campo");
			var valor = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=search&campo="+campo+"&valor="+valor);
		}
	});
	';


