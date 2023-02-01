<?php
	$seccion='productos';
	$seccioncat=$seccion.'cat';
	$seccionpic=$seccion.'pic';
	$seccionmain=$seccion.'main';
	$rutaFinal='../img/contenido/'.$seccion.'/';

//    Artículo Nuevo                    
	if(isset($_POST['nuevo'])){ 
		// Actualizamos la base de datos
		if(!isset($fallo)){
			$sql = "INSERT INTO $seccion (fecha) VALUES ('$hoy')";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
				$legendSuccess .= "<br>Producto nuevo";
				$editarNuevo=1;
				$id=$CONEXION->insert_id;
				$subseccion='detalle';
			}else{
				$fallo=1;  
				$legendFail .= "<br>No se pudo agregar a la base de datos - $cat";
			}
		}else{
			$legendFail .= "<br>La categoría o marca están vacíos.";
		}
	}

//    Artículo Editar                   
	if(isset($_REQUEST['editar']) OR isset($editarNuevo)) {
		// Obtenemos los valores enviados

		$fallo=1;  
		$legendFail .= "<br>No se pudo modificar la base de datos";
		foreach ($_POST as $key => $value) {
			if ($key=='txt') {
				$dato = trim(str_replace("'", "&#039;", $value));
			}else{
				$dato = trim(htmlentities($value, ENT_QUOTES));
			}
			if ($actualizar = $CONEXION->query("UPDATE $seccion SET $key = '$dato' WHERE id = $id")) {
				$exito=1;
				if (isset($fallo)) {
					unset($fallo);
				}
			}
		}
	}


//    Artículo Borrar                   
	if(isset($_REQUEST['borrarPod'])){
		$consulta= $CONEXION -> query("SELECT * FROM $seccionpic WHERE producto = $id");
		while ($rowConsulta = $consulta-> fetch_assoc()) {
			$picID=$rowConsulta['id'];
			// Borramos el archivo de imagen
			$rutaIMG="../img/contenido/".$seccion."/";
			$filehandle = opendir($rutaIMG); // Abrir archivos
			while ($file = readdir($filehandle)) {
				if ($file != "." && $file != "..") {
					// Id de la imagen
					if (strpos($file,'-')===false) {
						$imagenID = strstr($file,'.',TRUE);
					}else{
						$imagenID = strstr($file,'-',TRUE);
					}
					// Comprobamos que sean iguales
					if($imagenID==$picID){
						$pic=$rutaIMG.$file;
						$exito=1;
						unlink($pic);
					}
				}
			}
		}

		if($borrar = $CONEXION->query("DELETE FROM $seccion WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM $seccionpic WHERE producto = $id");
			$exito=1;
			$legendSuccess .= "<br>Producto eliminado";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//    Categoria Nueva                   
	if(isset($_POST['nuevacategoria'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['categoria'])) { $categoria=$_POST['categoria'];   }else{	$categoria=false; $fallo=1; }
		if (isset($_POST['cat'])) { $cat=$_POST['cat']; }else{ $cat=false; $fallo=1; }
		if (isset($_POST['categoria_en'])) { $categoriaEn=$_POST['categoria_en'];   }else{	$categoriaEn=false; $fallo=1; }
		// Sustituimos los caracteres inválidos
		$categoria=(htmlentities($categoria, ENT_QUOTES));
		$categoriaEn=(htmlentities($categoriaEn, ENT_QUOTES));

		// Actualizamos la base de datos
		if($categoria!=""){
			$sql = "INSERT INTO $seccioncat (txt,parent,txt_en) VALUES ('$categoria',$cat,'$categoriaEn')";
			if($insertar = $CONEXION->query($sql)){
				$cat = $CONEXION->insert_id;
				$exito=1;
				$legendSuccess .= "<br>Nueva categoria";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Sub Categoria Nueva               
	if(isset($_POST['nuevasubcategoria'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['categoria'])) { $categoria=$_POST['categoria'];   }else{	$categoria=false; $fallo=1; }
		if (isset($_POST['categoriaEn'])) { $categoriaEn=$_POST['categoriaEn'];   }else{	$categoriaEn=false; $fallo=1; }
		// Sustituimos los caracteres inválidos
		$categoria=htmlentities($categoria, ENT_QUOTES);
		$categoriaEn=(htmlentities($categoriaEn, ENT_QUOTES));

		// Actualizamos la base de datos
		if($categoria!=""){
			$sql = "INSERT INTO $seccioncat (txt,parent,txt_en) VALUES ('$categoria',$cat,'$categoriaEn')";
			if($insertar = $CONEXION->query($sql)){
				$id = $CONEXION->insert_id;
				$exito=1;
				$legendSuccess .= "<br>Nueva subcategoria";
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo agregarse a la base de datos ".$seccioncat.'-'.$cat.'-'.$categoria;
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Categoría Borrar                  
	if(isset($_REQUEST['eliminarCat'])){
		if($borrar = $CONEXION->query("DELETE FROM $seccioncat WHERE id = $id")){
			$exito=1;
			$legendSuccess .= "<br>Categoría eliminada";
		}else{
			$legendFail .= "<br>No se pudo borrar de la base de datos";
			$fallo=1;  
		}
	}

//    Color Nuevo                       
	if(isset($_POST['nuevocolor'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['txt'])) { $txt=$_POST['txt'];   }else{	$txt=false; $fallo=1; }

		// Sustituimos los caracteres inválidos
		$txt=htmlentities($txt, ENT_QUOTES);

		// Actualizamos la base de datos
		if($txt!=""){
			$sql = "INSERT INTO productoscolor (txt) VALUES ('$txt')";
			if($insertar = $CONEXION->query($sql)){
				$cat = $CONEXION->insert_id;
				$exito=1;
				$legendSuccess .= "<br>Nuevo color";
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo agregarse a la base de datos $txt";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Talla Nueva                       
	if(isset($_GET['nuevatalla'])){ 
		// Obtenemos los valores enviados
		if (isset($_GET['txt'])) { $txt=strtoupper($_GET['txt']);   }else{	$txt=false; $fallo=1; }
		if (isset($_GET['tipo'])) { $tipo=$_GET['tipo'];   }else{	$tipo=false; $fallo=1; }

		// Sustituimos los caracteres inválidos
		$txt=htmlentities($txt, ENT_QUOTES);

		// Actualizamos la base de datos
		if($txt!=""){
			$sql = "INSERT INTO productostalla (txt,tipo) VALUES ('$txt','$tipo')";
			if($insertar = $CONEXION->query($sql)){
				$exito=1;
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo agregarse a la base de datos $txt";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Talla Editar                      
	if(isset($_GET['editartalla'])){ 
		// Obtenemos los valores enviados
		$tallaid=$_GET['tallaid'];
		if (isset($_GET['txt'])) { $txt=strtoupper($_GET['txt']);   }else{	$txt=false; $fallo=1; }

		// Sustituimos los caracteres inválidos
		$txt=htmlentities($txt, ENT_QUOTES);

		// Actualizamos la base de datos
		if($txt!=""){
			$sql = "UPDATE productostalla SET txt = '$txt' WHERE id = '$tallaid'";
			if($actualizar = $CONEXION->query($sql)){
				$exito=1;
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo modificarse a la base de datos <br>$sql";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Marca Nueva                       
	if(isset($_GET['nuevamarca'])){ 
		// Obtenemos los valores enviados
		if (isset($_GET['txt'])) { $txt=$_GET['txt'];   }else{	$txt=false; $fallo=1; }

		// Sustituimos los caracteres inválidos
		$txt=htmlentities($txt, ENT_QUOTES);

		// Actualizamos la base de datos
		if($txt!=""){
			$sql = "INSERT INTO productosmarcas (txt) VALUES ('$txt')";
			if($insertar = $CONEXION->query($sql)){
				$cat = $CONEXION->insert_id;
				$exito=1;
				$legendSuccess .= "<br>Nueva marca";
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo agregarse a la base de datos $txt";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Clasificación Nueva               
	if(isset($_POST['nuevaclasif'])){ 
		// Obtenemos los valores enviados
		if (isset($_POST['txt'])) { $txt=$_POST['txt'];   }else{	$txt=false; $fallo=1; }

		// Actualizamos la base de datos
		if(!isset($fallo)){
			$sql = "INSERT INTO productosclasif (txt) VALUES ('$txt')";
			if($insertar = $CONEXION->query($sql)){
				$cat = $CONEXION->insert_id;
				$exito=1;
				$legendSuccess .= "<br>Nueva clasificación";
			}else{
				$fallo=1;  
				$legendFail .= "<br>No pudo agregarse a la base de datos $txt";
			}
		}else{
			$fallo=1;  
			$legendFail .= "<br>El campo está vacío";
		}
	}

//    Borrar varios tipos de dato       
	if(isset($_REQUEST['eliminargeneral'])){
		$tabla=$_GET['tabla'];
		if($borrar = $CONEXION->query("DELETE FROM $tabla WHERE id = $id")){
			$exito=1;
			$legendSuccess .= "<br>Eliminado";
		}else{
			$fallo=1;
			$legendFail .= "<br>No se pudo borrar de la base de datos";
		}
	}

//    Borrar todos lo que coinciden     
	if(isset($_REQUEST['eliminarexistencias'])){
		$campo=$_GET['campo'];
		if($borrar = $CONEXION->query("DELETE FROM productosexistencias WHERE $campo = $id")){
			$exito=1;
			$legendSuccess .= "<br>Coincidencias eliminadas";
		}else{
			$fallo=1;
			$legendFail .= "<br>No se pudo borrar de la base de datos";
		}
	}

//    Subir foto galería                
	if(isset($_FILES["uploadedfile"])){
		include '../../../includes/connection.php';
		$rutaFinal = '../../../img/contenido/'.$seccion.'/';

		$id=$_GET['id'];
		$sql = "INSERT INTO $seccionpic (producto) VALUES ($id)";
		if($insertar = $CONEXION->query($sql)){
			$picId=$CONEXION->insert_id;

			$ret = array();
			
			$error = $_FILES["uploadedfile"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if(!is_array($_FILES["uploadedfile"]["name"])) //single file
			{
		 	 	$archivoInicial = $_FILES["uploadedfile"]["name"];
				$i = strrpos($archivoInicial,'.');
				$l = strlen($archivoInicial) - $i;
				$ext = strtolower(substr($archivoInicial,$i+1,$l));

		 	 	$archivoFinal  =$picId.'.'.$ext;
		 		move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],$rutaFinal.$archivoFinal);
		    	$ret[]= $archivoFinal;
			}
			else  //Multiple files, file[]
			{
			  $fileCount = count($_FILES["uploadedfile"]["name"]);
			  for($i=0; $i < $fileCount; $i++)
			  {
			  	$archivoInicial = $_FILES["uploadedfile"]["name"][$i];
				$i = strrpos($archivoInicial,'.');
				$l = strlen($archivoInicial) - $i;
				$ext = strtolower(substr($archivoInicial,$i+1,$l));

			  	$archivoFinal  =$picId.'.'.$ext;
				move_uploaded_file($_FILES["uploadedfile"]["tmp_name"][$i],$rutaFinal.$archivoFinal);
			  	$ret[]= $archivoFinal;
			  }
			}
			//$actualizar = $CONEXION->query("UPDATE $seccionpic SET file = '$archivoFinal' WHERE id = $picId");
			echo json_encode($ret);



		    // %%%%%%%%%%%%%%%%%%%
		    //    MINIATURAS
		    // %%%%%%%%%%%%%%%%%%%
				$xs=1;
				$sm=1;
				$lg=1;

				// Leer el archivo para hacer la nueva imagen
				$original = imagecreatefromjpeg($rutaFinal.$archivoFinal);

				// Tomamos las dimensiones de la imagen original
				$ancho  = imagesx($original);
				$alto   = imagesy($original);


				if ($xs==1) {
					//  Imagen xs
					$miniaturaName=$rutaFinal.$picId."-xs.jpg";
					$anchoNuevo = 80;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$archivoFinal = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($archivoFinal,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($archivoFinal,$miniaturaName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($sm==1) {
					//  Imagen sm
					$miniaturaName=$rutaFinal.$picId."-sm.jpg";
					$anchoNuevo = 400;
					$altoNuevo  = $anchoNuevo*$alto/$ancho;

					// Creamos la imagen
					$archivoFinal = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($archivoFinal,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($archivoFinal,$miniaturaName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

				if ($lg==1) {
					//  Imagen lg
					$miniaturaName=$rutaFinal.$picId."-lg.jpg";
					if ($ancho>$alto) {
						$anchoNuevo = 1000;
						$altoNuevo  = $anchoNuevo*$alto/$ancho;
					}else{
						$altoNuevo  = 1000;
						$anchoNuevo = $altoNuevo*$ancho/$alto;
					}

					// Creamos la imagen
					$archivoFinal = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
					// Copiamos el contenido de la original para pegarlo en el archivo nuevo
					imagecopyresampled($archivoFinal,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
					// Pegamos el contenido de la imagen
					if(imagejpeg($archivoFinal,$miniaturaName,90)){ // 90 es la calidad de compresión
						$exito=1;
					}
				}

		}
	}

//    Borrar foto galería               
	if(isset($_POST['borrarfoto'])){
		include '../../../includes/connection.php';
		$rutaFinal='../../../img/contenido/'.$seccion.'/';
		$id=$_POST['id'];
		// Borramos el archivo de imagen
		$filehandle = opendir($rutaFinal); // Abrir archivos
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
					$pic=$rutaFinal.$file;
					$exito=1;
					unlink($pic);
				}
			}
		}

		$borrar = $CONEXION->query("DELETE FROM $seccionpic WHERE id = $id");
		if(isset($exito)){
			echo "<div class='bg-success color-blanco'><i uk-icon='icon: trash;ratio:2;'></i> &nbsp; Borrado</div>";
		}else{
			echo "<div class='bg-danger color-blanco'><i uk-icon='icon: warning;ratio:2;'></i> &nbsp; No se pudo borrar</div>";
		}
	}

//    Borrar Foto Redes                 
	if(isset($_REQUEST['borrarpicredes'])){
		$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
		$row_CONSULTA = $CONSULTA -> fetch_assoc();
		if (strlen($row_CONSULTA['imagen'])>0) {
			unlink($rutaFinal.$row_CONSULTA['imagen']);
			$actualizar = $CONEXION->query("UPDATE $seccion SET imagen = '' WHERE id = $id");
			$exito=1;
			$legendSuccess.='<br>Foto eliminada';
		}else{
			$legendFail .= "<br>No se encontró la imagen en la base de datos";
			$fallo=1;
		}
	}

//    Subir varios tipos de imagen      
	if(isset($_GET['filename'])){
		$imagenName  = $_REQUEST['filename'];
		$position    = $_GET['position'];
		$rutaInicial = '../library/upload-file/php/uploads/';
		$fallo       = 1;

		//Obtenemos la extensión de la imagen
		$i = strrpos($imagenName,'.');
		$l = strlen($imagenName) - $i;
		$ext = strtolower(substr($imagenName,$i+1,$l));


		if(file_exists($rutaInicial.$imagenName)){
			if ($position=='gallery') { // Imágenes de la galería
				$sql = "INSERT INTO $seccionpic (producto) VALUES ($id)";
				$insertar = $CONEXION->query($sql);
				$pic=$CONEXION->insert_id;
				$imgAux=$rutaFinal.$pic.'.jpg';
				copy($rutaInicial.$imagenName, $imgAux);

				$original = imagecreatefromjpeg($imgAux);
				$ancho  = imagesx($original);
				$alto   = imagesy($original);

				$newName=$pic."-sm.jpg";
				$anchoNuevo = 300;
				$altoNuevo  = $anchoNuevo*$alto/$ancho;

				// Creamos la imagen
				$imagenAux = imagecreatetruecolor($anchoNuevo,$altoNuevo); 
				// Copiamos el contenido de la original para pegarlo en el archivo nuevo
				imagecopyresampled($imagenAux,$original,0,0,0,0,$anchoNuevo,$altoNuevo,$ancho,$alto);
				// Pegamos el contenido de la imagen
				if(imagejpeg($imagenAux,$rutaFinal.$newName,90)){ // 90 es la calidad de compresión
					$exito=1;
					unset($fallo);
				}
				
			}elseif($position=='main'){ // Imagen para compartir
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen']);
				}
				$legendFail.='<br>Fail - '.$position;

				if (copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal)) {
					$sigue=1;
				}
		
				if (isset($sigue)) {
					if ($actualizar = $CONEXION->query("UPDATE $seccion SET imagen = '$imgFinal' WHERE id = $id")) {
						unset($fallo);
						$exito=1;
					}
				}

			}elseif($position=='cat'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $cat");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE productoscat SET imagen = '$imgFinal' WHERE id = $cat");
				unset($fallo);

			}elseif($position=='cathover'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $cat");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagenhover']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagenhover'])) {
					unlink($rutaFinal.$row_CONSULTA['imagenhover']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE productoscat SET imagenhover = '$imgFinal' WHERE id = $cat");
				unset($fallo);

			}elseif($position=='iconomarcas'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM productosmarcas WHERE id = $id");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE productosmarcas SET imagen = '$imgFinal' WHERE id = $id");
				unset($fallo);

			}elseif($position=='iconoclasif'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM productosclasif WHERE id = $id");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE productosclasif SET imagen = '$imgFinal' WHERE id = $id");
				unset($fallo);

			}elseif($position=='iconoclasiftxt'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				$CONSULTA = $CONEXION -> query("SELECT * FROM productosclasif WHERE id = $id");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if ($row_CONSULTA['imagen2']!='' AND file_exists($rutaFinal.$row_CONSULTA['imagen2'])) {
					unlink($rutaFinal.$row_CONSULTA['imagen2']);
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$actualizar = $CONEXION->query("UPDATE productosclasif SET imagen2 = '$imgFinal' WHERE id = $id");
				unset($fallo);

			}elseif($position=='color'){
				$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				if(file_exists($rutaFinal.$imgFinal)){
					$imgFinal=$hoy.rand(111111111,999999999).'.'.$ext;
				}
				copy($rutaInicial.$imagenName, $rutaFinal.$imgFinal);
				$insertar = $CONEXION->query("INSERT INTO productoscolor (imagen) VALUES ('$imgFinal')");
				unset($fallo);

			}
		}else{
			$fallo=1;
			$legendFail='<br>No se permite refrescar la página.';
		}


		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Borramos las imágenes que estén remanentes en el directorio files
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		$filehandle = opendir($rutaInicial); // Abrir archivos
		while ($file = readdir($filehandle)) {
			if ($file != "." && $file != ".." && $file != ".gitignore" && $file != ".htaccess" && $file != "thumbnail") {
				if(file_exists($rutaInicial.$file)){
					//echo $ruta.$file.'<br>';
					unlink($rutaInicial.$file);
				}
			}
		} 
		closedir($filehandle); 
	}

//    Asignar color a foto                 
	if(isset($_POST['definecolorfoto'])) {
		// Obtenemos los valores enviados
		$fallo=1; 
		$idfoto = $_POST['idfoto'];
		$color = $_POST['color']; 
		$legendFail .= "<br>No se pudo modificar la base de datos";
	
		if ($actualizar = $CONEXION->query("UPDATE $seccionpic SET color = '$color' WHERE id = $idfoto")) {
			$exito=1;
			if (isset($fallo)) {
				unset($fallo);
			}
		}

	}

