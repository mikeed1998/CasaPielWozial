<?php 

echo '
<div class="uk-width-1-1 margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">Slider Superior</a></li>
	</ul>
</div>




<div style="width:400px;">
	<p class="uk-text-muted">(JPG de 400 x 400 px)</p>
	<div id="fileuploader">
		Cargar
	</div>
</div>

<div class="uk-width-expand@xl margin-top-20">
	<div uk-grid class="uk-grid-match uk-grid-small sortable" data-tabla="carousel">';

	$consulta = $CONEXION -> query("SELECT * FROM carousel ORDER BY orden");
	while ($rowConsulta = $consulta -> fetch_assoc()) {
		$id=$rowConsulta['id'];
		$file=$id.'.jpg';
		echo '
			<div id="'.$rowConsulta['id'].'" style="width:250px;">
				<div id="'.$rowConsulta['id'].'" class="uk-card uk-card-default uk-card-body uk-text-center">
					<a href="javascript:borrarfoto(\''.$file.'\',\''.$id.'\')" class="uk-icon-button uk-button-danger" uk-icon="trash"></a>
					<br><br>
					<a href="'.$rutaSlider.$rowConsulta['id'].'.jpg" target="_blank">
						<img src="'.$rutaSlider.$rowConsulta['id'].'.jpg" class="img-responsive uk-border-rounded margin-bottom-20">
					</a>
				</div>
			</div>';
	}

	echo '
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
