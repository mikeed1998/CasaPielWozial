	<!DOCTYPE html>
	<?=$headGNRL?>
	<body>
	<?php  
		$consulta1 = $CONEXION -> query("SELECT * FROM productos WHERE (estatus = 1 AND inicio = 1) AND tipo = 'Hombres' ");

		$consulta2 = $CONEXION -> query("SELECT * FROM productos WHERE (estatus = 1 AND inicio = 1) AND tipo = 'Mujeres' ");

		$consultaInicio = $CONEXION -> query("SELECT * FROM inicio 	WHERE id = 1");
		$inicioRow = $consultaInicio -> fetch_assoc();

		$imgMen = $inicioRow['imagen1'];
		$imgWomen = $inicioRow['imagen2'];

		if ($languaje == 'es') {
		   
		    $bottonText = 'Ver detalles';
		    $linkText = "Ver más productos";
		    $manText = $inicioRow['texto1'];
			$womanText = $inicioRow['texto2'];
		    
		}elseif ($languaje == 'en') {
		    
		    $bottonText = 'See more';
		  	$linkText = "See more products";
		  	$manText = $inicioRow['texto3'];
			$womanText = $inicioRow['texto4'];
		}

		$cone = $CONEXION->query("SELECT id FROM pedidost WHERE openpay = 0");
		while($row = $cone->fetch_assoc()) {
			$aux = $row['id'];
			$subcone = $CONEXION->query("DELETE FROM pedidosdetallet WHERE pedido = $aux");
		}

		$eliminar = $CONEXION->query("DELETE FROM pedidost WHERE openpay = 0");
		
	?>  
	<?=$header?>

	<div class="uk-container uk-container-large padding-top-10">
		<?=carousel('carousel')?>
		<!--div class="margin-left-0" uk-grid>
			<div class="uk-width-1-2@m"></div>
			<div class="uk-width-1-2@m">
				<div uk-slider style="width:100%;border: solid;">
					<div class="uk-position-relative uk-visible-toggle uk-dark aling-center" tabindex="-1" uk-slider style="height:450px;width:450px;">
					    <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-1@s uk-child-width-1-1@m  aling-center" style="margin:0 2em">
					    <?php 
					    	for($i=0; $i <6 ; $i++):
					    ?>
					    	<li class="uk-margins-right">
								<div class="uk-padding">
									<div class="uk-card uk-card-default uk-transition-toggle" style="border: 1px solid #7c573a;margin-right: 20px;">
							            <div class="uk-card-media-top uk-flex uk-flex-center">
							            	<div class="uk-cover-container" style="width:200px; height: 220px">
							            		 <img src="../img/design/chamarra.png" alt="" uk-cover>
							            	</div>
							            </div>
										<a href="1_chamarra_item">
								             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
							            		
							            		<p class="uk-text-uppercase">Ver detalles</p>
							            		<hr class="uk-divider-small">
							            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

								            </div>
										</a>
							            <div class="uk-card-body uk-text-center padding-10">
						            	 	<hr class="uk-divider-small">
						            		<p class="uk-text-uppercase">Chamarra de piel</p>
						                	<p>$4500 MX</p>
							            </div>
							        </div>
								</div>
							</li>
						<?php endfor  ?>

						</ul>
					    <div class="uk-flex uk-flex-center uk-flex-middle margin-top-10">   
			                
			                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
			                
			            </div>
					</div>
				</div>
			</div>
	
		</div-->
	</div>

	<div class="uk-container uk-container-large uk-margin-top">
		<div uk-grid style="margin-left:0;">
			<!--seccion de categorias-->
			<div class="uk-width-2-3@m uk-margin-top">
				<div class="text-xxxl color-primary uk-text-center">
					WOMAN NEW IN
				</div>
				<div class="text-8 uk-margin-small-top" uk-grid>
					<!--SLAIDER PRODUCTOS MUJERES-->
					<div class="remove-padding" uk-slider style="width:100%;">
						<div class="uk-position-relative uk-visible-toggle uk-dark aling-center" tabindex="-1" uk-slider style="height:380px;">
						    <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m  aling-center nomargin">
						    <?php 
						    	while($productosM = $consulta2 -> fetch_assoc()):

									$producID =$productosM['id'];
									$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
									$row_Img = $consultaPic -> fetch_assoc();

									$productosM['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";
										
									$consultaCat = $CONEXION -> query("
										SELECT  *
										FROM productosexistencias
										WHERE producto = $producID AND precio > 0
										LIMIT 1;
									");

									$rowConsultaCat = $consultaCat -> fetch_assoc();

									$productosM['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";
						    ?>
						    	<li class="uk-margin-small-right">
									<div class="uk-padding-small">
										<div class="uk-card uk-card-default uk-transition-toggle">
											<a href="<?= $productosM['id'].'_'.$productosM['titulo'].'_item'?>">
								            <div class="uk-card-media-top uk-flex uk-flex-center">
								            	<div class="uk-cover-container" style="width:200px; height: 220px">
								            		 <img src="<?= $productosM['img'] ?>" alt="" uk-cover>
								            	</div>
								            </div>
											
									             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
								            		
								            		<p class="uk-text-uppercase"> <?= $bottonText ?> </p>
								            		<hr class="uk-divider-small">
								            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

									            </div>
										
								            <div class="uk-card-body uk-text-center color-primary padding-10">
							            	 	<hr class="uk-divider-small">
							            		<p class="uk-text-uppercase negritas"><?= $productosM['titulo'] ?></p>
							                	<p><?= $productosM['precio'] ?></p>
								            </div>
								        	</a>
								        </div>
									</div>
								</li>
							<?php endwhile  ?>

							</ul>
						    <div class="uk-flex uk-flex-center uk-flex-middle margin-top-10">   
				                
				                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
				                
				            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-3@m">
				<div uk-grid>
					<div class="uk-width-1-1 uk-cover-container " style="height: 340px;">
		            	 <img src="../img/contenido/varios/<?= $imgWomen  ?>"	 alt="" uk-cover>
					</div>
					<div class="uk-width-1-3 uk-padding-remove">
						<div class="text-8">
							FASHION MOMENTS
						</div>
					</div>
					<div class="uk-width-2-3 uk-flex uk-flex-middle uk-padding-remove"	>
						<div class="larger-line-black"></div>
					</div>
					<div class="uk-width-1-1@m uk-width-1-1@xl uk-padding-remove-left uk-margin-small-top">
						<div class="text-8">
							<?= $womanText  ?>
						</div>
						
					</div>
				</div>
			</div>
			<div class="uk-width-1-5@m">
				<div class="text-9 uk-text-center uk-text-uppercase boton-vermas">
					<a href="productos"><?= $linkText  ?></a>
				</div>
			</div>
			<div class="uk-width-4-5@m uk-flex uk-flex-middle">
				<div class="larger-line-black"></div>
			</div>
		</div>
	</div>

	<div class="uk-container uk-container-large uk-margin-top uk-margin-small-bottom">
		<div uk-grid style="margin-left:0;">
			<!--seccion de categorias-->
			<div class="uk-width-2-3@m uk-margin-top">
				<div class="text-xxxl color-primary uk-text-center">
					MAN NEW IN
				</div>
				<div class="text-8 uk-margin-small-top" uk-grid>
					<!--SLAIDER PRODUCTOS HOMBRES-->
					<div class="remove-padding" uk-slider="autoplay:false;" style="width:100%;">
						<div class="uk-position-relative uk-visible-toggle uk-dark aling-center" tabindex="-1" uk-slider style="height:380px;">
						    <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m  aling-center nomargin" style="margin:0 2em">
						    <?php 
						    	while($productosH = $consulta1 -> fetch_assoc()):

									$producID =$productosH['id'];
									$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
									$row_Img = $consultaPic -> fetch_assoc();

									$productosH['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";
									

									$consultaCat = $CONEXION -> query("
										SELECT  *
										FROM productosexistencias
										WHERE producto = $producID AND precio > 0
										LIMIT 1;
									");

									$rowConsultaCat = $consultaCat -> fetch_assoc();

									$productosH['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";
						    ?>
						    	<li class="uk-margin-small-right">
									<div class="uk-padding-small">
										<div class="uk-card uk-card-default uk-transition-toggle">
											<a href="<?= $productosH['id'].'_'.$productosH['titulo'].'_item'?>">
								            <div class="uk-card-media-top uk-flex uk-flex-center">

								            	<div class="uk-cover-container" style="width:200px; height: 220px">
								            		 <img src="<?= $productosH['img']  ?>" alt="" uk-cover>
								            	</div>
								            </div>
											
									             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
								            		
								            		<p class="uk-text-uppercase color-primary"><?= $bottonText ?></p>
								            		<hr class="uk-divider-small">
								            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

									            </div>
											
								            <div class="uk-card-body uk-text-center color-primary padding-10">
							            	 	<hr class="uk-divider-small">
							            		<p class="uk-text-uppercase negritas"><?= $productosH['titulo']  ?></p>
							                	<p><?= $productosH['precio']  ?></p>
								            </div>
								            </a>
								        </div>
									</div>
								</li>
							<?php endwhile  ?>

							</ul>
						    <div class="uk-flex uk-flex-center uk-flex-middle margin-top-10">   
				                
				                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
				                
				            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-3@m">
				<div uk-grid>
					<div class="uk-width-1-1 uk-cover-container " style="height: 340px;">
		            	 <img src="../img/contenido/varios/<?= $imgMen  ?>"	 alt="" uk-cover>
					</div>
					<div class="uk-width-1-3 uk-padding-remove">
						<div class="text-8">
							FASHION MOMENTS
						</div>
					</div>
					<div class="uk-width-2-3 uk-flex uk-flex-middle uk-padding-remove"	>
						<div class="larger-line-black"></div>
					</div>
					<div class="uk-width-1-1@m uk-width-1-1@xl uk-padding-remove-left uk-margin-small-top">
						<div class="text-8">
							<?= $manText  ?>
						</div>
						
					</div>
				</div>
			</div>
			<div class="uk-width-1-5@m">
				<div class="text-9 uk-text-center uk-text-uppercase boton-vermas">
					<a class="" href="productos"><?= $linkText  ?></a>
				</div>
			</div>
			<div class="uk-width-4-5@m uk-flex uk-flex-middle">
				<div class="larger-line-black"></div>
			</div>
		</div>
	</div>


	<?=$footer?>

	<?=$scriptGNRL?>

	</body>
	</html>