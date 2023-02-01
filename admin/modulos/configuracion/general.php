<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">'.$subseccion.'</a></li>
	</ul>
</div>




<div class="uk-width-1-1">
	<div class="uk-container">
		<div uk-grid class="uk-child-width-1-2@m uk-flex-center">
			<div>

				<div class="padding-v-20">
					<h3>Metadatos</h3>
					<div uk-grid>
						<div>
							<label for="envio" class="uk-form-label">Título del sitio</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="title" data-id="1" value="'.$rowCONSULTA['title'].'" placeholder="'.$Brand.'">
						</div>
					</div>
				</div>
				<div class="padding-v-20">
					<label for="envio" class="uk-form-label">Descripción del sitio</label>
					<textarea class="editarajaxfocusout uk-textarea min-height-150" data-tabla="'.$seccion.'" data-campo="description" data-id="1">'.$rowCONSULTA['description'].'</textarea>
				</div>

				<div class="padding-v-20">
					<h3>Cuenta de PayPal</h3>
					<div uk-grid>
						<div>
							<label for="envio" class="uk-form-label">Email</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="paypalemail" data-id="1" value="'.$rowCONSULTA['paypalemail'].'" placeholder="business@efra.biz">
						</div>
					</div>
				</div>

				<div class="padding-v-20">
					<h3>Envío</h3>
					<div uk-grid>
						<div>
							<label for="envio" class="uk-form-label">Envio por pieza</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" id="envio" data-tabla="'.$seccion.'" data-campo="envio" data-id="1" value="'.$rowCONSULTA['envio'].'">
						</div>
					</div>
					<div uk-grid>
						<div>
							<label for="envioglobal" class="uk-form-label">Envio global</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" id="envioglobal" data-tabla="'.$seccion.'" data-campo="envioglobal" data-id="1" value="'.$rowCONSULTA['envioglobal'].'">
						</div>
					</div>
				</div>

				<div class="padding-v-20">
					<h3>Impuestos</h3>
					<div uk-grid>
						<div>
							<label for="iva" class="uk-form-label">IVA</label>
						</div>
						<div class="uk-width-expand">
							<input type="number" class="editarajax uk-input" id="iva" data-tabla="'.$seccion.'" data-campo="iva" data-id="1" value="'.$rowCONSULTA['iva'].'">
						</div>
					</div>
				</div>

				<!--div class="padding-v-20">
					<h3>Diseño</h3>
					<div uk-grid>
						<div>
							<label for="num2" class="uk-form-label">Productos por página</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" id="num2"  data-tabla="'.$seccion.'" data-campo="prodspag" data-id="1" value="'.$rowCONSULTA['prodspag'].'">
						</div>
					</div>
				</div-->
				<div class="padding-v-20">
					<h3>Datos para depósito</h3>
					<textarea class="editarajaxfocusout uk-textarea min-height-150" data-tabla="'.$seccion.'" data-campo="bank" data-id="1">'.$rowCONSULTA['bank'].'</textarea>
				</div>
				<div class="padding-v-20">
					<h3>Instrucciones de compra</h3>
					<textarea class="editarajaxfocusout uk-textarea min-height-150" data-tabla="'.$seccion.'" data-campo="instrucciones" data-id="1">'.$rowCONSULTA['instrucciones'].'</textarea>
				</div>
					<div class="padding-v-20">
					<h3>Instrucciones de compra ingles</h3>
					<textarea class="editarajaxfocusout uk-textarea min-height-150" data-tabla="'.$seccion.'" data-campo="instrucciones_eng" data-id="1">'.$rowCONSULTA['instrucciones_eng'].'</textarea>
				</div>
			</div>
		</div>
	</div>
</div>

';






$pic='../img/contenido/varios/'.$rowCONSULTA['imagen1'];
if(strlen($rowCONSULTA['imagen1'])>0 AND file_exists($pic)){
	$archivo='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic.'" target="_blank">
			<img src="'.$pic.'">
		</a><br><br>
		<button class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</button>
	</div>';
}else{
	$archivo='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
			Falta imagen para compartir<br><br>
		</p>
	</div>';
}

echo '
<div class="uk-width-1-1">
	<div class="margin-top-50 uk-text-center uk-container uk-container-xsmall">
		<h3>Imagen para compartir en redes</h3>
		Dimensiones recomendadas: 1000 x 1000 px<br><br>
		<div uk-grid>
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
</div>';





$scripts.='
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
				window.location = (\'index.php?seccion='.$seccion.'&frame='.$frame.'&campo=imagen1&fileuploaded=\'+data);
			}
		});
	});	




	// Borrar imagen
	$(".borrarpic").click(function() {
		var statusConfirm = confirm("Realmente desea borrar esto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&frame='.$frame.'&campo=imagen1&borrarpic=1&id='.$id.'");
		} 
	});

';



