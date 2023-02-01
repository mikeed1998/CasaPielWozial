<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<?php  

		$consultaInicio = $CONEXION -> query("SELECT * FROM inicio 	WHERE id = 1");
		$inicioRow = $consultaInicio -> fetch_assoc();

		$imgCuidados = $inicioRow['imagen7'];
		

	if ( $languaje == 'es') {
		$titulo = "DALE EL MEJOR CUIDADO A TU PIEL";
		$subtitulo1 = "LIMPIEZA";
		$subtitulo1B = "DEL PRODUCTO";
		$subtitulo2 = "PRODUCTOS DE";
		$subtitulo2B = "MANTENIMIENTO";
		$subtitulo3 = "CÓMO";
		$subtitulo3B = "GUARDARLA";
		$text1 = "Las prendas de piel no se deben lavar como si fueran ropa textil. Al someter las prendas de piel por 
				 tiempo prolongado al agua sufren daños severos, puede ser que se encojan, decoloren o se entiecen. 
				 Si su prenda fue expuesta a agua por tiempo prolongado, dejela secar a la sombra.
				 En caso de que se haya puesto muy rigida la prensa, fobretela sobre si misma con poca fuerza para 
		 		 intentar recuperar su suavidad.";
		$text1B="Las prendas de piel solo se lavan de manera superficial con una esponja suave, 
				 jabon de calabaza y un poco de agua para humedecer la esponja o franela.";

		$text2 ="Cuando la piel pierde su brillo, existen productos especializados que son a base de silicones cuyo uso exclusivo son para articulos de piel.";
		$text2B = "Esta clase de productos los puede untar con una esponja suave sobre toda su prenda, 
					frotando suavemente hasta que el producto sea absorvido por la piel.";
		$text2C = "Para una mayor proteccion se puede rociar sobre la piel un repelente de agua y polvo para evitar manchas graves en el articulo.";
		$text3 = "Procure conservar su prenda en un lugar fresco y se recomienda mantenerla dentro de cubrepolvos o porta trajes para 
		evitar su deteriodo ya que el polvo tambien puede ser un factor que manche o decolore el articulo. Es recomendable darle mantenimiento
		ocasionalmente, pues en algunos casos cuando la prenda lleva mucho tiempo guardada o sin usarse se le puede generar humedad (se pone opaca o se endurece)
		cuando se da este caso se le recomienda que frote con una franela suave o bien con una crema especializada a base de silicones.";
	}elseif ( $languaje == 'en') {
		$titulo = "GIVE THE BEST CARE TO YOUR SKIN";
		$subtitulo1 = "PRODUCT";
		$subtitulo1B = "CLEANING";
		$subtitulo2 = "MAINTENANCE";
		$subtitulo2B = "PRODUCTS";
		$subtitulo3 = "HOW TO";
		$subtitulo3B = "KEEP IT";

		$text1="Leather garments must not be washed like any other regular textile garment. 
				To expose leather garments to water for an extended period of time may cause severe damage, 
				it can shrunken, discolor or stiffen them. If your garment has been exposed to water for an extended period of time, 
				let it dry under the shade. In case of stiffening, rub it against itself strongly to try to recover some of its softness."; 

		$text1B="Leather garments are only to be washed superficially with a soft sponge, pumpkin soap and a 
				little bit of water to humidify the sponge or flannel.";

		$text2="When leather loses its shiny quality there are some specialized silicone made products whose exclusive use is for leather garments.";
		$text2B="This sort of product can be spread with a soft sponge over the whole garment, rubbing softly until the product has been absorbed by the leather.";
		$text2C ="For better protection, a water and dust repellent can be sprayed over the leather to prevent the product from getting stained.";
		$text3 ="Make sure to store you garment in a fresh place and its recommended to keep it inside a dust cover or suit bag to prevent its damage, 
		considering that dust can also be a staining or discoloring factor. 
		It is recommended to give occasional maintenance since in some cases when the garment has been stored and unused 
		for a long period of time it can generate moisture (it darkens or stiffens), in which case it is suggested to rub it with a soft flannel or a specialized silicone made cream.";
	}
?>

<div class="uk-container uk-container-large margin-top-10" style="min-height: 80vh;">
	<div class="uk-background-cover uk-panel " style="background-image: url(./../img/contenido/varios/<?= $imgCuidados  ?>);min-height: 350px;">
	</div>

	<div class="margin-left-0 uk-margin-top" uk-grid>
		<div class="uk-width-1-1 bg-black text-xxxxl color-blanco uk-text-center negritas">
			<?= $titulo  ?>
		</div>
		<div class="uk-container uk-container-large text-11">
			<div class="margin-left-0 uk-padding padding-top-10" uk-grid>

				<div class="uk-width-1-3@m padding-30 border-black remove-padding" style="min-height: 400px;">
					<div class="uk-flex uk-flex-center uk-margin-bottom">
						<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
			            <img  class="" data-src="./../img/design/burbuja.png" width="140" height="140" alt="" uk-img>
			            <img  class="uk-transition-scale-up uk-position-cover" src="./../img/design/burbuja.jpg" alt="">
			        	</div>
					</div>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo1 ?></p>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo1B ?></p>
					<div class="larger-line-black"></div>
					<p class="uk-text-justify"><?= $text1 ?></p>
					<p class="uk-text-justify"><?= $text1B ?></p>
					<div class="larger-line-black"></div>
				</div>
				<div class="uk-width-1-3@m padding-30 remove-padding" style="min-height: 400px;">
					<div class="uk-flex uk-flex-center uk-margin-bottom">
						<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
			            <img  class="" data-src="./../img/design/spray.png" width="140" height="130" alt="" uk-img>
			            <img  class="uk-transition-scale-up uk-position-cover" src="./../img/design/spray.jpg" alt="">
			        	</div>
					</div>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo2 ?></p>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo2B ?></p>
					<div class="larger-line-black"></div>
					<p class="uk-text-justify">
						<?= $text2 ?>
					</p>
					<p class="uk-text-justify"> <?=$text2B ?></p>
					<p class="uk-text-justify" style="margin-bottom: 65px;"><?=$text2C?> </p>
					<br>
					<div class="larger-line-black"></div>
				</div>
				<div class="uk-width-1-3@m padding-30 remove-padding">
					<div class="uk-flex uk-flex-center uk-margin-bottom">
						<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
			            <img  class="" data-src="./../img/design/gancho.png" width="140" height="138" alt="" uk-img>
			            <img  class="uk-transition-scale-up uk-position-cover" src="./../img/design/gancho.jpg" alt="">
			        	</div>
					</div>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo3 ?></p>
					<p class="text-lg uk-text-center margin-5 main-color negritas"><?= $subtitulo3B ?></p>
					<div class="larger-line-black"></div>

					<p class="uk-text-justify">
						<?= $text3 ?>
					</p>
					<br><br>
					<div class="larger-line-black"></div>
				</div>
			</div>
		</div>
	</div>

</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>