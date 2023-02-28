<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM pedidost WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
$user=$row_CONSULTA['uid'];

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
		echo '</div>
	</div>';




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
