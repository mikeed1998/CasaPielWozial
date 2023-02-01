<?php 
echo '
<div class="uk-width-auto margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Sección contacto</a></li>
	</ul>
</div>
';



// Banner de inicio
$consulta = $CONEXION -> query("SELECT * FROM $seccion WHERE id = 1");
$rowCONSULTA = $consulta -> fetch_assoc();

$pic ='../img/contenido/varios/'.$rowCONSULTA['imagen4'];
$pic2='../img/contenido/varios/'.$rowCONSULTA['imagen5'];
$pic3='../img/contenido/varios/'.$rowCONSULTA['imagen6'];

if(strlen($rowCONSULTA['imagen4'])>0 AND file_exists($pic)){
	$archivo='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic.'" target="_blank">
			<img src="'.$pic.'">
		</a><br><br>
		<a href="javascript:eliminaPic()" class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</a>
	</div>';
}else{
	$archivo='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
			Se está mostrando la imagen por default<br><br>
		</p>
	</div>';
}
if(strlen($rowCONSULTA['imagen5'])>0 AND file_exists($pic2)){
	$archivo2='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic2.'" target="_blank">
			<img src="'.$pic2.'">
		</a><br><br>
		<a href="javascript:eliminaPic()" class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</a>
	</div>';
}else{
	$archivo2='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
			Se está mostrando la imagen por default<br><br>
		</p>
	</div>';
}
if(strlen($rowCONSULTA['imagen6'])>0 AND file_exists($pic3)){
	$archivo3='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic3.'" target="_blank">
			<img src="'.$pic3.'">
		</a><br><br>
		<a href="javascript:eliminaPic()" class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</a>
	</div>';
}else{
	$archivo3='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
			Se está mostrando la imagen por default<br><br>
		</p>
	</div>';
}

echo '
<div class="uk-width-1-1">
	<div class="margin-top-50 uk-text-center uk-container uk-container-large">
		<div class="uk-card uk-card-default uk-card-body">
			<h3>Imagenes de sección productos</h3>
			Dimensiones recomendadas: 450 x 120 px<br><br>
			<div uk-grid>
				
				<div class="uk-width-1-6@s">
				Damas
					<div id="fileuploaderc1">
						Cargar
					</div>
				</div>
				<div class="uk-width-1-6@s uk-text-center margin-v-20">
					'.$archivo.'
				</div>
				
				<div class="uk-width-1-6@s">
					Caballeros
					<div id="fileuploaderc2">
						Cargar
					</div>
				</div>
				<div class="uk-width-1-6@s uk-text-center margin-v-20">
					'.$archivo2.'
				</div>
				
				<div class="uk-width-1-6@s">
					Accesorios
					<div id="fileuploaderc3">
						Cargar
					</div>
				</div>
				<div class="uk-width-1-6@s uk-text-center margin-v-20">
					'.$archivo3.'
				</div>
			</div>
		</div>
	</div>
</div>';



$scripts='
	function eliminaPic () {
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true){
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarimagen=1&campo=imagen4");
		}
	};

	$(document).ready(function() {
		$("#fileuploaderc1").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen4&uploadedfile=\'+data);
			}
		});
	});

	function eliminaPic () {
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true){
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarimagen=1&campo=imagen5");
		}
	};

	$(document).ready(function() {
		$("#fileuploaderc2").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen5&uploadedfile=\'+data);
			}
		});
	});
	function eliminaPic () {
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true){
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarimagen=1&campo=imagen6");
		}
	};

	$(document).ready(function() {
		$("#fileuploaderc3").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen6&uploadedfile=\'+data);
			}
		});
	});
	';
?>