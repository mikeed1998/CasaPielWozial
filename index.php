<?php
	session_start();
	require_once 'includes/connection.php';
	require_once 'includes/languaje.php';
	require_once 'includes/login.php';
	require_once 'includes/widgets.php';
	
	// obtenemos el identificador
	if(isset($_GET['identificador'])){ $identificador=$_GET['identificador']; }else{ $identificador=0; }
	//echo $identificador;
	//lenguajes
	$langNew = ($languaje=='es')? 'en': 'es';

	$nav1='';
	$nav2='';
	$nav3='';
	$nav4='';
	$nav5='';
	$nav6='';
	$nav7='';
	$nav8='';
	$nav9='';


switch ($identificador) {
	case 2:
		$nav2='uk-active';
		include "includes/includes.php";	
		include 'pages/inicio.php';
		break;
	// Inicio en default
	case 3:
		$nav3='uk-active';
		include 'includes/includes.php';
		include 'pages/nosotros.php';
		break;

	case 4:
		$nav4='uk-active';
		include 'includes/includes.php';
		include 'pages/productos.php';
		break;

	case 5:
		$nav6='uk-active';
		include 'includes/includes.php';
		include 'pages/cuidados.php';
		break;

	case 6:
		$nav7='uk-active';
		include 'includes/includes.php';
		include 'pages/contacto.php';
		break;

	case 7:
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'pages/productos-detalle.php';
		break;

	case 8:
		$id=$_GET['id'];
		include 'includes/includes.php';
		include 'pages/productos.php';
		break;

	case 9:
		$wordKey=$_GET['consulta'];
		include 'includes/includes.php';
		include 'pages/productos-search.php';
		break;




	// TIENDA
	case 10:
		$nav3='uk-active';
		$title='Catálogo de Botas Los Potrillos';
		include 'includes/includes.php';
		include 'pages/tienda-paso-1.php';
		break;

	case 11:
		$nav3='uk-active';
		$id =$_GET['id'];
		$pag=$_GET['pag'];
		$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $id");
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$catName=$rowCONSULTA['txt'];
		$title='Catálogo de '.$catName.' - Los Potrillos';
		include 'includes/includes.php';
		include 'pages/tienda-paso-2.php';
		break;
		
	case 12:
		$nav3='uk-active';
		$id =$_GET['id'];
		$pag=$_GET['pag'];
		$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $id");
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$parent=$rowCONSULTA['parent'];
		$catName=$rowCONSULTA['txt'];
		$title='Catálogo de '.$catName.' - Los Potrillos';
		include 'includes/includes.php';
		include 'pages/tienda-paso-3.php';
		break;
		
	case 13:
		$nav3='uk-active';
		$id =$_GET['id'];
		$pag=$_GET['pag'];
		$CONSULTA = $CONEXION -> query("SELECT * FROM productosmarcas WHERE id = $id");
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$catName=$rowCONSULTA['txt'];
		$picOgRuta='img/contenido/productos/';
		$logoMarca=$picOgRuta.$rowCONSULTA['imagen'];
		$title='Catálogo de '.$catName.' - Los Potrillos';
		include 'includes/includes.php';
		include 'pages/tienda-marcas.php';
		break;

	case 14:
		$nav3='uk-active';
		$consulta =$_GET['consulta'];
		$title=$consulta;
		$description.=' - '.$consulta;
		include 'includes/includes.php';
		include 'pages/tienda-search.php';
		break;

	case 15:
		$nav3='uk-active';
		$id=$_GET['id'];
		$CONSULTA = $CONEXION -> query("SELECT * FROM productos WHERE id = $id");
		$numProds=$CONSULTA->num_rows;
		$rowCONSULTA = $CONSULTA -> fetch_assoc();
		$title=(strlen($rowCONSULTA['title'])>0)?html_entity_decode($rowCONSULTA['title']):html_entity_decode($rowCONSULTA['titulo']);
		$description=(strlen($rowCONSULTA['metadescription'])>0)?html_entity_decode($rowCONSULTA['metadescription']):$description;

		$picOg='img/design/logo-og.jpg';
		$consultaPIC = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden LIMIT 1");
		$numPics=$consultaPIC->num_rows;
		if ($numPics>0) {
			$row_consultaPIC = $consultaPIC -> fetch_assoc();
			$picOgRuta='img/contenido/productos/';
			$picOg=$picOgRuta.$row_consultaPIC['id'].'.jpg';
		}
		include 'includes/includes.php';
		include 'pages/tienda-detalle.php';
		break;








	// Procesar carrito ajax
		case 200:
			break;




	// Procesar compra
		case 500:
			$nav5="uk-active";
			include "includes/includes.php";
			include 'pages-cart/pedido-1-revisar.php';
			break;

		case 501:
			include "includes/includes.php";
			if (isset($uid)) {
				if(isset($_SESSION['carro'])){
					include 'pages-cart/pedido-2-datos.php';
				}else{
					include 'pages/inicio.php';
				}
			}else{
				include 'pages-cart/registro.php';
			}
			break;

		case 502:
			include "includes/includes.php";
			if (isset($uid)) {
				include 'pages-cart/pedido-3-procesar.php';
			}else{
				header('location: revisar_datos_personales');
			}
			break;


		case 505:
			include "includes/includes.php";
			if (isset($uid)) {
				include 'pages-cart/pedido-4-pagar.php';
			}else{
				include 'pages-cart/pedido-2-datos.php';
			}
			break;

		case 506:
				if (isset($uid)) {
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if($uid==$row_CONSULTA['uid']){
					include "includes/includes.php";
					include 'pages-cart/pedido-5-detalle.php';
				}else{
					include "includes/includes.php";
					include 'pages/inicio.php';
				}
			}else{
				include "includes/includes.php";
				include 'pages-cart/registro.php';
			}
			break;

		case 507:
				if (isset($uid)) {
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				if($uid==$row_CONSULTA['uid']){
					include "includes/includes.php";
					include 'pages-cart/pdf-show.php';
				}else{
					include "includes/includes.php";
					include 'pages/inicio.php';
				}
			}else{
				include "includes/includes.php";
				include 'pages-cart/registro.php';
			}
			break;

		case 508:
				$idmd5=$_GET['idmd5'];
				$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE idmd5 = '$idmd5'");
				$row_CONSULTA = $CONSULTA -> fetch_assoc();
				include "includes/includes.php";
				include 'pages-cart/pdf-show.php';
			break;

		case 509:
			$mensaje='Pedido no encontrado';
			$mensajeClase='danger';
			include "includes/includes.php";
			include 'pages/inicio.php';
			break;

		case 511:
			include "includes/includes.php";
			include 'pages-cart/pedido-6-success.php';
			break;

		case 512:
			$idmd5=$_GET['idmd5'];
			include "includes/includes.php";
			include 'pages-cart/pedido-7-ipn.php';
			break;


	case 900:
		include "includes/includes.php";
		if (isset($uid)) {
				include 'pages-cart/myaccount.php';
		}else{
			include 'pages-cart/registro.php';
		}
		break;


	// Recuperar contraseña
	case 901:
		include "includes/includes.php";
		include 'pages-cart/password-recovery-1.php';
		break;

	case 902:
		$id=$_GET['id'];
		include "includes/includes.php";
		if (isset($uid)) {
				include 'pages-cart/myaccount.php';
		}else{
			include 'pages-cart/password-recovery-2.php';
		}
		break;
	// Recuperar contraseña



	// Buscar
	case 910:
		if(isset($_GET['consulta'])){ $consulta=$_GET['consulta']; }else{ header('Location: '.$ruta); }
		include "includes/includes.php";
		include 'pages/search.php';
		break;


	case 990:
		session_destroy();
		include "includes/includes.php";
		header('location: salir');
		break;

	case 991:
		$nav1='uk-active';
		$mensaje='Hasta pronto';
		$mensajeClase='success';
		include "includes/includes.php";
		$scriptGNRL.='<script> setTimeout(function(){ window.location = ("'.$ruta.'"); },2000); </script>';
		include 'pages/inicio.php';
		break;

	case 994:
		include "includes/includes.php";
		include 'includes/humans.php';
		break;

	case 995:
		include "includes/includes.php";
		include 'includes/google-verify.php';
		break;

	case 996:
		include "includes/includes.php";
		include 'includes/robots.php';
		break;

	case 997:
		include "includes/includes.php";
		include 'includes/sitemap.php';
		break;

	case 998:
		include "includes/includes.php";
		include 'pages-cart/faq.php';
		break;

	case 999:
		$id=$_GET['id'];
		include "includes/includes.php";
		include 'pages-cart/politicas.php';
		break;

	default:
		header( 'Location: '.$ruta.'es/');
		break;
}


mysqli_close($CONEXION);
if (file_exists('error_log')) {
	unlink('error_log');
}

