<?php
$scripts='';
include "modulos/$seccion/acciones.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />

<title>Administración</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="shortcut icon" href="../img/design/favicon.ico">
<link rel="stylesheet" type="text/css"  href="../css/uikit.css">
<link rel="stylesheet" type="text/css"  href="../css/admin.css">

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="../js/uikit.min.js"></script>

<!-- JQUERY UI -->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="../js/components/tooltip.js"></script>
<script src="../js/components/notify.js"></script>

<!-- Upload Image -->
<link href="../library/upload-file/css/uploadfile.css" rel="stylesheet">
<script src="../library/upload-file/js/jquery.uploadfile.js"></script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
// Editor de texto
tinymce.init({
	selector: '.editor',
	height: 400,
	plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste code'
	],
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	content_css: [
		'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
		'//www.tinymce.com/css/codepen.min.css'
	]
});
// Activamos la selección de fecha UI
$(function() {
	$( ".fecha" ).datepicker({ dateFormat: 'yy-mm-dd' });
});

// Eliminar definitivamente
function eliminarCotizacion (){ 
	var statusConfirm = confirm("¿Eliminar esto permanentemente?"); 
	if (statusConfirm == true) 
	{ 
		window.location = ("index.php?seccion=<?=$seccion?>&subseccion=<?php echo $subseccion; ?>&cotizacion_borrar=1&id="+id)
	} 
} 
// Eliminar definitivamente
function eliminarPlan (){ 
	var statusConfirm = confirm("¿Eliminar esto permanentemente?"); 
	if (statusConfirm == true) 
	{ 
		window.location = ("index.php?seccion=<?=$seccion?>&subseccion=<?php echo $subseccion; ?>&planes_borrar=1&id="+id)
	} 
} 
// Eliminar definitivamente
function eliminarCliente (){ 
	var statusConfirm = confirm("¿Eliminar esto permanentemente?"); 
	if (statusConfirm == true) 
	{ 
		window.location = ("index.php?seccion=<?=$seccion?>&subseccion=<?php echo $subseccion; ?>&clientes_borrar=1&id="+id)
	} 
} 

// Deshabilita botón de envío previniendo el doble registro
function checkForm(form){
	form.enviar.value = "Espere...";
	form.enviar.disabled = true;
	setTimeout(function(){ 
		form.enviar.value = "Guardar";
		form.enviar.disabled = false;
	}, 3000);
	return true;
}

</script>

</head>

<body>

<div class="uk-grid">
	<div class="uk-width-large-1-5 uk-width-medium-1-4">
		<?php include "modulos/varios/menu.php"; ?>
	</div>
	<div class="uk-width-large-4-5 uk-width-medium-3-4 uk-width-1-1">
		<?php include "modulos/varios/mensajes.php"; ?>
		<?php include "modulos/".$seccion."/".$subseccion.".php"; ?>
	</div>
</div>

<?=$scripts?>

</body>
</html>