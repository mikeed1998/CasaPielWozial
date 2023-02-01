<?php
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//							SOFTWARE DESARROLLADO POR 
//							 EFRAÍN GONZALEZ MACÍAS
//							  ing_efrain@yahoo.com
//
//					LICENCIA PARA USO SOLO EN ESTE SITIO WEB
//				 QUEDA PROHIBIDA SU DISTRIBUCIÓN O MOFICIFACIÓN
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// CONECTANDO CON LA BASE DE DATOS
	require_once('../includes/connection.php');
	require_once('../includes/widgets.php');

// OBTENIENDO VARIABLES
	$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : $id=false;
	$seccion = (isset($_REQUEST['seccion'])) ? $_REQUEST['seccion'] : $seccion='blank';
	$subseccion = (isset($_REQUEST['subseccion'])) ? $_REQUEST['subseccion'] : $subseccion='contenido';
	$cat = (isset($_REQUEST['cat'])) ? $_REQUEST['cat'] : $cat=false;

// LOGIN 
	require_once("modulos/varios/login_proceso.php");
	require_once('modulos/varios/includes.php');
	if(!isset($acceso) or $acceso==false){ 
		require_once("modulos/varios/login.php");
	} 

// MOSTRANDO EL DISEÑO INTERIOR
	if(isset($acceso) and $acceso==1){ 
		require_once('modulos/'.$seccion.'/acciones.php');

		echo $head;
		echo $header;

		require_once('modulos/varios/mensajes.php');
		require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 

		echo $jquery;
		echo $scripts;
		echo $footer;

	} 

// Borrar Error_log si existe
	mysqli_close($CONEXION);
	flush();
	if (file_exists('error_log')) {
		unlink('error_log');
	}
