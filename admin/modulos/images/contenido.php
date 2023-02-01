<?php
echo '
	<div class="uk-width-1-2@s margen-v-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'" class="color-red">Imágenes</a></li>
		</ul>
	</div>';

echo '
	<div class="uk-width-1-2@s margen-v-20">
		<div>
			<div id="fileuploader">
				Cargar
			</div>
		</div>
	</div>';


echo '
	<div class="uk-width-1-1 uk-text-center">
		<div uk-grid class="uk-grid-small" id="app">';
		$filehandle = opendir($rutaFinal); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != ".DS_Store") {
				if(file_exists($rutaFinal.$file)){
					$id=str_replace(".","", $file);
					$fotos[$file] = '
					<div style="max-width:120px;" id="'.$id.'">
						<div class="uk-card uk-card-default uk-text-center">
							<div>
								<a href="javascript:borrarfoto(\''.$file.'\',\''.$id.'\')" class="uk-icon-button uk-button-danger" uk-icon="trash"></a>
							</div>
							<div>
								<a href="javascript:selection(\''.$id.'\')">
									<input type="text" value="img/contenido/images/'.$file.'" class="input'.$id.' uk-input uk-text-right" readonly>
								</a>
							</div>
							<div uk-lightbox>
								<a href="'.$rutaFinal.$file.'">
									<img data-src="'.$rutaFinal.$file.'" uk-img>
								</a>
							</div>
						</div>
					</div>';
				}
			}
		} 
		closedir($filehandle);

		if (isset($fotos)) {
			ksort($fotos);
			foreach ($fotos as $key => $value) {
				echo $value;
			}
		}


	echo '
		</div>
	</div>';



	echo '
	<div>
		<div id="buttons">
			<a href="#" id="borrartodo" class="uk-icon-button uk-button-danger" uk-icon="icon:trash;ratio:1.4;"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#menu-movil" class="uk-icon-button uk-button-primary uk-box-shadow-large uk-hidden@l" uk-icon="icon:menu;ratio:1.4;" uk-toggle></a>
		</div>
	</div>

	';





$scripts.='
	function borrarfoto (file,id) { 
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true) { 
			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					borrarfoto: 1,
					file: file
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
				$("#"+id).addClass( "uk-invisible" );
			});
		}
	}

	$("#borrartodo").click(function(){
		var statusConfirm = confirm("Realmente desea eliminar todos los archivos?"); 
		if (statusConfirm == true) {
			window.location = (\'index.php?rand='.rand(1,9999).'&seccion='.$seccion.'&borrartodo=1\');
		}
	});

	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"modulos/'.$seccion.'/acciones.php",
			multiple: true,
			maxFileCount:1000,
			fileName:"uploadedfile",
			allowedTypes: "jpeg,jpg,png,gif",
			maxFileSize: 6000000,
			showFileCounter: false,
			showDelete: "false",
			showPreview:false,
			showQueueDiv:true,
			returnType:"json",
			onSuccess:function(files,data,xhr){
				var id = Math.floor((Math.random() * 100000000) + 1);
				$("#app").prepend("';
					$scripts.='<div style=\'max-width:120px;\' id=\'"+id+"\'>';
						$scripts.='<div class=\'uk-card uk-card-default uk-text-center\'>';
							$scripts.='<div>';
								$scripts.='<a href=\'javascript:borrarfoto(\""+data+"\",\""+id+"\")\' class=\'uk-icon-button uk-button-danger\' uk-icon=\'trash\'></a>';
							$scripts.='</div>';
							$scripts.='<div>';
								$scripts.='<a href=\'javascript:selection(\""+id+"\")\'>';
									$scripts.='<input type=\'text\' value=\'img/contenido/images/"+data+"\' class=\'input"+id+" uk-input uk-text-right\' readonly\'>';
								$scripts.='</a>';
							$scripts.='</div>';
							$scripts.='<div uk-lightbox>';
								$scripts.='<a href=\''.$rutaFinal.'"+data+"\'>';
									$scripts.='<img src=\''.$rutaFinal.'"+data+"\'>';
								$scripts.='</a>';
							$scripts.='</div>';
						$scripts.='</div>';
					$scripts.='</div>';
				$scripts.='");';
				$scripts.='
			}
		});
	});



	function selection(id) {
		var copyText = document.querySelector(\'.input\'+id);
		copyText.select();
		try {
			var successful = document.execCommand("copy");
			var msg = successful ? "<div class=\'bg-success color-white\'><i uk-icon=\'icon:copy;ratio:1.5;\'></i> &nbsp; Copiado</div>" : "<div class=\'bg-danger color-white\'><i uk-icon=\'icon:warning;ratio:1.5;\'></i> &nbsp; No se pudo copiar</div>";

			UIkit.notification.closeAll();
			UIkit.notification(msg);
			
			console.log("Copying text command was " + msg);
		} catch (err) {
			console.log("Oops, unable to copy");
		}
	};

	';
