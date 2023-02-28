<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>
<?php
		$consultaInicio = $CONEXION -> query("SELECT * FROM inicio 	WHERE id = 1");
		$inicioRow = $consultaInicio -> fetch_assoc();

	
	/// ingles y español
	if ($languaje == 'es') {
		$btnTodos = 'Todos';
	    $bottonText = 'Ver detalles';
	  	$lng="";
	  	$filterText="FILTROS";
	  	$mayor="PRECIO MAYOR";
	 	$menor="PRECIO MENOR";
	 	$warningText = "Lo sentimos no hay productos de esta categoría.";
	    
	}elseif ($languaje == 'en') {
	    $btnTodos = 'All';
	    $bottonText = 'See more';
	 	$lng="_en";
	 	$filterText="FILTERS";
	 	
	 	$mayor="HIGHER PRICE";
	 	$menor="LOWER PRICE";
	 	$warningText = "There are no products in this category.";
	}

	if (isset($_SESSION['search'])) {
		$filtro =$_SESSION['search'];
		unset($_SESSION['search']);
		
	}

		//FILTROS
	if (isset($_SESSION['odenarpor'])) {
		$orderBy=$_SESSION['odenarpor'];
		unset($_SESSION['odenarpor']);
	}

	//Tipo
	if (isset($_SESSION['tipo'])) {
		$tipo=$_SESSION['tipo'];
		unset($_SESSION['tipo']);
	}

	$CONSULTATIPO = $CONEXION -> query("SHOW COLUMNS FROM productos WHERE field = 'tipo'");
	$row_CONSULTATIPO = $CONSULTATIPO -> fetch_assoc();

	$productos = array();
	$categorias = array();

	$consultaCats = $CONEXION -> query("SELECT * from productoscat WHERE parent = 0");
	 while($cat_row = $consultaCats -> fetch_assoc()){
	 	$parentId =  $cat_row['id'];
	 	$subCategorias =array();
	 	$consultaSubcats = $CONEXION -> query("SELECT * from productoscat WHERE parent = $parentId");
	 	while ($subCat = $consultaSubcats -> fetch_assoc()) {
	 		array_push($subCategorias,$subCat);
	 	}
	 	$cat_row['subcategorias']=$subCategorias;
	 	array_push($categorias, $cat_row);

	}

	

	if(isset($id)){
		//debug($tipo);
		//CONSULTA DE PRODUCTOS POR CATEGORIA
		$consultaProdByCat = $CONEXION -> query("SELECT id FROM productoscat WHERE parent = $id or id=$id");
		// si hay filtro de orden de precio
		while ($rowConsultaProdByCat = $consultaProdByCat -> fetch_assoc() ){	
			$subId = $rowConsultaProdByCat['id'];

			$sql="SELECT * FROM productos WHERE estatus = 1 AND categoria = $subId";
			if(isset($tipo)){
				$sql .= " AND tipo = '$tipo'";
			}

			$sql .= " ORDER BY titulo";
			$consultaProductos = $CONEXION -> query($sql);

			while($products_row = $consultaProductos -> fetch_assoc()){

					$producID =$products_row['id'];
							$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
							$row_Img = $consultaPic -> fetch_assoc();

							$products_row['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";
							
					
					$consultaCat = $CONEXION -> query("
						SELECT  p.id as productoId,p.categoria,pe.id as prodExistenciasId,p.tipo,pe.precio
						FROM productos p
						JOIN productosexistencias pe
						ON p.id = pe.producto 
						WHERE p.id = $producID AND pe.precio > 0
						ORDER BY pe.id ASC
						LIMIT 1;
					");

					$rowConsultaCat = $consultaCat -> fetch_assoc();

					
					$products_row['precio_sinformato']=$rowConsultaCat['precio'];				
					$products_row['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";

					array_push($productos,$products_row);		
			}
			
		}
	}else{
		//CONSULTA DE PRODUCTOS SIN FILTROS
		$sql="SELECT * FROM productos WHERE estatus = 1 AND tienda = 1";
		if(isset($tipo)){
			$sql .= " AND tipo = '$tipo'";
		}

		$sql .= " ORDER BY titulo";

		$consultaProductos = $CONEXION -> query($sql);
		while($products_row = $consultaProductos -> fetch_assoc()){

				$producID =$products_row['id'];
						$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
						$row_Img = $consultaPic -> fetch_assoc();

						$products_row['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";
						
				
				$consultaCat = $CONEXION -> query("
					SELECT  p.id as productoId,p.categoria,pe.id as prodExistenciasId,p.tipo,pe.precio
					FROM productos p
					JOIN productosexistencias pe
					ON p.id = pe.producto 
					WHERE p.id = $producID AND pe.precio > 0
					LIMIT 1;
				");

				$rowConsultaCat = $consultaCat -> fetch_assoc();
				$products_row['precio_sinformato']=$rowConsultaCat['precio'];
				$products_row['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";

				array_push($productos,$products_row);
		}
	}

	if (isset($orderBy)){

		$price = array_column($productos, 'precio_sinformato');
		
		if($orderBy == 'DESC')
		array_multisort($price, SORT_DESC,SORT_NUMERIC, $productos);
		else
		array_multisort($price, SORT_ASC,SORT_NUMERIC, $productos);
	}
	
?>
<div class="uk-container uk-container-large padding-top-10 uk-visible@m" style="min-height: 20vh">
	<div style="margin-left: 0" uk-grid>
		<?php
			$index = 4;
			foreach(explode("','",substr($row_CONSULTATIPO['Type'],6,-2)) as $option):
				if($languaje == 'en'){
					if($option == 'Hombres'){
						$option = 'Mens';
					}
					if($option == 'Mujeres'){
						$option = 'Womens';
					}
					if($option == 'Accesorios'){
						$option = 'Accesories';
					}
				}
		?>
		<div class="uk-width-1-3@m uk-padding-remove">
			<div class="uk-cover-container uk-transition-toggle" style="height: 120px"  tabindex="0">
				
				<div class="uk-flex uk-flex-center uk-flex-middle" uk-cover>
					<div class="text-xxl uk-text-uppercase filtros-letras text-dark">
						<?= $option?>
					</div>
				</div>
			    <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-default filtrotipo" data-tipo="<?= $option ?>" style="padding: 0;margin: 0;cursor: pointer;">
				    	 <img src="../img/contenido/varios/<?=$inicioRow['imagen'.$index]?>" uk-cover> 
				    	 <div class="uk-flex uk-flex-center uk-flex-middle" uk-cover>
							<div class="text-xxl color-blanco uk-text-uppercase filtros-letras">
								<span>►</span> <?= $option ?> <span>◄</span>
							</div>
						</div> 
	            </div>
			</div>
		</div>
		<?php 
		$index ++;
		endforeach  ?>
		<!--div class="uk-width-1-1@m uk-padding-remove uk-margin-small-top">
			<div class="uk-catMenu">
				<nav class="uk-navbar-container uk-navbar-transparent submenu-active" uk-navbar>
					<div class="uk-navbar-center">
						<ul class="uk-navbar-nav">
							<?php for ($i=0; $i < sizeof($categorias); $i++):
							 ?>	
							 	<li class="text-11 padding-h-20"><a href="<?= $categorias[$i]['id'].'_'.$categorias[$i]['txt'.$lng].'_productos'?>"><?= $categorias[$i]['txt'.$lng] ?></a></li>							
							<?php endfor  ?>			
						</ul>
					</div>
				</nav>
			</div>
		</div-->
	</div>
</div>
<div class="uk-container uk-container-large">
	<div uk-grid style="margin-left: 0">
		<!-- SECCION DE FILTROS LAT IZQ-->
		<div class="uk-width-1-5@m uk-padding-small uk-sticky">
			<div class="uk-cover-container uk-margin-top uk-visible@m">
			    <img data-src="../img/design/logo.png" width="450" height="180" alt="" uk-img>
			</div>
			<div class="uk-padding-small">
		    	<div class="custom-search uk-flex uk-flex-right uk-flex-middle">
		        	<input class="uk-search-input search" type="search" placeholder="Search...">
		    		<span class="uk-search-icon-flip" uk-search-icon></span>
		    	</div>
			</div>
			<!--CATEGORIAS LATERAL IZQ-->
			<div class="uk-padding">
				<ul class="uk-nav uk-nav-parent-icon text-8" uk-nav>
					<?php foreach ($categorias as $index => $value): 
					
					?>
			        <li class="uk-parent">
			        	<a class="uk-text-uppercase color-grisaceo negritas" href="<?= $value['id'].'_'.$value['txt'.$lng].'_productos'?>"><?=$value['txt'.$lng] ?></a>
			        	<ul class="uk-nav-sub">
							<li class="uk-text-uppercase color-grisaceo"><a href="<?= $value['id'].'_'.$value['txt'.$lng].'_producto'?>" style="text-color: black;"><?=$btnTodos?></a></li>
							<li class="uk-text-uppercase color-grisaceo"><a class="uk-text-uppercase color-grisaceo" href="">Todos</a></li>
			        		<?php  foreach ($value['subcategorias'] as $key => $val):  ?>
				       			<li><a class="uk-text-uppercase color-grisaceo" href="<?=$val['id'].'_'.$val['txt'.$lng].'_productos' ?>"><?= $val['txt'.$lng] ?></a></li>
				       		<?php endforeach ?>
		       			</ul>
		       		 </li>	
		       		<?php endforeach?>
			     </ul>
			</div>
			<!-- FILTROS-->
			<div class="uk-padding-small text-8	">
				<p style="border-bottom: 2px solid"><?php $filterText  ?></p>
				<p><label><input class="uk-checkbox check-precio" type="checkbox" value="1"><?= $mayor ?> </label></p>	
				<p><label><input class="uk-checkbox check-precio" type="checkbox" value="0"> <?= $menor ?></label></p>
				<!--p><label><input class="uk-checkbox" type="checkbox"> COLOR</label></p>
				<p><label><input class="uk-checkbox" type="checkbox"> TALLA</label></p-->
			</div>
		</div>
		<!-- SECCION DE PRODUCTOS-->
		<div class="uk-width-4-5@m">
			<div class="uk-child-width-1-4@m" uk-grid>
				<?php ;
					
					for ($i=0; $i < sizeof($productos) ; $i++):
				 ?>
				<div class="uk-padding-small">
					<div class="uk-card uk-card-default uk-transition-toggle">
						<a href="<?= $productos[$i]['id'].'_'.$productos[$i]['titulo'].'_item'?>">
			            <div class="uk-card-media-top uk-flex uk-flex-center uk-padding-small">
			            	<div class="uk-cover-container" style="width:200px; height: 220px;padding: 22px">
			            		 <img src="<?= $productos[$i]['img'] ?>" alt="" uk-cover>
			            	</div>
			            </div>
						
				             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
			            		
			            		<p class="uk-text-uppercase color-primary"><?= $bottonText ?></p>
			            		<hr class="uk-divider-small">
			            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

				            </div>
						
			            <div class="uk-card-body uk-text-center padding-10 text-dark">
		            	 	<hr class="uk-divider-small">
		            		<p class="uk-text-uppercase negritas"><?= $productos[$i]['titulo'] ?></p>
		                	<p> <?= $productos[$i]['precio'] ?></p>
			            </div>
			        	</a>
			        </div>
				</div>
				<?php endfor ?>
				
			</div>
			<?php if(!sizeof($productos)): ?>
					
					<div class="uk-alert-danger uk-padding-large uk-text-center" uk-alert>
					    
					    <p><?= $warningText  ?></p>
					
					</div>
					
			<?php endif ?>
		</div>
	</div>
</div>

<?=$footer?>
<script>
	$(".check-precio").change(function(){
		var orden = $(this).val();
		console.log(orden);
		if(orden > 0){
			var ordenarpor = 'DESC';
		}else{
			var ordenarpor = 'ASC';
		}

		$.ajax({
	      method: "POST",
	      url: "../includes/acciones.php",
	      data: { 
	        odenarpor: ordenarpor
	      }
	    })
	    .done(function() {
	      location.reload();
	    });
	 
	});

	$(".filtrotipo").click(function(){
		var tipo = $(this).data("tipo");
		console.log("tipo",tipo);
		$.ajax({
	      method: "POST",
	      url: "../includes/acciones.php",
	      data: { 
	        tipo: tipo
	      }
	    })
	    .done(function() {
	      location.reload();
	    });
	});

</script>

<?=$scriptGNRL?>

</body>
</html>