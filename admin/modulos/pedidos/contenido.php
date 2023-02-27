<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" ></script>

<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Pedidos</a></li>
		';
		?>
	</ul>
</div>


<div class="uk-width-1-1">
	<table class="uk-table uk-table-hover uk-table-striped uk-table-middle" id="myTable">
		<thead>
			<tr class="uk-text-muted">
				<td onclick="sortTable(0)">Id</td>
				<td onclick="sortTable(1)" class="uk-text-center">Fecha</td>
				<td onclick="sortTable(2)">Nombre/Email</td>
				<td onclick="sortTable(3)" class="uk-text-center">Productos</td>
				<td onclick="sortTable(4)" class="uk-text-center">Importe</td>
				<td width="240px;"></td>
			</tr>
		</thead>
		<tbody>

		<?php 
		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos ORDER BY id DESC");
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			$thisid=$row_CONSULTA['id'];
			$user=$row_CONSULTA['uid'];


			$CONSULTA1 = $CONEXION -> query("SELECT SUM(cantidad) AS cant FROM pedidosdetalle WHERE pedido = $thisid");
			$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
			$numProds=$row_CONSULTA1['cant'];

			$segundos=strtotime($row_CONSULTA['fecha']);
			$fecha=date('d-m-Y',$segundos);

			$level=$row_CONSULTA['estatus']+1;

			switch ($level) {
				case 2:
					$clase='uk-button-primary';
					break;
				case 3:
					$clase='uk-button-warning';
					break;
				case 4:
					$clase='uk-button-success';
					break;
				default:
					$clase='uk-button-white';
					break;
			}

			$pagoFile  ='../img/contenido/comprobantes/'.$thisid.'.'.$row_CONSULTA['comprobante'];
			$pagoHTML  = (file_exists($pagoFile)) ? '<a href="'.$pagoFile.'" class="uk-button uk-button-small" target="_blank">Pago</a>':'';
			$printFile ='../img/contenido/print/'.$row_CONSULTA['imagen'];
			$printHTML = ($row_CONSULTA['imagen']!='' AND file_exists($printFile)) ? '<a href="'.$printFile.'" class="uk-button uk-button-small uk-button-primary" download>Print</a>':'';

			echo '
			<tr>
				<td>
					'.$row_CONSULTA['id'].'
				</td>
				<td class="uk-text-center">
					<span class="uk-hidden">'.$row_CONSULTA['fecha'].'</span>
					'.$fecha.'
				</td>
				<td>
					'.$row_CONSULTA['nombre'].'<br>
					'.$row_CONSULTA['email'].'
				</td>
				<td class="uk-text-center">
					'.$numProds.'
				</td>
				<td class="uk-text-center">
					<span class="uk-hidden">'.($row_CONSULTA['importe']+1000000000).'</span>
					$'.number_format($row_CONSULTA['importe'],2).'
				</td>
				<td class="uk-text-center">
					<a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$row_CONSULTA['id'].'" class="uk-icon-button uk-button-primary"><i class="fas fa-search-plus"></i></a>  &nbsp;
					<a class="uk-icon-button uk-button-white" href="../'.$row_CONSULTA['idmd5'].'_revisar.pdf" target="_blank"><i class="far fa-file-pdf"></i></a> &nbsp;
					<button class="estatus '.$clase.' uk-icon-button text-gnrl" data-id="'.$row_CONSULTA['id'].'">'.$level.'</button> &nbsp;
					<a href="#envios" uk-toggle class="send uk-icon-button uk-button-primary" data-id="'.$row_CONSULTA['id'].'"><i class="fa fa-envelope"></i></a> &nbsp;
					<a href="#eliminarpedidosmodal" uk-toggle data-id="'.$row_CONSULTA['id'].'"  class="eliminarpedidosrow uk-icon-button uk-button-danger" uk-icon="icon:trash"></a>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
	<div class="uk-grid">
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-white">1</button> Registrado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-primary">2</button> Pagado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-warning">3</button> Enviado
		</div>
		<div class="uk-width-1-4">
			<button class="uk-button uk-button-success">4</button> Entregado
		</div>
	</div>
</div>

<?php
echo '
<div>
	<div id="buttons">
		<a href="#menu-movil" class="uk-icon-button uk-button-primary uk-box-shadow-large uk-hidden@l" uk-icon="icon:menu;ratio:1.4;" uk-toggle></a>
	</div>
</div>';
?>

<div id="envios" uk-modal class="modal">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h3>Envío de notificaciones</h3>
		</div>
		<div class="uk-modal-body">
			<div class="uk-width-1-1 uk-margin">
				<div class="uk-container" style="width:300px;">
					<div class="uk-width-1-1 uk-margin">
						<button data-id="0" data-enviarcorreo="1" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-primary uk-margin">Número de guía</button>
					</div>
					<div class="uk-width-1-1 uk-margin">
						<button data-id="0" data-enviarcorreo="2" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-white uk-margin">Reenvío de orden</button>
					</div>
					<div class="uk-width-1-1 uk-margin">
						<button data-id="0" data-enviarcorreo="3" class="enviarcorreo uk-width-1-1 uk-button uk-button-large uk-button-danger uk-margin">Cancelación de orden</button>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-modal-footer uk-text-center">
			<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cerrar</button>
		</div>
	</div>
</div>



<div id="eliminarpedidosmodal" uk-modal class="modal">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h3 class="color-red">Eliminar pedido <span id="pedidoeliminarspan"></span></h3>
		</div>
		<div class="uk-modal-body">
			<div class="uk-width-1-1 uk-margin">
				<div class="uk-container">
					<div uk-grid class="uk-child-width-1-2">
						<div>
							<button data-id="" data-incorporar="0" class="eliminarpedido-confirmar uk-button uk-button-white">No incorporar existencias</button>
						</div>
						<div>
							<button data-id="" data-incorporar="1" class="eliminarpedido-confirmar uk-button uk-button-primary">Incorporar existencias</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-modal-footer uk-text-center">
			<button class="uk-button uk-button-white uk-modal-close uk-button-large">Cancelar</button>
		</div>
	</div>
</div>


<?php
$scripts='
$(document).ready( function () {
    $(\'#myTable\').DataTable();

} );

$(function(){

	$(".estatus").click(function(){
		var id = $(this).data("id");
		var estatus = $(this).html();
		switch(estatus) {
			case "1":
				estatus=2;
				$(this).removeClass("uk-button-white");
				$(this).addClass("uk-button-primary");
				$(this).html(estatus);
				break;
			case "2":
				estatus=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).html(estatus);
				break;
			case "3":
				estatus=4;
				$(this).removeClass("uk-button-warning");
				$(this).addClass("uk-button-success");
				$(this).html(estatus);
				break;
			default:
				estatus=1;
				$(this).removeClass("uk-button-success");
				$(this).html(estatus);
				break;
		}
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


	// Envío de correo
	// Asignar id a todos los botones
	$(".send").click(function(){
		var id = $(this).data("id");
		$(".enviarcorreo").attr("data-id",id);
	});
	// envío de correos
	$(".enviarcorreo").click(function(){
		var id = $(this).data("id");
		var enviarcorreo = $(this).attr("data-enviarcorreo");
		UIkit.notification("<div class=\'uk-text-center padding-10 text-lg color-white bg-primary\'>Procesando...</span>");
		$.ajax({
			method: "POST",
			url: "../includes/acciones.php",
			data: { 
				enviarcorreo: enviarcorreo,
				id: id
			}
		})
		.done(function( response ) {
			UIkit.notification.closeAll();
			console.log( response );
			datos = JSON.parse( response );
			UIkit.notification(datos.msj);
		});
	});

	// Modal para eliminar pedido
	$(".eliminarpedidosrow").click(function() {
		var id=$(this).attr("data-id");
		$("#pedidoeliminarspan").html(id);
		$(".eliminarpedido-confirmar").attr("data-id",id);
	});


	// Eliminar pedido
	$(".eliminarpedido-confirmar").click(function() {
		var id=$(this).attr("data-id");
		var incorporar=$(this).attr("data-incorporar");
		var statusConfirm = confirm("Realmente desea eliminar este pedido?");
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&borrarPedido&id="+id+"&incorporar="+incorporar);
		} 
	});
})
';
?>