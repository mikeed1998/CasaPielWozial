<?php
$seccion='inicio';
$rutaFinal='../img/contenido/varios/';
$rutaInicial="../library/upload-file/php/uploads/";
$rutaSlider="../img/contenido/carousel/";

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar imagenes     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if(isset($_GET['borrarimagen'])){
		$campo = (isset($_GET['campo']))?$_GET['campo']:'';

		$sql="SELECT * FROM $seccion WHERE id = 1";
		$CONSULTA = $CONEXION -> query($sql);
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$item=$rowCONSULTA[$campo];
		unlink($rutaFinal.$item);

		$sql="UPDATE $seccion SET $campo = '' WHERE id = $id";
		$actualizar = $CONEXION->query($sql);
	}

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir foto     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	if (isset($_GET['uploadedfile'])) {
		$campo=$_GET['campo'];

		//Obtenemos la extensión de la imagen
		$rutaInicial="../library/upload-file/php/uploads/";
		$imagenName=$_GET['uploadedfile'];
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));

		if(!file_exists($rutaInicial.$imagenName)){
			$fallo=1;
			$legendFail='<br>La imagen ya no está disponible';
		}

		// Guardar en la base de datos
		if (!isset($fallo)) {
			$sql="SELECT * FROM $seccion WHERE id = 1";
			$CONSULTA = $CONEXION -> query($sql);
			$rowCONSULTA = $CONSULTA -> fetch_assoc();
			$item=$rowCONSULTA[$campo];
			if (strlen($item)) {
				if(file_exists($rutaFinal.$item)){
					unlink($rutaFinal.$item);
				}
			}

			// Nombre al asar para evitar conflictos
			$imgFinal=date('Ymd').rand(1,9999).'.'.$ext;
			if(file_exists($rutaFinal.$imgFinal)){
				$imgFinal=date('Ymd').rand(1,9999).'.'.$ext;
			}

			// Guardar en la base de datos
			$sql = "UPDATE $seccion SET $campo = '$imgFinal' WHERE id = 1";
			$actualizar = $CONEXION->query($sql);
			copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
			$exito=1;
		}

		// Borramos las imágenes que estén remanentes en el directorio de subida
		$filehandle = opendir($rutaInicial); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != "..") {
				if(file_exists($rutaInicial.$file)){
					unlink($rutaInicial.$file);
				}
			}
		} 
		// Fin lectura archivos
		closedir($filehandle); 
	}

// SLIDER TEXTO
	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Nuevo Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		if(isset($_POST['nuevoslidedetexto'])){ 
			// Insertar en la base de datos
			$sql = "INSERT INTO slidertxt (orden) VALUES (99)";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
				$editarNuevo=1;
				$id=$CONEXION->insert_id;
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos";
			}
		}

	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar Artículo     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		if(isset($_REQUEST['editarslidertexto']) OR isset($editarNuevo)) {
			if (isset($_POST['id'])) {
				$id=$_POST['id'];
			}
			foreach ($_POST as $key => $value) {
				$dato = trim(htmlentities($value, ENT_QUOTES));
				$sql="UPDATE slidertxt SET $key = '$dato' WHERE id = $id";
				//$legendSuccess.='<br>'.$sql;
				$actualizar = $CONEXION->query($sql);
				$exito=1;
				unset($fallo);
			}
		}

	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Imagen      	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		if(isset($_POST['borrarslidetexto'])){
			include '../../../includes/connection.php';
			$id=$_POST['id'];
			// Borramos de la base de datos
			if($borrar = $CONEXION->query("DELETE FROM slidertxt WHERE id = $id")){
				$mensajeClase='success';
				$mensajeIcon='check';
				$mensaje='Eliminado';
			}else{
				$mensajeClase='danger';
				$mensajeIcon='ban';
				$mensaje='No se pudo guardar';
			}

			echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
		}



//	SLIDER CIRCULO

	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar Imagen      	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		if(isset($_POST['borrarslider'])){
			include '../../../includes/connection.php';
			$id=$_POST['id'];
			// Borramos de la base de datos
			if($borrar = $CONEXION->query("DELETE FROM carousel WHERE id = $id")){
				$legendSuccess.= "<br> Imagen eliminada";
				$exito='success';
			}else{
				$legendFail .= "<br>No se pudo borrar de la base de datos";
				$fallo='danger';  
			}
			// Borramos el archivo de imagen
			$rutaSlider="../../../img/contenido/carousel/";
			$filehandle = opendir($rutaSlider); // Abrir archivos
			while ($file = readdir($filehandle)) {
				if ($file != "." && $file != "..") {
					// Id de la imagen
					if (strpos($file,'-')===false) {
						$imagenID = strstr($file,'.',TRUE);
					}else{
						$imagenID = strstr($file,'-',TRUE);
					}
					// Comprobamos que sean iguales
					if($imagenID==$id){
						$pic=$rutaSlider.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
			if (isset($exito)) {
				$mensajeClase='success';
				$mensajeIcon='check';
				$mensaje='Eliminado';
			}else{
				$mensajeClase='danger';
				$mensajeIcon='ban';
				$mensaje='No se pudo guardar';
			}

			echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
		}

	//%%%%%%%%%%%%%%%%%%%%%%%%%%    Subir Imagen     	 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		if(isset($_GET['imagenslider'])){
			//Obtenemos la extensión de la imagen
			$imagenName=$_GET['imagenslider'];
			$i = strrpos($imagenName,'.');
			$l = strlen($imagenName) - $i;
			$ext = strtolower(substr($imagenName,$i+1,$l));


			// Imagenes a crear
			$xs=0;
			$sm=0;
			$med=0;
			$og=0;
			$nat400=0;
			$nat800=1;
			$nat1500=0;
			$Otra=0;

			// Dimensiones
			// Small
			$anchoXS=100;
			$altoXS =100;
			// Small
			$anchoSM=250;
			$altoSM =250;
			// Mediana
			$anchoMED=500;
			$altoMED =500;
			// OG
			$anchoOG=1000;
			$altoOG =700;
			// Otra
			$anchoOtra=1920;
			$altoOtra =780;



			// Si no es JPG cancelamos
			if ($ext!='jpg' and $ext!='jpeg') {
				$fallo=1;
				$legendFail='<br>El archivo debe ser JPG';
			}

			if(!file_exists($rutaInicial.$imagenName)){
				$fallo=1;
				$legendFail='<br>No se permite refrescar la página.';
			}

			if (!isset($fallo)) {
				$sql = "INSERT INTO carousel (orden) VALUES ('99')";
				if($insertar = $CONEXION->query($sql)){

					$pic = $CONEXION->insert_id;
					$imgAux=$rutaSlider.$pic."-orig.jpg";

					// Lo movemos al directorio final
					copy($rutaInicial.$imagenName, $imgAux);
					unlink($rutaInicial.$imagenName);


					// Leer el archivo para hacer la nueva imagen
					if ($ext=='jpg' or $ext=='jpeg') $original = imagecreatefromjpeg($imgAux);

					// Tomamos las dimensiones de la imagen original
					$ancho  = imagesx($original);
					$alto   = imagesy($original);

					if ($xs==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Pequeña
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-xs.jpg";

						$anchoNew=$anchoXS;
						$altoNew =$altoXS;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el contenido de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el contenido de la imagen
						if(imagejpeg($New,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($sm==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Pequeña
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-sm.jpg";

						$anchoNew=$anchoSM;
						$altoNew =$altoSM;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el contenido de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el contenido de la imagen
						if(imagejpeg($New,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($med==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen Mediana
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-med.jpg";

						$anchoNew=$anchoMED;
						$altoNew =$altoMED;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el contenido de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el contenido de la imagen
						if(imagejpeg($New,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen pequeña agregada";
						}
					}

					if ($og==1) {
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						//  Imagen OG
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
						$newName=$pic."-og.jpg";

						$anchoNew=$anchoOG;
						$altoNew =$altoOG;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($alto/$ancho>(.7)){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$xinicial= -$excedente/2;
						}else{
							// Alto proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$yinicial= -$excedente/2;
						}

						// Copiamos el contenido de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						if(isset($xinicial)){
							imagecopyresampled($New,$original,$xinicial,0,0,0,$anchoProporcional,$altoNew,$ancho,$alto);
						}else{
							imagecopyresampled($New,$original,0,$yinicial,0,0,$anchoNew,$altoProporcional,$ancho,$alto);
						}

						// Pegamos el contenido de la imagen
						if(imagejpeg($New,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen OG agregada";
						}
					}

					if ($nat400==1) {
						//  Imagen nat400
						$newName=$pic."-nat400.jpg";
						$anchoNuevo = 400;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;

						// Creamos la imagen
						$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
						// Copiamos el contenido de la original para pegarlo en el archivo nuevo
						imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
						// Pegamos el contenido de la imagen
						if(imagejpeg($imagenAux,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
						}
					}

					if ($nat800==1) {
						//  Imagen nat1000
						$newName    = $pic.".jpg";
						$anchoNuevo = 800;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;

						// Creamos la imagen
						$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
						// Copiamos el contenido de la original para pegarlo en el archivo nuevo
						imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
						// Pegamos el contenido de la imagen
						if(imagejpeg($imagenAux,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
						}
					}

					if ($nat1500==1) {
						//  Imagen nat1500
						$newName=$pic."-nat1500.jpg";
						if ($ancho>$alto) {
							$anchoNuevo = 1500;
							$altoNuevo  = $anchoNuevo*$alto/$ancho;
						}else{
							$altoNuevo  = 1500;
							$anchoNuevo = $altoNuevo*$ancho/$alto;
						}

						// Creamos la imagen
						$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
						// Copiamos el contenido de la original para pegarlo en el archivo nuevo
						imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
						// Pegamos el contenido de la imagen
						if(imagejpeg($imagenAux,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
						}
					}

					if ($Otra==1) {
						//  Imagen Otra
						$newName=$pic."-otra.jpg";
						$anchoNew=$anchoOtra;
						$altoNew =$altoOtra;
						$dst_x=0;
						$dst_y=0;
						$src_x=0;
						$src_y=0;
						$dst_w=$ancho;
						$dst_h=$alto;
						$src_w=$ancho;
						$src_h=$alto;

						// Proporcionalmente, la imagen es más ancha que la de destino
						if($ancho/$alto>$anchoNew/$altoNew){
							// Ancho proporcional
							$anchoProporcional=$ancho/$alto*$altoNew;
							// Corregimos el ancho
							$dst_w=$anchoProporcional;
							// Corregimos el ancho
							$dst_h=$altoNew;
							// Excedente 
							$excedente=$anchoProporcional-$anchoNew;
							// Posición inicial de la coordenada x
							$src_x= $excedente/2;
							//$legendSuccess.='<br>Opt 2';
						}else{
							// Ancho proporcional
							$altoProporcional=$alto/$ancho*$anchoNew;
							// Corregimos el alto
							$dst_h=$altoProporcional;
							// Corregimos el ancho
							$dst_w=$anchoNew;
							// Excedente
							$excedente=$altoProporcional-$altoNew;
							// Posición inicial de la coordenada y
							$src_y= $excedente/4;
							//$legendSuccess.='<br>Opt 2';
							//$legendSuccess.='<br>Alto Original: '.$alto;
							//$legendSuccess.='<br>Alto Nuevo: '.$altoNew;
							//$legendSuccess.='<br>Alto Proporcional: '.$altoProporcional;
							//$legendSuccess.='<br>Excedente: '.$excedente;
							//$legendSuccess.='<br>Src Y: '.$src_y;
						}

						// Copiamos el contenido de la original para pegarlo en el archivo New
						$New = imagecreatetruecolor($anchoNew,$altoNew); 

						imagecopyresampled($New,$original,$dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);

						// Pegamos el contenido de la imagen
						if(imagejpeg($New,$rutaSlider.$newName,90)){ // 90 es la calidad de compresión
							$exito=1;
							//$legendSuccess .= "<br>Imagen Otra agregada";
						}
					}

					if ($originalPic==0) {
						unlink($imgAux);
					}else{
						rename ($imgAux, $rutaSlider.$pic."-orig.jpg");
					}

					if($exito==1){
						$legendSuccess .= "<br>Imagen actualizada";
					}
				}else{
					$fallo=1;
					$legendFail='<br>No se pudo guardar en la base de datos';
				}
			}

		}

// BECAS
	if(isset($_POST['editartextobeca'])){
		$id = 1;
		foreach ($_POST as $key => $value) {
			if($key == "titulo1" OR $key == "texto1" OR $key == "titulo3" OR $key == "titulo4") {
				$dato = trim(htmlentities($value, ENT_QUOTES));
			}
			else{
				$dato = trim(str_replace("'", "&#039;", $value));
			}
			$sql="UPDATE $seccion SET $key = '$value' WHERE id = $id";
			$actualizar = $CONEXION->query($sql);
			//$exito = 1;
			//$legendSuccess.= "<br>".$sql;
		}
	}







