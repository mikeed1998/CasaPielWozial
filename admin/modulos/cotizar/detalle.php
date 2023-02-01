<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
$user=$row_CONSULTA['uid'];
$comprobante=$row_CONSULTA['comprobante'];

$CONSULTA1 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $user");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();


$level=$row_CONSULTA['estatus']+1;
switch ($level) {
	case 2:
		$clase='uk-button-primary';
		$estatus='Cotizado';
		break;
	case 3:
		$clase='uk-button-warning';
		$estatus='Pagado';
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


echo '
<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Cotizaciones</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="color-red">Pedido '.$id.'</a></li>
	</ul>
</div>


<div class="uk-width-1-2@s">
	<div class="uk-width-1-1 uk-text-large">
		Datos personales
	</div>
	<div class="uk-width-1-1 uk-text-muted uk-text-small">
		Nombre:
	</div>
	<div class="uk-width-1-1">
		'.$row_CONSULTA1['nombre'].'
	</div>
	<div class="uk-width-1-1 uk-text-muted uk-text-small">
		Email:
	</div>
	<div class="uk-width-1-1">
		'.$row_CONSULTA1['email'].'
	</div>
	<div class="uk-width-1-1 uk-text-muted uk-text-small">
		Teléfono:
	</div>
	<div class="uk-width-1-1">
		'.$row_CONSULTA1['telefono'].'
	</div>
</div>


<div class="uk-width-1-2@s">
	<button class="estatus '.$clase.' uk-button-large text-gnrl uk-text-uppercase" data-estatus="'.$level.'" data-id="'.$row_CONSULTA['id'].'">'.$estatus.'</button><br><br>';
if (strlen($comprobante)>0 and file_exists('../img/contenido/comprobantes/'.$comprobante)) {
	echo '
	<a href="../img/contenido/comprobantes/'.$comprobante.'" class="uk-button uk-button-large uk-button-white" target="_blank">Comprobante de pago</a>';
}
echo'
</div>



<div class="uk-width-1-1 margen-v-50">
	<table class="uk-table uk-table-hover uk-table-striped">
		<thead class="uk-text-muted">
			<tr>
				<td>Producto</td>
				<td class="uk-text-center">Cantidad</td>
				<td class="uk-text-center">PU</td>
				<td class="uk-text-right">Importe</td>
			</tr>
		</thead>
		<tbody>';

	$num=0;
	$subtotal=0;
	$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $id");
	while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){

      	$link='../'.$row_CONSULTA1['producto'].'_prod_.html';
		$subtotal+=$row_CONSULTA1['importe'];

		echo '
			<tr>
				<td ><a href="'.$link.'" target="_blank">'.$row_CONSULTA1['productotxt'].'</a></td>
				<td style="width:130px;" class="uk-text-center">'.$row_CONSULTA1['cantidad'].'</td>
				<td style="width:130px;"><input type="text" class="editarajax uk-input uk-form-small uk-text-right" data-tabla="'.$seccion.'detalle" data-campo="precio" data-id="'.$row_CONSULTA1['id'].'" value="'.$row_CONSULTA1['precio'].'" data-cantidad="'.$row_CONSULTA1['cantidad'].'" tabindex="9"></td>
				<td style="width:130px;" class="uk-text-right importe'.$num.'" id="importe'.$row_CONSULTA1['id'].'">'.$row_CONSULTA1['importe'].'</td>
			</tr>
		';
		$num++;

	}
	mysqli_free_result($CONSULTA1);

	$iva=$subtotal*0.16;
	$total=$subtotal*1.16;

echo '
			<tr>
				<td colspan="3" class="uk-text-right">Subtotal:</td>
				<td class="uk-text-right">$<span id="subtotal">'.number_format($subtotal,2).'</span></td>
			</tr>
			<tr>
				<td colspan="3" class="uk-text-right">IVA: </td>
				<td class="uk-text-right">$<span id="iva">'.number_format($iva,2).'</span></td>
			</tr>
			<tr>
				<td colspan="3" class="uk-text-right">Total: </td>
				<td class="uk-text-right">$<span id="total">'.number_format($total,2).'</span></td>
			</tr>
		</tbody>
	</table>
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
				$(this).text("Cotizado");
				break;
			case "2":
				estatus=3;
				$(this).removeClass("uk-button-primary");
				$(this).addClass("uk-button-warning");
				$(this).text("Pagado");
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

	$(".editarajax").keypress(function(e) {
		if(e.which == 13) {
			var a,subtotal,id,pu,cantidad,valor,iva,total;

			id = $(this).attr("data-id");
			pu = $(this).val();
			cantidad = $(this).attr("data-cantidad");
			valor = pu*cantidad;
			subtotal=0;

			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: { 
					editarajax: 1,
					id: id,
					tabla: "pedidosdetalle",
					campo: "importe",
					valor: valor
				}
			})
			.done(function( msg ) {
			});

			$("#importe"+id).text(parseFloat(Math.round(valor * 100) / 100).toFixed(2));
			for (i = 0; i < '.$num.'; i++) {
				a = $(".importe"+i).text();
				console.log(a);
				subtotal+=(a*1);
			}
			iva = subtotal*0.16;
			total = subtotal*1.16;
			$("#subtotal").text(parseFloat(Math.round(subtotal * 100) / 100).toFixed(2));
			$("#iva").text(parseFloat(Math.round(iva * 100) / 100).toFixed(2));
			$("#total").text(parseFloat(Math.round(total * 100) / 100).toFixed(2));

			$.ajax({
				method: "POST",
				url: "modulos/varios/acciones.php",
				data: { 
					editarajax: 1,
					id: '.$id.',
					tabla: "pedidos",
					campo: "importe",
					valor: total
				}
			})
			.done(function( msg ) {
			});

		}
	});
})
';