<?php 
	$pag=(isset($_GET['pag']))?$_GET['pag']:0;
	$prodspagina=(isset($_GET['prodspagina']))?$_GET['prodspagina']:20;
	$consulta = $CONEXION -> query("SELECT * FROM $seccion");

	$numItems=$consulta->num_rows;
	$prodInicial=$pag*$prodspagina;

// BREADCRUMB
	echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'" class="color-red">Productos &nbsp; <span class="uk-text-muted uk-text-lowercase"> &nbsp; <b>'.$numItems.'</b> productos</span></a></li>
		</ul>
	</div>';


// BOTONES SUPERIORES
	echo '
	<div class="uk-width-expand@m margin-v-20">
		<div uk-grid class="uk-grid-small uk-flex-right">
			<div>
				<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgclasif" class="uk-button uk-button-white">Tallas</a>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=cfgcolores" class="uk-button uk-button-white">Colores</a>
			</div>			
			<div>
				<!-- Categorías -->
					<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=categorias" class="uk-button uk-button-primary"><i uk-icon="folder"></i> &nbsp; Líneas</a>
					<div uk-dropdown>
						<ul class="uk-nav uk-dropdown-nav uk-text-left">';
						// Obtener Categorías
						$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE parent = 0 ORDER BY orden");
						while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
							echo '
							<li><a href="index.php?rand='.rand(1,999).'&seccion='.$seccion.'&subseccion=catdetalle&cat='.$rowCONSULTA['id'].'">'.$rowCONSULTA['txt'].'</a></li>';
						}
						echo '
						</ul>
					</div>
			</div>
			<div>
				<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=nuevo" class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo</a>
			</div>
		</div>
	</div>';


// CAMPOS DE BÚSQUEDA 
	echo '
	<div class="uk-width-1-1">
		<div class="uk-container">
			<div uk-grid class="uk-grid-small uk-child-width-expand@m uk-child-width-1-2">
				<div><label class="pointer"><i uk-icon="search"></i> SKU<br><input type="text" class="uk-input search" data-campo="sku"></label></div>
				<div><label class="pointer"><i uk-icon="search"></i> Modelo<br><input type="text" class="uk-input search" data-campo="titulo"></label></div>
				<div><label class="pointer"><i uk-icon="search"></i> Tipo de piel<br><input type="text" class="uk-input search" data-campo="material"></label></div>
			</div>
		</div>
	</div>';


// TABLA DE PRODUCTOS 
	echo '
	<div class="uk-width-1-1 margin-v-50">
		<div class="uk-container">
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
				<thead>
					<tr class="uk-text-muted">
						<th width="40px" ></th>
						<th width="10px" >SKU</th>
						<th width="auto" >Modelo</th>
						<th width="50px" class="uk-text-nowrap">Tipo de piel</th>
						<th width="50px" class="uk-text-center">En inicio</th>
						<th width="50px" class="uk-text-center">En tienda</th>
						<th width="50px" >Activo</th>
						<th width="10px"></th>
					</tr>
				</thead>
				<tbody>';

				$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion ORDER BY titulo LIMIT $prodInicial,$prodspagina");
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					$prodID=$rowCONSULTA['id'];
					$catId=$rowCONSULTA['categoria'];
					$clasifId=$rowCONSULTA['clasif'];

					$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=detalle&id='.$rowCONSULTA['id'];

					$clasePrecio='';
					$claseDescuento='';
					// Si el precio es 0 pintamos gris
					if ($rowCONSULTA['precio']==0) {
						$clasePrecio='bg-grey';
						$claseDescuento='bg-grey';
					}

					$inicioIcon=($rowCONSULTA['inicio']==0)?'off uk-text-muted':'on uk-text-primary';
					$estatusIcon=($rowCONSULTA['estatus']==0)?'off uk-text-muted':'on uk-text-primary';
					$tiendaIcon=($rowCONSULTA['tienda']==0)?'off uk-text-muted':'on uk-text-primary';

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

					$CONSULTA1 = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $catId");
					$rowCONSULTA1 = $CONSULTA1 -> fetch_assoc();
					$categoriaTxt=$rowCONSULTA1['txt'];
					$parent=$rowCONSULTA1['parent'];

					echo '
					<tr>
						<td class="uk-text-nowrap">
							'.$picROW.'
						</td>
						<td class="uk-text-nowrap">
							'.$rowCONSULTA['sku'].'
						</td>
						<td class="uk-text-truncate">
							'.$rowCONSULTA['titulo'].'
						</td>
						<td class="uk-text-wrap">
							'.$rowCONSULTA['material'].'
						</td>
						<td class="uk-text-center@m">
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$inicioIcon.'" data-tabla="'.$seccion.'" data-campo="inicio" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['inicio'].'"></i> &nbsp;&nbsp;
						</td>
						<td class="uk-text-center@m">
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="'.$seccion.'" data-campo="estatus" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['estatus'].'"></i> &nbsp;&nbsp;
						</td>
						<td class="uk-text-center@m">
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$tiendaIcon.'" data-tabla="'.$seccion.'" data-campo="tienda" data-id="'.$rowCONSULTA['id'].'" data-valor="'.$rowCONSULTA['tienda'].'"></i> &nbsp;&nbsp;
						</td>
						<td class="uk-text-nowrap">
							<button data-id="'.$rowCONSULTA['id'].'" class="eliminaprod uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="'.$link.'" class="uk-icon-button uk-button-primary"><i class="fa fa-search-plus"></i></a>
						</td>
					</tr>';
				}
				echo '
				</tbody>
			</table>
		</div>
	</div>';


// PAGINATION 
	echo '
	<div class="uk-width-1-1 padding-top-50">
		<div class="uk-flex uk-flex-center">
			<ul class="uk-pagination uk-flex-center uk-text-center">';
				if ($pag!=0) {
					$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&pag='.($pag-1).'&prodspagina='.$prodspagina;
					echo'
					<li><a href="'.$link.'"><i class="fa fa-lg fa-angle-left"></i> &nbsp;&nbsp; Anterior</a></li>';
				}
				$pagTotal=intval($numItems/$prodspagina);
				$modulo=$numItems % $prodspagina;
				if (($modulo) == 0){
					$pagTotal=($numItems/$prodspagina)-1;
				}
				for ($i=0; $i <= $pagTotal; $i++) { 
					$clase='';
					if ($pag==$i) {
						$clase='uk-badge bg-primary color-white';
					}
					$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&pag='.($i).'&prodspagina='.$prodspagina;
					echo '<li><a href="'.$link.'" class="'.$clase.'">'.($i+1).'</a></li>';
				}
				if ($pag!=$pagTotal AND $numItems!=0) {
					$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&pag='.($pag+1).'&prodspagina='.$prodspagina;
					echo'
					<li><a href="'.$link.'">Siguiente &nbsp;&nbsp; <i class="fa fa-lg fa-angle-right"></i></a></li>';
				}
				echo '
			</ul>
		</div>
		<div class="uk-flex uk-flex-center">
			<div style="max-width: 100%;width: 120px;">
				<select name="prodspagina" data-placeholder="Productos por página" id="prodspagina" class="uk-select">';
					$arreglo = array(5=>5,20=>20,50=>50,100=>100,500=>500,9999=>"Todos");
					foreach ($arreglo as $key => $value) {
						$checked='';
						if ($key==$prodspagina) {
							$checked='selected';
						}
						echo '
						<option value="'.$key.'" '.$checked.'>'.$value.'</option>';
					}
					echo '
				</select>
			</div>
		</div>
	</div>';


$scripts='
	// Eliminar producto
		$(".eliminaprod").click(function() {
			var id = $(this).attr(\'data-id\');
			//console.log(id);
			var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
			if (statusConfirm == true) { 
				window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarPod&id="+id);
			} 
		});

	// Productos por página
		$("#prodspagina").change(function(){
			var prodspagina = $(this).val();
			window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'&prodspagina="+prodspagina);
		})

	// Búsqueda
		$(".search").keypress(function(e) {
			if(e.which == 13) {
				var campo = $(this).attr("data-campo");
				var valor = $(this).val();
				window.location = ("index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=search&campo="+campo+"&valor="+valor);
			}
		});

	';

