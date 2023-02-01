<?php 
echo '
<div class="uk-width-auto margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Foto Inferior</a></li>
	</ul>
</div>
';



// Banner de inicio
$consulta = $CONEXION -> query("SELECT * FROM $seccion WHERE id = 1");
$rowCONSULTA = $consulta -> fetch_assoc();

$pic='../img/contenido/varios/'.$rowCONSULTA['imagen2'];
if(strlen($rowCONSULTA['imagen2'])>0 AND file_exists($pic)){
	$archivo='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic.'" target="_blank">
			<img src="'.$pic.'">
		</a><br><br>
		<a href="javascript:eliminaPic()" class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</a>
	</div>';
}
else{
	$archivo='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
			Se está mostrando la imagen por default<br><br>
		</p>
	</div>';
}

echo '
<div class="uk-width-1-1">
	<div class="margin-top-50 uk-text-center uk-container uk-container-xsmall">
		<div class="uk-card uk-card-default uk-card-body">
			<h3>Imagen de inicio mujeres</h3>
			<div uk-grid>
				<div class="uk-width-1-1"> 
					<label>Texto descripcion mujeres</label>
					<div class="uk-width-expand">
						<input class="editarajax uk-input uk-input-large" data-tabla="'.$seccion.'" data-campo="texto2" data-id="1" value="'.$rowCONSULTA['texto2'].'">
					</div>
				</div>
				<div class="uk-width-1-1"> 
					<label>Texto descripcion mujeres ingles</label>
					<div class="uk-width-expand">
						<input class="editarajax uk-input uk-input-large" data-tabla="'.$seccion.'" data-campo="texto4" data-id="1" value="'.$rowCONSULTA['texto4'].'">
					</div>
				</div>
				<div class="uk-width-1-1"> 
					Dimensiones recomendadas: 1500 x 900 px<br><br>
				</div>
				<div class="uk-width-1-2@s">

					<div id="fileuploader">
						Cargar
					</div>
				</div>
				<div class="uk-width-1-2@s uk-text-center margin-v-20">
					'.$archivo.'
				</div>
			</div>
		</div>
	</div>
</div>';


$scripts='
	function eliminaPic () {
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true){
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarimagen=1&campo=imagen2");
		}
	};

	$(document).ready(function() {
		$("#fileuploader").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen2&uploadedfile=\'+data);
			}
		});
	});
	';
?>