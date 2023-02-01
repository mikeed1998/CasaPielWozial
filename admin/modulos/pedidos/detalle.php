<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
$user=$row_CONSULTA['uid'];
$dom=$row_CONSULTA['dom'];
$comprobante=$row_CONSULTA['comprobante'];
$factura=$row_CONSULTA['factura'];

$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();


$level=$row_CONSULTA['estatus']+1;
switch ($level) {
	case 2:
		$clase='uk-button-primary';
		$estatus='Pagado';
		break;
	case 3:
		$clase='uk-button-warning';
		$estatus='Enviado';
		break;
	case 4:
		$clase='uk-button-success';
		$estatus='Entregado';
		break;
	default:
		$clase='uk-button-white';
		$estatus='Registrado';
		break;
}


$tabla = str_replace('<table', '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle"', $row_CONSULTA['tabla']);
$tabla = str_replace('color: white;', 'color: white; background-color: #999;', $tabla);


echo '
<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Pedidos</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="color-red">Pedido '.$id.'</a></li>
	</ul>
</div>


<div class="uk-width-1-1">
	<a class="uk-button uk-button-white uk-button-large" href="../'.$row_CONSULTA['idmd5'].'_revisar.pdf" target="_blank"><i class="far fa-2x fa-file-pdf"></i> &nbsp; Ver PDF</a>
	<button class="estatus '.$clase.' uk-button-large text-gnrl uk-text-uppercase" data-estatus="'.$level.'" data-id="'.$row_CONSULTA['id'].'">'.$estatus.'</button>&nbsp;';
if (strlen($comprobante)>0 and file_exists('../img/contenido/comprobantes/'.$row_CONSULTA['comprobante'])) {
	echo '
	<a href="../img/contenido/comprobantes/'.$comprobante.'" class="uk-button uk-button-large uk-button-white" target="_blank">Comprobante de pago</a>';
}
echo'
</div>


<div class="uk-width-1-1">
	<div uk-grid class="uk-grid-small uk-child-width-1-2@m">
		<div class="uk-width-1-3@s">
			<h2>Datos generales</h2>
			<span class="uk-text-muted">Nombre:</span> '.$row_CONSULTA1['nombre'].'<br>
			<span class="uk-text-muted">Email:</span> '.$row_CONSULTA1['email'].'<br>
			<span class="uk-text-muted">Telefono:</span> '.$row_CONSULTA1['telefono'].'<br>
			<span class="uk-text-uppercase"><span class="uk-text-muted">rfc:</span> '.$row_CONSULTA1['rfc'].'</span><br>
			<span class="uk-text-muted">Empresa:</span> '.$row_CONSULTA1['empresa'].'<br>
			<span class="uk-text-muted">Fecha de registro:</span> '.date('d-m-Y',strtotime($row_CONSULTA1['alta'])).'
		</div>
		<div class="uk-width-1-3@s">
				<h2>Domicilio</h2>
				<span class="uk-text-muted uk-text-capitalize">calle:</span> '.$row_CONSULTA['calle'].' #'.$row_CONSULTA['noexterior'].' &nbsp; '.$row_CONSULTA['nointerior'].'<br>
				
				<span class="uk-text-muted uk-text-capitalize">colonia:</span> '.$row_CONSULTA['colonia'].'<br>
				<span class="uk-text-muted uk-text-uppercase">cp:</span> '.$row_CONSULTA['cp'].'<br>
				'.$row_CONSULTA['pais'].', '.$row_CONSULTA['estado'].', '.$row_CONSULTA['municipio'].'
			</div>';
		if ($factura == 1) {
			echo '
			<div class="uk-width-1-3@s">
				<h2>Requiere Factura</h2>
			</div>';
		}
		echo '</div>
	</div>';
// GUÍA DE ENVÍO
	echo '
<div class="uk-width-1-1">
	<div uk-grid>
		<div>
			Número de guía<br>
			<input type="text" class="editarajax uk-input uk-form-width-small" data-tabla="'.$seccion.'" data-campo="guia" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['guia'].'">
		</div>
		<div class="uk-width-expand">
			Link de rastreo de guía<br>
			<input type="text" class="editarajax uk-input uk-form-width-large" data-tabla="'.$seccion.'" data-campo="linkguia" data-id="'.$row_CONSULTA['id'].'" value="'.$row_CONSULTA['linkguia'].'">
		</div>
	</div>
</div>



<div class="uk-width-1-1 margen-v-50">
	'.$tabla.'
</div>';

$CONSULTA2 = $CONEXION -> query("SELECT * FROM ipn WHERE pedido = $id");
while($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()){
	if (strlen($row_CONSULTA2['ipn'])>0) {
		echo '
		<div class="uk-width-1-1 padding-v-100">
			<span class="uk-text-large">Cadena de pago PayPal</span><br>
			'.str_replace('&', '<br>', $row_CONSULTA2['ipn']).'
		</div>';
	}
}



$scripts='
$(function(){
	$(".estatus").click(function(){

		var id = $(this).data("id");
		var estatus = $(this).attr("data-estatus");

		switch(estatus) {
			case "1":
				estatus=2;
				$(this).removeClass("uk-button-white");
				$(this).addClass("uk-button-primary");
				$(this).text("Pagado");
				break;
			case "2":
				estatus=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).text("Enviado");
				break;
			case "3":
				estatus=4;
				$(this).removeClass("uk-button-warning");
				$(this).addClass("uk-button-success");
				$(this).text("Entregado");
				break;
			default:
				estatus=1;
				$(this).removeClass("uk-button-success");
				$(this).text("Registrado");
				break;
		}

		$(this).attr("data-estatus",estatus);

		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				estatuschange: 1,
				estatus: (estatus-1),
				id: id
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
})
';

mysqli_free_result($CONSULTA);
mysqli_free_result($CONSULTA1);
