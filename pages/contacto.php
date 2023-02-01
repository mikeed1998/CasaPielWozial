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
	}elseif ( $languaje == 'en'){
		$titulo="We're here to serve you!";
		$placeholder1="NAME:";
		$placeholder2="E-MAIL:";
		$placeholder3="PHONE:";
		$placeholder4="MESSAGE:";
		$buttonText ="SEND";
	}
?>


<div class="uk-container uk-container-large uk-margin-top" style="min-height: 600px;">
	<div class="uk-background-cover uk-panel uk-flex uk-flex-middle " style="background-image: url(../img/contenido/varios/<?= $contactoImg  ?>);height: 750px">
		<div class="uk-container uk-container-small uk-padding-small">	
			<div class=" margin-left-0 uk-padding contac-form remove-padding" uk-grid>
				<div class="uk-width-1-1@m margin-left-0 uk-padding-large uk-flex uk-flex-center uk-flex-middle zero uk-align-center uk-margin-small-bottom">
					<div class="custom-divider-white"></div> 
						<span class="color-primary margin-h-5 zero" uk-icon="icon: mail; ratio: 3"></span>
					<div class="custom-divider-white"></div>
				</div>	

				<div class="uk-width-1-1@m">
					<h2 class="color-primary text-xxl uk-text-center"><?=$titulo ?></h2>
				</div>
				
				<div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder1?>"  id="footernombre">
			    </div>
			    <div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder2?>" id="footeremail">
			    </div>
			     <div class="uk-width-1-3@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder3?>" id="footertelefono">
			    </div>
			    <div class="uk-width-1-1@m uk-margin-medium-top">
			        <input class="uk-input contac-form" type="text" placeholder="<?= $placeholder4?>"  id="footercomentarios">
			    </div>
			    <div class="uk-width-1-1@m uk-margin-medium-top uk-flex uk-flex-center">
			    	<div>
		    		   <button id="footersend" class="uk-button contac-form contac-form-button"><?=$buttonText?></button>
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
				$maps = array();
				if($cantSucursales >= 2){
					$cantSucursales = 2;
				}
				while($rowSucursales = $consultaSucursales -> fetch_assoc()):
					array_push($maps, $rowSucursales);
					array_push($domicilios, $rowSucursales['txt']);
			 ?>
				<div class="uk-width-1-<?=$cantSucursales?>@m uk-text-uppercase">
					<div class="color-blanco text-xxl">
						<?= $rowSucursales['titulo'] ?>
						<div class="larger-line-white "></div>	
					</div>
			     	 <div class="uk-margin-small-top" id="map<?=$rowSucursales['id']?>"style="min-height: 250px;">
			     	 </div>
				</div>

			<?php endwhile ?> 

			 <script>
				// Initialize and add the map
				function initMap(){
				<?php foreach ($maps as $key): ?>
				    var pos = {lat:<?php echo $key['lat'] ?> , lng:<?php echo $key['lon'] ?>};
				    console.log("pos",pos);
				    var mapName = 'map'+<?php echo $key['id'] ?>;
				    var map<?php echo $key['id'] ?> = new google.maps.Map(
				    document.getElementById(mapName), {zoom: 15, center: pos});
				    var marker = new google.maps.Marker({position: pos, map: map<?php echo $key['id'] ?>});
				<?php endforeach  ?>
				}
			</script>
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
				<div class="uk-width-1-2@m">
					<div class="larger-line-black "></div>
					<div class="uk-margin-top uk-text-center address-container color-negro">
						<?= $domicilios[$i]?>
					</div>	
				</div>

			<?php endfor  ?>
		
		</div>
		
	</div>
</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>