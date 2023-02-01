<?php 
$anim0='';
$anim1='';
$anim2='';
$anim3='';
$anim4='';
$anim5='';
$anim6='';
$anim7='';
$ANIM = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$rowCONSULTA = $ANIM -> fetch_assoc();
switch ($rowCONSULTA['slideranim']) {
	case 0:
		$anim0=' selected';
		break;
	case 1:
		$anim1=' selected';
		break;
	case 2:
		$anim2=' selected';
		break;
	case 3:
		$anim3=' selected';
		break;
	case 4:
		$anim4=' selected';
		break;
	case 5:
		$anim5=' selected';
		break;
	case 6:
		$anim6=' selected';
		break;
	case 7:
		$anim7=' selected';
		break;
}

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">'.$subseccion.'</a></li>
	</ul>
</div>




<div class="uk-width-1-1">
	<div class="uk-container">
			<div uk-grid>
				<div class="uk-width-1-2@s margin-top-20 uk-text-left">
					<div uk-grid>
						<div>
							<label class="uk-form-label">Animación</label>
						</div>
						<div class="uk-width-expand">
							<select class="uk-select selector" data-tabla="configuracion" data-id="1" data-campo="slideranim">
								<option value="0" '.$anim0.'>Desvanecer</option>
								<option value="1" '.$anim1.'>Desplazar</option>
								<option value="2" '.$anim2.'>Agrandar</option>
								<option value="3" '.$anim3.'>Jalar</option>
								<option value="4" '.$anim4.'>Empujar</option>
							</select>
						</div>
					</div>
					<div uk-grid>
						<div>
							<label class="uk-form-label">Proporción</label>
						</div>
						<div class="uk-width-expand">
							<select class="uk-select selector" data-tabla="configuracion" data-id="1" data-campo="sliderproporcion">
								<option value="1:1" '; if ($rowCONSULTA['sliderproporcion']=="1:1") { echo 'selected'; } echo '>1:1 (1)</option>
								<option value="5:4" '; if ($rowCONSULTA['sliderproporcion']=="5:4") { echo 'selected'; } echo '>5:4 (.8)</option>
								<option value="5:3" '; if ($rowCONSULTA['sliderproporcion']=="5:3") { echo 'selected'; } echo '>5:3 (.6)</option>
								<option value="2:1" '; if ($rowCONSULTA['sliderproporcion']=="2:1") { echo 'selected'; } echo '>2:1 (.5)</option>
								<option value="5:2" '; if ($rowCONSULTA['sliderproporcion']=="5:2") { echo 'selected'; } echo '>5:2 (.4)</option>
								<option value="3:1" '; if ($rowCONSULTA['sliderproporcion']=="3:1") { echo 'selected'; } echo '>3:1 (.33)</option>
								<option value="7:2" '; if ($rowCONSULTA['sliderproporcion']=="7:2") { echo 'selected'; } echo '>7:2 (.29)</option>
								<option value="4:1" '; if ($rowCONSULTA['sliderproporcion']=="4:1") { echo 'selected'; } echo '>4:1 (.25)</option>
								<option value="5:1" '; if ($rowCONSULTA['sliderproporcion']=="5:1") { echo 'selected'; } echo '>5:1 (.2)</option>
							</select>
						</div>
					</div>
					<div uk-grid>
						<div>
							<label for="minimo" class="uk-form-label">Alto mínimo</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="configuracion" data-campo="sliderhmin" data-id="1" value="'.$rowCONSULTA['sliderhmin'].'" placeholder="200">
						</div>
					</div>
					<div uk-grid>
						<div>
							<label for="maximo" class="uk-form-label">Alto máximo</label>
						</div>
						<div class="uk-width-expand">
							<input type="text" class="editarajax uk-input" data-tabla="configuracion" data-campo="sliderhmax" data-id="1" value="'.$rowCONSULTA['sliderhmax'].'" placeholder="600">
						</div>
					</div>
				</div>

				<div class="uk-width-1-2@s margin-top-20 uk-text-left">
					<p class="uk-text-muted">(Dimensiones aconsejadas: 1900 x 700 px)</p>
					<div id="fileuploader">
						Cargar
					</div>
				</div>

				<div class="uk-width-1-1 margin-top-20">
					<div uk-grid class="uk-grid-match uk-grid-small uk-child-width-1-6@l uk-child-width-1-4@m uk-child-width-1-2 sortable" data-tabla="carousel">';

						$consulta = $CONEXION -> query("SELECT * FROM carousel ORDER BY orden");
						while ($rowConsulta = $consulta -> fetch_assoc()) {
							$id=$rowConsulta['id'];
							$file=$id.'.jpg';
							echo '
								<div id="'.$rowConsulta['id'].'">
									<div id="'.$rowConsulta['id'].'" class="uk-card uk-card-default uk-card-body uk-text-center">
										<a href="javascript:borrarfoto(\''.$file.'\',\''.$id.'\')" class="uk-icon-button uk-button-danger" uk-icon="trash"></a>
										<br><br>
										<a href="'.$rutaSlider.$rowConsulta['id'].'.jpg" target="_blank">
											<img src="'.$rutaSlider.$rowConsulta['id'].'.jpg" class="img-responsive uk-border-rounded margin-bottom-20">
										</a>
									</div>
								</div>
						';
						}
						echo '
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';


$scripts='
	// Eliminar foto
	function borrarfoto (file,id) { 
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true) { 
			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					borrarslider: 1,
					id: id
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
				$("#"+id).addClass( "uk-invisible" );
			});
		}
	}

	var imagenesArray = [];
	$("#fileuploader").uploadFile({
		url:"../library/upload-file/php/upload.php",
		fileName:"myfile",
		maxFileCount:1,
		showDelete: "false",
		allowedTypes: "jpeg,jpg",
		maxFileSize: 6291456,
		showFileCounter: false,
		showPreview:false,
		returnType:"json",
		onSuccess:function(data){ 
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&imagenslider="+data);
		}
	});
';



?>
