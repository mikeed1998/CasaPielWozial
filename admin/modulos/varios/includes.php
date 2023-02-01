<?php

$navegacion[] = array(
	  'title' => 'Catalogos',
	'seccion' => 'inicio',
	   'icon' => 'folder-open');

$navegacion[] = array(
	  'title' => 'clientes',
	'seccion' => 'clientes',
	   'icon' => 'users');

$navegacion[] = array(
	  'title' => 'configuración',
	'seccion' => 'configuracion',
	   'icon' => 'cog');

$navegacion[] = array(
	  'title' => 'pedidos',
	'seccion' => 'pedidos',
	   'icon' => 'file-invoice-dollar');

$navegacion[] = array(
	  'title' => 'productos',
	'seccion' => 'productos',
	   'icon' => 'box-open');

$navegacion[] = array(
	  'title' => 'sucursales',
	'seccion' => 'sucursales',
	   'icon' => 'store-alt');




////////////////////////////////////////////////////////////
////////////////  NO CAMBIAR LO DE ABAJO  //////////////////
////////////////////////////////////////////////////////////

$menu = '';
$menuMovil = '';
foreach ($navegacion as $key => $value) {
	$menu .= ($seccion==$value['seccion'])? '
		<li class="uk-inline uk-active"><a href="index.php?rand='.rand(1,1000).'&seccion='.$value['seccion'].'"><i class="fa fa-2x fa-'.$value['icon'].'"></i></a><div class="bg-gold" uk-drop="pos: right"><span class="uk-h3 color-white uk-text-capitalize">'.$value['title'].'</span></div></li>':'
		<li class="uk-inline          "><a href="index.php?rand='.rand(1,1000).'&seccion='.$value['seccion'].'"><i class="fa fa-2x fa-'.$value['icon'].'"></i></a><div class="bg-gold" uk-drop="pos: right"><span class="uk-h3 color-white uk-text-capitalize">'.$value['title'].'</span></div></li>';

	$menuMovil .= '<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$value['seccion'].'">'.$value['title'].'</a></li>';
}

$menuBig='
	<div class="uk-visible@l">
		<div>
			<div class="padding-10">
				<a href="../" target="_blank"><img src="../img/design/logo-wozial.png"></a>
			</div>
		</div>
		<div>
			<nav>
				<ul class="uk-nav-default uk-nav-parent-icon uk-text-uppercase" id="menu-large" uk-nav>
					'.$menu.'
				</ul>
			</nav>
		</div>
		<div class="padding-top-50 uk-text-center">
			<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
		</div>
	</div>';

$menuSmall='
	<div id="menu-movil" uk-offcanvas="mode: push; overlay: true">
		<div class="uk-offcanvas-bar uk-flex uk-flex-column">
			<button class="uk-offcanvas-close" type="button" uk-close></button>
			<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical menu-movil uk-text-uppercase" uk-nav>
				'.$menuMovil.'
			</ul>
			<div class="uk-text-center">
				<a href="index.php?logout=1" class="uk-icon-button uk-button-danger" uk-icon="icon:unlock;"></a>
			</div>
		</div>
	</div>';

$head='
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="utf-8">

			<title>Administración</title>

			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link rel="shortcut icon" href="../img/design/logo-wozial.png">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/css/uikit.css">

			<!-- jQuery es neceario -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- UIkit JS -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/js/uikit.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/js/uikit-icons.min.js"></script>

			<!-- Iconos -->
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

			<!-- CSS Personalizados -->
			<link rel="stylesheet" href="../css/admin.css">

		</head>';

$jquery='
	<!-- JQUERY UI -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Upload Image -->
	<link href="../library/upload-file/css/uploadfile.css" rel="stylesheet">
	<script src="../library/upload-file/js/jquery.uploadfile.js"></script>

	<!-- Editor de texto
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
		<script src="../js/tinymce/tinymce.min.js"></script>

	<!-- Chosen -->
	<link  href="../library/chosen/chosen.admin.css"    rel="stylesheet">
	<script src="../library/chosen/chosen.jquery.js"    type="text/javascript"></script>
	<script src="../library/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>

	<!-- Scripts Personalizados -->
	<script src="../js/admin.js"></script>

	<!-- Scripts específicos del archivo activo -->
	<script>';

$header='
		<body>
			<div id="admin" class="uk-offcanvas-content">
				<div id="adminmenu">
					<div id="menudisplay" class="uk-height-viewport" uk-sticky>
						'.$menuBig.'
					</div>
					'.$menuSmall.'
				</div>
				<div id="admincuerpo">
					<div class="uk-container uk-container-expand">
						<div class="uk-width-1-1">
							<a href="#menu-movil" uk-toggle class="uk-button uk-button-white uk-hidden@l"><i uk-icon="icon:menu;ratio:1.4;"></i> &nbsp; MENÚ</a>
						</div>
						<div uk-grid>
							<!-- /////////////  COMIENZA  CONTENIDO   //////////// -->';

$footer='
								$("input").attr("autocomplete","off");
							</script><!-- Terminan scripts específicos del archivo activo -->
							<!-- /////////////   TERMINA  CONTENIDO   //////////// -->
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>';

