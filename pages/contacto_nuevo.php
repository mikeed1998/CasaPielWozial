<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>
<?php  
	if ($languaje == 'es') {
		$titulo="¡Estamos para servirte!";
		$placeholder1="NOMBRE:";
		$placeholder2="CORREO:";
		$placeholder3="TELEFONO:";
		$placeholder4="MENSAJE:";
		$buttonText ="ENVIAR";
	}elseif($languaje == 'en'){
		$titulo="We're here to serve you!";
		$placeholder1="NAME:";
		$placeholder2="E-MAIL:";
		$placeholder3="PHONE:";
		$placeholder4="MESSAGE:";
		$buttonText ="SEND";
	}
?>


<div class="uk-container uk-container-large uk-margin-top" style="min-height: 600px;">
	<div class="uk-background-cover uk-panel " style="background-image: url(../img/design/contacto-bg.jpg);height: 650px">
		<div class="uk-container uk-container-small uk-padding-small">
			<div class="uk-grid-small margin-left-0 uk-padding-large uk-flex uk-flex-center uk-flex-middle zero" uk-grid>
				<div class="custom-divider-white"></div> 
				<span class="color-blanco margin-h-5 zero" uk-icon="icon: mail; ratio: 3"></span>
				<div class="custom-divider-white"></div>
			</div>	

			<div class="uk-width-1-1@m">
				<h2 class="color-blanco text-xxl uk-text-center"><?= $titulo  ?></h2>
			</div>
				
			<div class=" margin-left-0 uk-padding contac-form remove-padding" uk-grid style="border: solid white">
				
				<div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder1?>" id="footernombre">
			    </div>
			    <div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder2?>" id="footeremail">
			    </div>
			     <div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder3?>" id="footertelefono">
			    </div>
			    <div class="uk-width-1-1@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder4?>" id="footercomentarios">
			    </div>
			    <div class="uk-width-1-1@m uk-margin-medium-top uk-flex uk-flex-center">
			    	<div>
		    		   <button id="footersend" class="uk-button contac-form contac-form-button"><?=$buttonText?></button>
			    	</div>
			    </div>
			    <div class="uk-width-1-1@m uk-flex uk-flex-center">
			    	<div class="uk-cover-container">
					    <img data-src="../img/design/logo.png" width="350" height="180" alt="" uk-img>
					</div>
			    </div>
	
			</div>

		</div>
	</div>	
</div>
<div class="uk-container uk-container-large uk-margin-top">
	<div class="uk-container uk-container uk-width-1-1 uk-padding-small uk-margin-top 	bg-black">
		<div class="uk-grid-small margin-left-0 uk-padding-small"  uk-grid>
			<?php
		 		$consultaSucursales = $CONEXION -> query("SELECT * FROM sucursales ORDER BY id LIMIT 2");
				$cantSucursales = $consultaSucursales->num_rows;
				$domicilios = array();
				if($cantSucursales >= 2){
					$cantSucursales = 2;
				}
				while($rowSucursales = $consultaSucursales -> fetch_assoc()):
					array_push($domicilios, $rowSucursales['txt']);
			 ?>
				<div class="uk-width-1-<?=$cantSucursales?>@m" >
					<div class="color-blanco text-xxl">
						<?= $rowSucursales['titulo'] ?>
						<div class="larger-line-white "></div>	
					</div>
						
			     	 <div class="uk-margin-small-top" id="map<?=$rowSucursales['id']?>"style="min-height: 250px;">
			     	 </div>
			     	 <script>
					    // Initialize and add the map
						function initMap() {
							
						    var pos = {lat:<?php echo $rowSucursales['lat'] ?> , lng:<?php echo $rowSucursales['lon'] ?>};
						    var mapName = 'map'+<?php echo $rowSucursales['id'] ?>;
						    var map<?php echo $rowSucursales['id'] ?> = new google.maps.Map(
						    document.getElementById(mapName), {zoom: 15, center: pos});
						    var marker = new google.maps.Marker({position: pos, map: map<?php echo $rowSucursales['id'] ?>});
						}
					</script>
				   				
				</div>

			<?php endwhile ?> 
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=$googleMaps?>&callback=initMap"></script>
		</div>
		
	</div>
</div>

<div class="uk-container uk-container-large uk-margin-small-top" style="min-height: 250px;">
	<div class="uk-container uk-container uk-width-1-1 uk-padding-small uk-margin-top">
		<div class="uk-grid-small margin-left-0 uk-padding-small"  uk-grid>
			<?php for ($i=0; $i < sizeof($domicilios); $i++):
				# code...
			 ?>
				<div class="uk-width-1-<?=$cantSucursales?>@m">
					<div class="larger-line-black "></div>
					<div class="uk-margin-top uk-text-center address-container">
						<?= $domicilios[$i]?>
					</div>
			<?php endfor  ?>
				   				
				</div>
		</div>
		
	</div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>