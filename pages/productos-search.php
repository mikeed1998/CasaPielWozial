<!DOCTYPE html>
<?=$headGNRL?>
<body>  
<?=$header?>
<?php 
	$CONSULTA =$CONEXION ->query("SELECT * FROM productos 
		WHERE estatus = 1 AND (titulo LIKE '%$wordKey%' OR material LIKE '%$wordKey%' OR SKU LIKE'%$wordKey%')");

  	$numItems = $CONSULTA->num_rows;

 ?>
<div class="uk-container uk-container-large margin-v-10" style="min-height: 80vh;">
	<div class="uk-container margin-bottom-20">
		<h3 class="text-xxxl">Busqueda : <?=$wordKey ?> </h3>
		<?php if($numItems > 0):  ?>
		<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l margin-h-50 margin-v-20 padding-40 uk-grid-small" uk-grid>
			 <?php 
					while($products_row = $CONSULTA -> fetch_assoc()):

						$producID =$products_row['id'];
								$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
								$row_Img = $consultaPic -> fetch_assoc();

								$products_row['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";
								$filereal = "./img/contenido/productos/".$row_Img['id'].".jpg";
								if(!file_exists($filereal)){
									$products_row['img'] = $noPic;
								}
						
								$consultaCat = $CONEXION -> query("
										SELECT  * FROM productosexistencias
										WHERE producto = $producID AND precio > 0
										LIMIT 1;
									");

									$rowConsultaCat = $consultaCat -> fetch_assoc();
									
									$products_row['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";
			     ?>
			   <div class="uk-padding-small">
					<div class="uk-card uk-card-default uk-transition-toggle" style="border: 1px solid #7c573a">
			            <div class="uk-card-media-top uk-flex uk-flex-center padding-top-20">
			            	<div class="uk-cover-container" style="width:200px; height: 220px">
			            		 <img src="<?= $products_row['img'] ?>" alt="" uk-cover>
			            	</div>
			            </div>
						<a href="<?= $products_row['id'].'_'.$products_row['titulo'].'_item'?>">
				             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
			            		
			            		<p class="uk-text-uppercase">Ver detalles</p>
			            		<hr class="uk-divider-small">
			            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

				            </div>
						</a>
			            <div class="uk-card-body uk-text-center padding-10 color-primary">
		            	 	<hr class="uk-divider-small">
		            		<p class="uk-text-uppercase "><?= $products_row['titulo'] ?></p>
		                	<p><?= $products_row['precio'] ?></p>
			            </div>
			        </div>
				</div>
			<?php endwhile ?>
		</div>
		<?php else: ?>
			<div style="margin-left: 0" uk-grid>
				<div class="uk-child-width-1-1@m padding-10 margin-v-5">
		    		<div class="text-xxxl">
		    			<h2 style="color: red">No se encontraron resultados...</h2>
		    		</div>
	    		</div>
			</div>
	    	
		<?php endif; ?>
	</div>

</div>

<?=$footer?>

<?=$scriptGNRL?>
</body>
</html>