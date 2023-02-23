<!DOCTYPE html>
<?=$headGNRL?>
	


</style>

<body>


	<?php

		$style     	= 'max-width:200px;';
		$noPic     	= './img/design/camara.jpg';
	    $rutaPics  	= './img/contenido/productos/';
	    $firstPic  	= $noPic;
	    $disabled = "uk-disabled";

	    if ($languaje == 'es') {

		    $bottonText = 'Ver detalles';
		    $lng="";
		    $relacionadosText="OTROS PRODUCTOS RELACIONADOS";
		    $bottonCarritoText="Añadir al carrito";
		    $btnCuidadosText="Ver cuidados";
		    $warningText= "* Los precios de los productos pueden variar dependiendo de la talla ó del color";
		 	$priceText = "Precio: $";
		 	$agotado = "Producto Agotado";

		}elseif ($languaje == 'en') {

		    $bottonText = 'See more';
		    $lng="_en";
		    $relacionadosText="RELATED PRODUCTS";
		    $bottonCarritoText="Add to cart";
		    $btnCuidadosText="See cares";
		 	$warningText="* Product prices may change depending of size or color";
		 	$priceText="Price: $";
		 	$agotado = "Out of stock";


		}

	    //consulta el producto
	    $consultaProd = $CONEXION -> query("SELECT * FROM productos WHERE id = $id");
		$producto = $consultaProd -> fetch_assoc();
		$sku = $producto['sku'];
		$clasif = $producto['clasif'];
		$categoriaId = $producto["categoria"];
		$productoId = $producto["id"];

		// $consultaPrecio = $CONEXION -> query("SELECT id,precio FROM productosexistencias WHERE existencias > 0 and producto = $productoId ORDER BY id DESC LIMIT 1");
		$consultaPrecio = $CONEXION -> query("SELECT id,precio FROM productosexistencias WHERE producto = $productoId AND precio and precio > 0  ORDER BY id DESC LIMIT 1");
		
		$precioRow = $consultaPrecio -> fetch_assoc();
		$idExis=$precioRow['id'];

		$precio = number_format(($precioRow["precio"]),2);

	     $CONSULTA3 = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden LIMIT 1");
	      while ($rowCONSULTA3 = $CONSULTA3 -> fetch_assoc()) {

	        $firstPic = $rutaPics.$rowCONSULTA3['id'].'-lg.jpg';

	     }

	    $picWidth=0;
	    $picHeight=0;
	    $picSize=getimagesize($firstPic);

	    foreach ($picSize as $key => $value) {
	        if ($key==3) {
	          $arrayCadena1=explode(' ',$value);
	          $arrayCadena1=str_replace('"', '', $arrayCadena1);
	          foreach ($arrayCadena1 as $key1 => $value1) {

	            $arrayCadena2=explode('=',$value1);
	            foreach ($arrayCadena2 as $key2 => $value2) {
	              if (is_numeric($value2)) {
	                $picProp[]=$value2;
	              }
	            }
	          }
	        }
	    }

	    if (isset($picProp)) {
	        $picWidth=$picProp[0];
	        $picHeight=$picProp[1];

	        $style=($picWidth<$picHeight)?'max-height:200px;':$style;
	    }
	    $consultaCatego = $CONEXION -> query("SELECT * FROM productosclasif WHERE id = '$clasif'");

		while ($rowCONSULTA = $consultaCatego -> fetch_assoc()){
			$tipo=$rowCONSULTA['txt'];
		}

		if (!isset($tipo)) {
			$tipo=999;
		}
	?>
	<?=$header?>
	<div class="uk-container uk-container-large margin-v-10 " style="min-height: 1100px;">
		<div class="uk-box-shadow-large uk-margin-top margin-left-0" uk-grid style="min-height: 1100px;">
			<!--SECCION DE IMAGENES -->
			<div class="uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-padding-small">
	            <div class="padding-10" uk-grid style="margin-left: 0;">
	            	<div class="uk-width-1-1@m  uk-width-1-1@l uk-padding-remove">
	            		<div class="uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle border-container">
	            		  	<?php
					          if (file_exists($firstPic)) {
					            $pic=$firstPic;
					          }else{
					            $pic='../img/design/camara.jpg';
					          }
					          echo '
					          	<img id="pic" data-zoom-image=".'.$pic.'" src=".'.$pic.'" alt=""  style="max-height: 670px;">
					            ';
					         ?>
		                </div>
		            </div>
		            <div class="uk-width-1-1@m  uk-width-1-1@l uk-padding-remove">
			            <div class="uk-grid-small uk-child-width-1-4 uk-flex-center" uk-grid style="margin-left: 0;">

			            	<?php
					          $num=0;
					          $rutaImg = "../img/contenido/productos/";
					          $rutaImgReal = "./img/contenido/productos/";

					          $consultafotos = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden");
					          $numPics=$consultafotos->num_rows;

					          if ($numPics>1) {
					            while($rowConsultaFotos = $consultafotos -> fetch_assoc()){
					           	  $color =$rowConsultaFotos['color'];
					              if (isset($arregloPics)) {
					                $arregloPics .= ',"'.$rowConsultaFotos['id'].'"';
					              }else{
					                $arregloPics = '"'.$rowConsultaFotos['id'].'"';
					              }

					             $pic=$rutaImg.$rowConsultaFotos['id'].'-lg.jpg';
					           	 $picProvisional= $rutaImgReal.$rowConsultaFotos['id'].'-lg.jpg';
					              if (file_exists($picProvisional)) {

					                $lightboxA1=($es_movil===TRUE)?'<a href="'.$picLG.'">':'';
					                $lightboxA2=($es_movil===TRUE)?'</a>':'';
					                echo '
					                	<div>


					                    <div class="pic uk-border-rounded pointer uk-flex uk-flex-center uk-flex-middle uk-box-shadow-large" data-id="'.$num.'" data-color="'.$color.'">
						            		<img src="'.$pic.'" alt="" style="max-height:100%">
						            	</div>


										</div>';
					                $num++;
					              }
					            }
					          }
					         ?>
				        </div>
			        </div>
	            </div>
			</div>
			<!--SECCION DE DETALLE DE PRODUTO -->
			<div class="uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l padding-right-50">
				<div class="margin-left-0 uk-margin-large-top" uk-grid>
					<div class="uk-width-1-1 text-xxl uk-padding-remove color-primary negritas uk-text-uppercase"><?= $producto['titulo'] ?></div>
					</div>
					<hr class="uk-divider-small-grey uk-margin-small-top">
					<div class="uk-width-1-1 text-xl uk-padding-remove color-primary margin-v-10"> <?= $priceText  ?> <span class="color-primary" id="precio-numero"><?= $precio?></span>Mx</div>

					<div class="uk-width-1-1 text-11 color-gris-3 uk-padding-remove uk-text-justify">
						<?= html_entity_decode($producto['txt'.$lng]) ?>
					</div>
					<!-- Tallas -->
					<div class="uk-width-1-1@m padding-5 margin-v-5">
						<div class="margin-left-0 uk-padding-remove margin-top-20" uk-grid>
							<ul class="uk-width-1-1 uk-subnav uk-subnav-pill" uk-switcher
							style="margin:auto;padding:0;text-align:center;width:100%">
								<?php

									$existencias=0;
									$disbl="";
									$CONSULTA = $CONEXION -> query("SELECT * FROM productostalla WHERE tipo = '$tipo' ORDER BY orden");
									while ($rowCONSULTA = $CONSULTA -> fetch_assoc()):

										$thisID=$rowCONSULTA['id'];
										$consultaTE = $CONEXION -> query("SELECT * FROM productosexistencias WHERE producto = $productoId AND talla = $thisID AND existencias > 0");
										$existencias += $consultaTE->num_rows;

										if($consultaTE->num_rows == 0 OR $consultaTE->num_rows == null ){
											$disbl ="uk-disabled";
											$existenciasId=$rowCONSULTA3['id'];
											$precio=$rowCONSULTA3['precio'];

										}else{
											$rowExistencias = $consultaTE -> fetch_assoc();

											$existenciasId=$rowExistencias['id'];
											$preciop=$rowExistencias['precio'];
											$disbl="";

										}

										$crossed="";
										if($consultaTE->num_rows === 0){

											$crossed = "background-image: url('../img/design/diagonal.png');background-size:cover";
										}

								?>
									<li class="margin-movil-tallas"
									style="display:inline-block;margin:5px;padding:0;
									vertical-align:middle;width:70px;<?=$crossed ?>;">
										<a class="color-blanco uk-text-center talla <?=$disbl;?>"
											href="#"
											style="margin:0;padding:0;padding-top:14px;height:30px;"
											data-precio="<?=$preciop ?>"
											data-id="<?= $existenciasId ?>"
											data-tallaId="<?=$rowCONSULTA['id']?>" ><?=$rowCONSULTA['txt']?></a>
										<?php if($consultaTE->num_rows == 0):  ?><!--div class="crossed"></div--> <?php endif  ?>
									</li>


								<?php endwhile ?>
								<?php
									if($existencias > 0){
										$hidden = "";
										$hidden2= "uk-hidden";
									}else{
										$hidden = "uk-hidden";
										$hidden2= "";
									}
								?>
							</ul>
							<!-- COLORES POR TALLA -->
							<ul class="uk-width-1-1 uk-switcher uk-margin">
								<?php
								$CONSULTA = $CONEXION -> query("SELECT * FROM productostalla WHERE tipo = '$tipo' ORDER BY orden");

								while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {

									$tallaId=$rowCONSULTA['id'];

									// Información relacionada con la talla

									$CONSULTAB = $CONEXION -> query("SELECT * FROM productostallarel WHERE producto = $productoId AND talla = $tallaId");
									$rowCONSULTAB = $CONSULTAB -> fetch_assoc();
									$trid=$rowCONSULTAB['id'];
									echo '
										<li>
											<!-- Existencias, colores y precios -->
											<div uk-grid class="uk-child-width-1-4@xl uk-child-width-1-2@m uk-child-width-1-2@s margin-left-0">
											';

											$consultaColores = $CONEXION -> query("SELECT * FROM productos WHERE sku = '$sku'");

											while($rowProductosColores = $consultaColores -> fetch_assoc()){
												$prodId = $rowProductosColores['id'];
												$prodName = $rowProductosColores['titulo'];

												$CONSULTA3 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE producto = $prodId AND talla = $tallaId AND existencias > 0");

												if($CONSULTA3->num_rows > 0){
													$rowCONSULTA3 = $CONSULTA3 -> fetch_assoc();
													
													$color=$rowCONSULTA3['color'];

													// Obtener todos los colores
													$CONSULTA2 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $color ");
													$rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
													$colorId  = $rowCONSULTA2['id'];
	 												$rutaFinal="../img/contenido/productos/";
													$imagen   = $rutaFinal.$rowCONSULTA2['imagen'];

													$imagenReal ="./img/contenido/productos/".$rowCONSULTA2['imagen'];
													$colorTxt = (strlen($rowCONSULTA2['imagen'])>0 AND file_exists($imagenReal))?'<div class="uk-border-circle" style="background:url('.$imagen.');background-size:cover;width:30px;height:30px;border:solid 1px #999;">&nbsp;</div>':'<div class="uk-border-circle" style="background:'.$rowCONSULTA2['txt'].';width:30px;height:30px;border:solid 1px #999;">&nbsp;</div>';
													$imgPicId=null;

													// Obetener Existencias y precios

													$colorPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $productoId AND color = $colorId");

													if($colorPic->num_rows > 0){
														$rowPic = $colorPic -> fetch_assoc();
														$imgPicId = $rowPic['id'];
													}


													$existencias=$rowCONSULTA3['existencias'];

													if($existencias > 0){
														echo '
															<div class="uk-padding-remove">
																<div class="uk-padding-remove text-7 uk-text-center" style="margin-left:0" uk-grid>
																	<div class="uk-width-auto uk-flex uk-flex-middle uk-flex-center">
																		<a class="color" href="'.$prodId.'_'.$prodName.'_item"  data-color="'.$imgPicId.'">
																		'.$colorTxt.'
																		</a>
																	</div>
																	<div class="uk-width-expand uk-flex uk-flex-middle uk-flex-left">
																	'.$rowCONSULTA2['name'].'
																	</div>
																</div>
															</div>
														';
													}else{
													/*echo '
															<p class="text-8 uk-text-warning">Sin existencias</p>
														';
														$hidden = "uk-hidden";*/
													}

												}
											}

											echo '

												</div>
											</li>';
										}
								?>
						 	</ul>
			 				<!--fin colores-->
						</div>
					</div>
					<!-- botones -->

					<div class="uk-width-1-1@m padding-5 margin-v-5">

						<button class="color-blanco uk-text-center uk-padding-small text-11 <?= $hidden2  ?>" style="width: 100%;padding: 17px;cursor:pointer;background: red"> <?= $agotado  ?></button>
					</div>

					<div class="uk-width-1-1@m padding-5 margin-v-5">
						<input type="hidden"  id="<?= $productoId?>"  value="1">
						<button class="color-blanco uk-text-center uk-padding-small buybutton text-11 <?= $hidden ?>" style="width: 100%;padding: 17px;cursor:pointer;" data-id="<?=$productoId?>" data-idexis="<?= $idExis  ?>"> <?= $bottonCarritoText  ?></button>
					</div>

					<div class="uk-width-1-1@m padding-5 uk-padding-small margin-v-5">
						<a href="cuidados">
							<div class="color-blanco uk-text-center text-11" style="padding: 16px; background: #7f5739;"><?= $btnCuidadosText  ?></div>
						</a>
					</div>

					<div class="uk-width-1-2@m padding-5 margin-v-5">
						<div class="text-8 uk-padding-remove uk-text-danger"><?=$warningText?></div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<!-- PRODUCTOS RELACIONADOS -->
	<div class="uk-container uk-container-large padding-bottom-20 uk-margin-large-top">
		<div class="text-xxl color-primary negritas"><?= $relacionadosText  ?></div>
		<hr class="uk-divider-small-grey uk-margin-small-top">

		<div uk-slider style="width:100%;">
			<div class="uk-position-relative uk-visible-toggle uk-dark aling-center" tabindex="-1" uk-slider style="height:500px;">
			    <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-4@m aling-center" style="margin:0 2em">
			        <?php

				     	$consultaRelacionados = $CONEXION -> query("SELECT * FROM productos WHERE id != $id AND categoria = $categoriaId AND estatus != 0 LIMIT 8");
						while($row_ProductoRel = $consultaRelacionados -> fetch_assoc()):
							$producID =$row_ProductoRel['id'];
							$consultaPic = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $producID ORDER BY orden LIMIT 1");
							$row_Img = $consultaPic -> fetch_assoc();

							$row_ProductoRel['img'] = "../img/contenido/productos/".$row_Img['id'].".jpg";


							$consultaCat = $CONEXION -> query("
								SELECT  *
								FROM productosexistencias
								WHERE producto = $producID AND precio > 0
								LIMIT 1;
							");

							$rowConsultaCat = $consultaCat -> fetch_assoc();

							$row_ProductoRel['precio'] = "$".number_format(($rowConsultaCat['precio']),2)." MX";
				     ?>
			        <li>
						<div class="uk-padding-small">
							<div class="uk-card uk-card-default uk-transition-toggle">
								<a href="<?= $row_ProductoRel['id'].'_'.$row_ProductoRel['titulo'].'_item'?>">
					            <div class="uk-card-media-top uk-flex uk-flex-center padding-top-20">
					            	<div class="uk-cover-container" style="width:200px; height: 220px">
					            		 <img src="<?=$row_ProductoRel['img'] ?>" alt="" uk-cover>
					            	</div>
					            </div>

					             <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
				            		<p class="uk-text-uppercase color-primary"><?= $bottonText  ?></p>
				            		<hr class="uk-divider-small">
				            		<i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>
					            </div>

					            <div class="uk-card-body uk-text-center padding-10 color-primary">
				            	 	<hr class="uk-divider-small">
				            		<p class="uk-text-uppercase negritas"><?= $row_ProductoRel['titulo'] ?></p>
				                	<p><?= $row_ProductoRel['precio']?></p>
					            </div>
					            </a>
					        </div>
						</div>
			        </li>
			    <?php endwhile  ?>
			    </ul>
			    <div class="uk-flex uk-flex-center uk-flex-middle margin-top-10">
	                 <a class="uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
	                 <div class="slider-divider"></div>
	                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
	                <div class="slider-divider"></div>
	                <a class="uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
	            </div>
			</div>

		</div>
	</div>


<?=$footer?>

<?=$scriptGNRL?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
if($es_movil!==true){
  echo "<script src='../library/elevatezoom/jquery.elevatezoom.js'></script>";
}
?>

<script type="text/javascript">
	var tallaId=null;
	var colorId=null;

	$( document ).ready(function() {
    	$('table').addClass("table-size");
	});

	<?php if($es_movil!==true): ?>
		$("#pic").elevateZoom({
		    zoomType : "lens",
		    lensShape : "square",
		    lensSize : 240,
		    scrollZoom: true
		  });
	<?php endif ?>

  <?php
    if (isset($arregloPics)) {
  ?>
       $('.pic').click(function(){
       	console.log("dio click");
        var arreglo = [<?=$arregloPics?>];
        console.log(arreglo);

        var id = $(this).attr('data-id');
        console.log("el id",id);
        $('#actual').val(id);
        $( "#pic" ).addClass( "alpha0", 200 );
        console.log("aca si llego");
        setTimeout(function() {
        	console.log("si entre aca");
        	console.log('<?=$rutaImg?>'+arreglo[id]+'.jpg');
          $('#pic').attr('src','<?=$rutaImg?>'+arreglo[id]+'.jpg');
          $('#pic').attr('data-zoom-image','<?=$rutaImg?>'+arreglo[id]+'.jpg');
          $('#pic').removeClass( "alpha0", 500 );
          var ez = $('#pic').data('elevateZoom');
          ez.swaptheimage('<?=$rutaImg?>'+arreglo[id]+'.jpg', '<?=$rutaImg?>'+arreglo[id]+'.jpg');
        }, 200 );
      });

  <?php
    }
  ?>


//FUNCION PARA SELECCIONAR precio y id de esixtencia de productos


  $('.talla').click(function(){
  	var precio = $(this).attr('data-precio');
  	var idExis = $(this).attr('data-id');
  	precio=parseFloat(precio);
  	precio=precio.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  	console.log("idExis",idExis);
  	console.log("precio",precio);

  	$('#precio-numero').text(precio);

  	$('.buybutton').attr('data-idexis',idExis);

  });

 $('.color').click(function(){

  	<?php
    if (isset($arregloPics)) {
  	?>
 		console.log("si hay pics",<?=$arregloPics ?>);
        var id = $(this).attr('data-color');
       	if(id){
       		$( "#pic" ).addClass( "alpha0", 200 );
	        setTimeout(function() {
	          $('#pic').attr('src','<?=$rutaImg?>'+id+'.jpg');
	          $('#pic').attr('data-zoom-image','<?=$rutaImg?>'+id+'.jpg');
	          $('#pic').removeClass( "alpha0", 500 );
	          var ez = $('#pic').data('elevateZoom');
	          ez.swaptheimage('<?=$rutaImg?>'+id+'.jpg', '<?=$rutaImg?>'+id+'.jpg');
	        }, 200 );
       	}
	<?php
    } ?>
});

</script>


</body>
</html>
