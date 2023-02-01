<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $CONSULTA -> fetch_assoc();

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">Nosotros</a></li>
	</ul>
</div>




<div class="uk-width-1-1">
	<div class="uk-container">
		<div uk-grid class="uk-grid-large">

			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Nosotros
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about1">'.$rowCONSULTA['about1'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Variedad
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about2">'.$rowCONSULTA['about2'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Trabajo
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about3">'.$rowCONSULTA['about3'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

		</div>
		<h2>Textos en Ingles</h2>
		<div uk-grid class="uk-grid-large">
			
			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Nosotros
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about1_en">'.$rowCONSULTA['about1_en'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Variedad
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about2_en">'.$rowCONSULTA['about2_en'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

			<div class="uk-width-1-3@l margin-v-50 uk-text-left">
				Trabajo
				<form action="index.php" method="post">
					<input type="hidden" name="seccion" value="'.$seccion.'">
					<input type="hidden" name="editartextosconformato" value="1">
					<input type="hidden" name="subseccion" value="about">
					<textarea class="editor min-height-150" name="about3_en">'.$rowCONSULTA['about3_en'].'</textarea>
					<br>
					<div class="uk-text-center">
						<button class="uk-button uk-button-primary">Guardar</button>
					</div>
				</form>
			</div>

		</div>';


		$pic='../img/contenido/varios/'.$rowCONSULTA['imagen2'];
		if(strlen($rowCONSULTA['imagen2'])>0 AND file_exists($pic)){
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
				Dimensiones recomendadas: 420 x 630 px<br><br>
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


		$pic2='../img/contenido/varios/'.$rowCONSULTA['imagen4'];
		if(strlen($rowCONSULTA['imagen4'])>0 AND file_exists($pic2)){
			$archivo2='
			<div class="uk-panel uk-text-center">
				<a href="'.$pic2.'" target="_blank">
					<img src="'.$pic2.'">
				</a><br><br>
				<button class="uk-button uk-button-danger uk-button-large borrarpic"><i uk-icon="icon:trash"></i> Eliminar</button>
			</div>';
		}else{
			$archivo2='
			<div class="uk-panel uk-text-center">
				<p class="uk-scrollable-box"><i uk-icon="icon:warning;ratio:5;"></i><br><br>
					Falta imagen<br><br>
				</p>
			</div>';
		}

		echo '
		<div class="uk-width-1-1">
			<div class="margin-top-50 uk-text-center uk-container uk-container-xsmall">
				Dimensiones recomendadas: 420 x 630 px<br><br>
				<div uk-grid>
					<div class="uk-width-1-2@s">
						<div id="fileuploader2">
							Cargar
						</div>
					</div>
					<div class="uk-width-1-2@s uk-text-center margin-v-20">
						'.$archivo2.'
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
		$("#fileuploader").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen2&fileuploaded=\'+data);
			}
		});
	});	


	$(document).ready(function() {
		$("#fileuploader2").uploadFile({
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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen4&fileuploaded=\'+data);
			}
		});
	});	

	// Borrar imagen
	$(".borrarpic").click(function() {
		var statusConfirm = confirm("Realmente desea borrar esto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&campo=imagen2&borrarpic=1&id='.$id.'");
		} 
	});

';