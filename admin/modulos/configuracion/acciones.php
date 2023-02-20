<?php
	$rutaInicial="../library/upload-file/php/uploads/";
	$rutaFinal='../img/contenido/varios/';
	$rutaSlider="../img/contenido/carousel/";

// *****************************
// Textos del editor    
// *****************************
	if (isset($_POST['editartextosconformato'])) {
		foreach ($_POST as $key => $value) {
			$dato = trim(str_replace("'", "&#039;", $value));
			$actualizar = $CONEXION->query("UPDATE $seccion SET $key = '$dato' WHERE id = 1");
			$exito=1;
			unset($fallo);
		}
	}
	if (isset($_POST['editartextos'])) {
		foreach ($_POST as $key => $value) {
			$dato = trim(htmlentities($value, ENT_QUOTES));
			$actualizar = $CONEXION->query("UPDATE $seccion SET $key = '$dato' WHERE id = 1");
			$exito=1;
			unset($fallo);
		}
	}




// *****************************
//	Archivos
// *****************************
// Borrar archivos      
	if(isset($_REQUEST['borrarpic'])){
		$campo=$_GET['campo'];

		$CONSULTA = $CONEXION -> query("SELECT $campo FROM $seccion WHERE id = 1");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();

		if (strlen($row_CONSULTA[$campo])>0) {
			$pic=$rutaFinal.$row_CONSULTA[$campo];
			if(file_exists($pic)){
				unlink($pic);
				$legendSuccess.='<br>Archivo eliminado: '.$row_CONSULTA[$campo];
			}else{
				$legendSuccess.='<br>Archivo no encontrado';
			}
			$actualizar = $CONEXION->query("UPDATE $seccion SET $campo = NULL WHERE id = 1");
			$exito=1;
		}else{
			$legendFail .= "<br>No se encontró el archivo en la base de datos: ".$row_CONSULTA[$campo];
			$fallo=1;
		}
	}

// Subir archivos       
	if(isset($_GET['fileuploaded'])){

		$imagenName=$_GET['fileuploaded'];

		$campo=$_GET['campo'];

		// Verificar que la imagen existe
		if(!file_exists($rutaInicial.$imagenName)){
			$fallo=1;
			$legendFail='<br>No se permite refrescar la página.';
		}

		// Extensión de la imagen
		if (!isset($fallo)) {
			$i = strrpos($imagenName,'.');
			$l = strlen($imagenName) - $i;
			$ext = strtolower(substr($imagenName,$i+1,$l));
		}

		// Guardar en la base de datos
		if (!isset($fallo)) {

			// Nombre del nuevo archivo
			$rand=rand(111111111,999999999);
			$imgFinal=$rand.'.'.$ext;
			// Si el nombre ya está en usado, definir otro
			if(file_exists($rutaFinal.$imgFinal)){
				$imgFinal=$rand.'.'.$ext;
			}

			// Obtenemos el nombre del archivo anterior
			$CONSULTA = $CONEXION -> query("SELECT $campo FROM $seccion WHERE id = 1");
			$row_CONSULTA = $CONSULTA -> fetch_assoc();
			// Si existe, lo borramos
			if ($row_CONSULTA[$campo]!='' AND file_exists($rutaFinal.$row_CONSULTA[$campo])) {
				unlink($rutaFinal.$row_CONSULTA[$campo]);
			}

			// Copiar el archivo a su nueva ubicación
			copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
			$actualizar = $CONEXION->query("UPDATE $seccion SET $campo = '$imgFinal' WHERE id = 1");
			
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





// *****************************
//	FAQ
// *****************************
//	Nuevo Artículo      
	if(isset($_POST['nuevo']) && isset($_POST['pregunta'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['pregunta']))	{ $pregunta=htmlentities($_POST['pregunta'], ENT_QUOTES);	}else{	$pregunta=''; }
		if (isset($_POST['respuesta']))	{ $respuesta=str_replace("'", "&#039;", $_POST['respuesta']);	}else{	$respuesta=''; }

		// Actualizamos la base de datos
		if($pregunta!=""){

			$legendFail.='<br>'.$pregunta;

			$sql = "INSERT INTO faq (pregunta,respuesta,orden)".
				"VALUES ('$pregunta','$respuesta','99')";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
				$id=$CONEXION->insert_id;
				$legendSuccess .= '<br>Pregunta nueva';
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>Está vacío";
		}
	}

//	Editar Artículo     
	if(isset($_POST['editar']) && isset($_POST['pregunta'])){

	    // Obtenemos los valores enviados
		if (isset($_POST['pregunta']))	{ $pregunta=htmlentities($_POST['pregunta'], ENT_QUOTES);	}else{	$pregunta=''; }
		if (isset($_POST['respuesta']))	{ $respuesta=str_replace("'", "&#039;", $_POST['respuesta']);	}else{	$respuesta=''; }


		if(
				$actualizar = $CONEXION->query("UPDATE faq SET 
					pregunta = '$pregunta',
					respuesta  = '$respuesta' 
					WHERE id = $id")
			){
			$exito=1;
			$legendSuccess.='<br>'.$pregunta;
		    $subseccion='contenido';
		}else{
			$fallo=1;  
			$legendFail .= "<br>No se pudo modificar la base de datos";
		}
	}

//	Borrar Artículo     
	if(isset($_REQUEST['borrarFaq'])){
		if($borrar = $CONEXION->query("DELETE FROM faq WHERE id = $id")){
			$exito=1;
			$legendSuccess .= "<br>Pregunta eliminada";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}




// *****************************
//	USUARIOS
// *****************************

//	Nuevo Administrador 
	if(isset($_REQUEST['new-user'])){
		if(isset($_REQUEST['user'])){ $user=strtolower($_REQUEST['user']); }else{ $user=false; $legendFail.="<br><br>Proporcione nombre de usuario";}
		if(isset($_REQUEST['pass'])){ $pass=$_REQUEST['pass']; }else{ $pass=false; $legendFail.="<br><br>Proporcione contraseña";}
		if(isset($_REQUEST['pass1'])){ $pass1=$_REQUEST['pass1']; }else{ $pass1=false; $legendFail.="<br><br>Confirme su contraseña";}
		if(strlen($pass)>5){
			if($pass==$pass1 and $user!=false){
				$pass_encripted = md5($pass);

				$USER = $CONEXION -> query("SELECT * FROM user WHERE user = '$user'");
				$numRows = $USER ->num_rows;
				if ($numRows==0) {

					$sql = "INSERT INTO user (pass,user,nivel)".
						"VALUES ('$pass_encripted','$user',1)";
					if($insertar = $CONEXION->query($sql))
					{
						$exito='success';
						$legendSuccess.="<br>Administrador agregado";
					}else{
						$fallo='danger';  
						$legendFail.="<br>No se pudo agregar el Administrador";
					}
				}else{
					$fallo='danger';  
					$legendFail.="<br>El usuario ya existe";
				}
			}else{
				$fallo='danger';  
				$legendFail.="<br>Las contraseñas no coinciden ";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>La contraseña es demasiado débil ";
		}
	}

//	Editar Administrador
	if(isset($_REQUEST['edit-user'])){
		if(isset($_REQUEST['user'])){ $user=strtolower($_REQUEST['user']); }else{ $user=false; $legendFail.="<br><br>Proporcione nombre de usuario";}
		if(isset($_REQUEST['pass'])){ $pass=$_REQUEST['pass']; }else{ $pass=false; $legendFail.="<br><br>Proporcione contraseña";}
		if(isset($_REQUEST['pass1'])){ $pass1=$_REQUEST['pass1']; }else{ $pass1=false; $legendFail.="<br><br>Confirme su contraseña";}
		if(strlen($pass)>5){
			if($pass==$pass1){
				$pass_encripted = md5($pass);

				if(
					$actualizar = $CONEXION->query("UPDATE user SET user = '$user' WHERE id = $id")
				and	$actualizar = $CONEXION->query("UPDATE user SET pass = '$pass_encripted' WHERE id = $id")
					)
				{
					$exito='success';
					$legendSuccess.="<br>Administrador editado";
				}else{
					$fallo='danger';  
					$legendFail.="<br>No se pudo modificar el Administrador";
				}
			}else{
				$fallo='danger';  
				$legendFail.="<br>Contraseñas no coinciden";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>Contraseña demasiado débil";
		}
	}

//	Borrar Administrador
	if(isset($_REQUEST['borrarUser'])){
		if($borrar = $CONEXION->query("DELETE FROM user WHERE id = $id"))
		{
			$exito='success';
			$legendSuccess.="<br>Administrador eliminado";
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo eliminar el Administrador";
		}
	} 

//	Editar nivel        
	if (isset($_POST['editanivel'])) {
		include '../../../includes/connection.php';
		
		$id = $_POST['id'];
		$nivel = $_POST['nivel'];

		$actualizar = $CONEXION->query("UPDATE user SET nivel = $nivel WHERE id = $id");
	}


	// Agregar cupón
	if(isset($_POST['codigo'])) {
        $codigo = $_POST['codigo'];
        $txt = $_POST['txt'];
        $descuento = $_POST['descuento'];
        $vigencia = $_POST['vigencia'];

        $agregar = $CONEXION->query("INSERT INTO cupones(codigo, txt, descuento, vigencia, usos, estatus) VALUES ('$codigo', '$txt', '$descuento', '$vigencia', 0, 1)");
    }

	if(isset($_POST['id_cupon'])) {
		$id_c = $_POST['id_cupon'];
		$eliminacion = "DELETE FROM cupones WHERE id = '$id_c'";
	}

	// Eliminar cupón



// *****************************
//	SLIDER INICIO
// *****************************

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
		$xs=1;
		$sm=0;
		$med=0;
		$og=0;
		$nat400=0;
		$nat800=1;
		$nat1500=1;
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
					$newName    = $pic."-nat800.jpg";
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
					$newName=$pic.".jpg";
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




