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
	<div class="uk-container uk-container-xsmall">
		<div>
			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label class="uk-form-label">Teléfono fijo</label>
					</div>
					<div class="uk-width-expand">
						<input type="number" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="telefono" data-id="1" value="'.$rowCONSULTA['telefono'].'">
					</div>
				</div>
			</div>
			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label class="uk-form-label">Whatsapp</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="telefono1" data-id="1" value="'.$rowCONSULTA['telefono1'].'">
					</div>
				</div>
			</div>


			<div class="margin-v-50">
				<h3>Redes sociales</h3>
			</div>

			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label for="facebook" class="uk-form-label">Facebook</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="facebook" data-id="1" value="'.$rowCONSULTA['facebook'].'">
					</div>
				</div>
			</div>
			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label for="instagram" class="uk-form-label">Instagram</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="instagram" data-id="1" value="'.$rowCONSULTA['instagram'].'">
					</div>
				</div>
			</div>
			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label for="youtube" class="uk-form-label">YouTube</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="youtube" data-id="1" value="'.$rowCONSULTA['youtube'].'">
					</div>
				</div>
			</div>

		</div>
		<div>

			<div class="margin-v-50">
				<h3>Envío de correo</h3>
			</div>

			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label for="destinatario1" class="uk-form-label">Destinatario 1</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="destinatario1" data-id="1" value="'.$rowCONSULTA['destinatario1'].'" placeholder="Obligatorio">
					</div>
				</div>
			</div>
			<div class="uk-margin">
				<div uk-grid>
					<div>
						<label for="destinatario2" class="uk-form-label">Destinatario 2</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="destinatario2" data-id="1" value="'.$rowCONSULTA['destinatario2'].'" placeholder="Opcional">
					</div>
				</div>
			</div>

			<div class="uk-width-1-1@m uk-margin">
				<div uk-grid>
					<div>
						<label for="remitente" class="uk-form-label">Remitente</label>
					</div>
					<div class="uk-width-expand">
						<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="remitente" data-id="1" value="'.$rowCONSULTA['remitente'].'">
					</div>
				</div>
			</div>

		</div>';
		$pic='../img/contenido/varios/'.$rowCONSULTA['imagen5'];
		if(strlen($rowCONSULTA['imagen5'])>0 AND file_exists($pic)){
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
					Falta imagen<br><br>
				</p>
			</div>';
		}

		echo '
		<div class="uk-width-1-1">
			<div class="margin-top-50 uk-text-center uk-container uk-container-xsmall">
				Dimensiones recomendadas: 1500 x 900 px<br><br>
				<div uk-grid>
					<div class="uk-width-1-2@s">
						<div id="fileuploadercontacto">
							Cargar
						</div>
					</div>
					<div class="uk-width-1-2@s uk-text-center margin-v-20">
						'.$archivo.'
					</div>
				</div>
			</div>
		</div>';
	echo '
	</div>
</div>
';

$scripts.='
$(document).ready(function() {
		$("#fileuploadercontacto").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: \'false\',
			allowedTypes: "jpg,jpeg,png,gif",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview:false,
			returnType:\'json\',
			onSuccess:function(data){ 
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen5&fileuploaded=\'+data);
			}
		});
	});	
';


$obsoleto='
		<div class="uk-margin">
			<div uk-grid>
				<div>
					<label for="remitente" class="uk-form-label">Remitente</label>
				</div>
				<div class="uk-width-expand">
					<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="remitente" data-id="1" value="'.$rowCONSULTA['remitente'].'" placeholder="">
				</div>
			</div>
		</div>
		<div class="uk-margin">
			<div uk-grid>
				<div>
					<label for="pass" class="uk-form-label">Contraseña</label>
				</div>
				<div class="uk-width-expand">
					<input type="password" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="pass" data-id="1" value="'.$rowCONSULTA['pass'].'">
				</div>
			</div>
		</div>
		<div class="uk-margin">
			<div uk-grid>
				<div>
					<label for="server" class="uk-form-label">Servidor</label>
				</div>
				<div class="uk-width-expand">
					<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="server" data-id="1" value="'.$rowCONSULTA['server'].'" placeholder="">
				</div>
			</div>
		</div>
		<div class="uk-margin">
			<div uk-grid>
				<div>
					<label for="port" class="uk-form-label">Puerto</label>
				</div>
				<div class="uk-width-expand">
					<input type="text" class="editarajax uk-input" data-tabla="'.$seccion.'" data-campo="port" data-id="1" value="'.$rowCONSULTA['port'].'" placeholder="">
				</div>
			</div>
		</div>';