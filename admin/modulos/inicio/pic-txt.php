<?php 
echo '
<div class="uk-width-auto margin-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">Imágenes flotantes</a></li>
	</ul>
</div>
';



$consulta = $CONEXION -> query("SELECT * FROM $seccion WHERE id = 1");
$rowConsulta = $consulta -> fetch_assoc();
foreach ($rowConsulta as $key => $value) {
	${$key}=$value;
}

echo '
<div class="uk-width-1-1 margin-top-50">
	<div class="uk-container">
		<div class="uk-card uk-card-default uk-card-body">
			<h3 class="uk-text-center">Imágenes flotantes</h3>
			<div uk-grid class="uk-child-width-expand@l uk-child-width-1-2@s">';


				for ($i=1; $i < 5; $i++) { 
					$imagen='imagen'.$i;

					$picTxt='
							<div class="uk-margin">
								<img src="../img/design/camara.jpg" class="uk-border-rounded">
							</div>';
					$buttonBorrar='<span class="uk-button uk-button-default">Eliminar</span>';
					$pic=$rutaFinal.${$imagen};
					if(file_exists($pic) AND strlen(${$imagen})>0){
						$buttonBorrar='<a href="javascript:eliminaPic('.$i.')" class="uk-button uk-button-danger">Eliminar</a>';
						$picTxt='
							<div class="uk-margin">
								<img src="'.$pic.'" class="uk-border-rounded">
							</div>';
					}

					echo '
					<div>
						<div class="uk-margin uk-text-center">
							'.$buttonBorrar.'
							<a href="#upload" data-campo="'.$i.'" uk-toggle class="abremodal uk-button uk-button-primary">Subir</a>
						</div>
						<div class="uk-margin uk-text-center">
							'.$picTxt.'
						</div>
					</div>';
				}

echo '
			</div>
		</div>
	</div>
</div>';



echo '
<div id="upload" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-outside" type="button" uk-close></button>
		<input type="hidden" id="itemcampo">
		<div id="fileuploader">
			Cargar
		</div>
    </div>
</div>';


$scripts='
	function eliminaPic (campo) {
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true){
			window.location = ("index.php?seccion='.$seccion.'&borrarimagen=1&campo=imagen"+campo);
		}
	};

	$(".abremodal").click(function(){
		var campo = $(this).attr("data-campo");
		$("#itemcampo").val(campo);
	});

	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "jpg",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){
				var campo = $("#itemcampo").val();
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen\'+campo+\'&uploadedfile=\'+data);
			}
		});
	});

	';
?>