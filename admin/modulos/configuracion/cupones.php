<!-- mensaje toatr -->
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<script src="plugins/toastr/toastr.min.js" ></script>
<!-- mensaje toatr -->

<?php
	$tabla='cupones';

// Breadcrumb
echo '
	<div class="uk-width-auto margin-top-20">
		<ul class="uk-breadcrumb uk-text-capitalize">
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$seccion.'">Configuración</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&modulo='.$seccion.'&archivo='.$subseccion.'" class="color-red">'.$subseccion.'</a></li>
		</ul>
	</div>';

// Acciones
	echo '
	<div class="uk-width-expand@s margin-top-20">
		<div class="uk-text-right uk-margin">
			<a href="#add" uk-toggle class="uk-button uk-button-success"><i uk-icon="plus"></i> &nbsp; Nuevo cupón</a>
		</div>
	</div>
	';

// Cupones
echo '
	<div class="uk-width-1-1">
		<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive">
			<thead>
				<tr>
					<th width="180px">Códogo</th>
					<th width="auto">Descripción</th>
					<th width="10px" class="uk-text-center">Descuento</th>
					<th width="10px">Vigencia</th>
					<th width="80px" class="uk-text-center">Usos</th>
					<th width="10px">Activo</th>
					<th width="30px"></th>
				</tr>
			</thead>
			<tbody>';
				// Obtener tipos
				$CONSULTA = $CONEXION -> query("SELECT * FROM $tabla ORDER BY vigencia");
				while ($rowCONSULTA = $CONSULTA -> fetch_assoc()) {
					foreach ($rowCONSULTA as $key => $value) {
						${$key}=$value;
					}
					$estatusIcon=($estatus==0)?'off uk-text-muted':'on uk-text-primary';

					echo '
					<tr id="row'.$id.'">
						<td class="uk-text-left">
							<span class="uk-hidden@m uk-text-muted">Código: </span>
							<input class="editarajax uk-input uk-form-small uk-form-blank" type="text" data-tabla="'.$tabla.'" data-campo="codigo" data-id="'.$id.'" value="'.$codigo.'">
						</td>
						<td class="uk-text-left">
							<span class="uk-hidden@m uk-text-muted">Descripción: </span>
							<input class="editarajax uk-input uk-form-small uk-form-blank" type="text" data-tabla="'.$tabla.'" data-campo="txt" data-id="'.$id.'" value="'.$txt.'">
						</td>
						<td class="uk-text-center@m">
							<span class="uk-hidden@m uk-text-muted">Descuento: </span>
							<input class="editarajax uk-input uk-form-small uk-form-blank input-number descuento uk-text-right" type="number" data-tabla="'.$tabla.'" data-campo="descuento" data-id="'.$id.'" value="'.$descuento.'" style="width:100px;">
						</td>
						<td class="uk-text-nowrap">
							<span class="uk-hidden@m uk-text-muted">Vigencia: </span>
							<input class="editarajax uk-input uk-form-small uk-form-blank" type="date" data-tabla="'.$tabla.'" data-campo="vigencia" data-id="'.$id.'" value="'.$vigencia.'" style="width:180px;">
						</td>
						<td class="uk-text-center@m">
							<span class="uk-hidden@m uk-text-muted">Usos</span>
							'.$usos.'
						</td>
						<td class="uk-text-center@m">
							<span class="uk-hidden@m uk-text-muted">Activo: </span>
							<i class="estatuschange pointer fas fa-lg fa-toggle-'.$estatusIcon.'" data-tabla="'.$tabla.'" data-campo="estatus" data-id="'.$id.'" data-valor="'.$estatus.'"></i>
						</td>
						<td class="uk-text-nowrap">
							<!-- <a href="javascript:eliminargeneral('.$id.',\'productosmarcas\')" class="borrar color-red" uk-icon="trash"></a> -->
                            <button onclick="eliminarC('.$id.')" id="bc" class="borrar color-red" uk-icon="trash"></button>
							<!--
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="index.php?rand='.rand(1,1000).'&modulo='.$seccion.'&archivo=cuponedetalle&id='.$id.'" class="uk-text-primary" uk-icon="search"></a>
							-->
						</td>
					</tr>';
				}
				echo '
			</tbody>
		</table>
	</div>';

// Auxiliar para leer el id que se desea editar
echo '
	<input type="hidden" id="fichaid">';

// MODAL NUEVO
    
	echo '
	<div id="add" uk-modal class="modal">
		<div class="uk-modal-dialog uk-modal-body">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h4>Nuevo cupón</h4>
			<form action="" method="post">
				<input type="hidden" name="nuevocupon" value="1">
				<input type="hidden" name="modulo" value="'.$seccion.'">
				<input type="hidden" name="archivo" value="'.$subseccion.'">

				<div uk-grid class="uk-grid-small">
					<div class="uk-width-1-1">
						<label>
							Código
							<input type="text" id="codigo" name="codigo" class="uk-input" required>
						<label>
					</div>
					<div class="uk-width-1-1">
						<label>
							Descripción
							<input type="text" id="txt" name="txt" class="uk-input" required>
						<label>
					</div>
					<div class="uk-width-1-1">
						<label>
							Descuento
							<input type="text" id="descuento" name="descuento" class="uk-input input-number descuento" required>
						<label>
					</div>
					<div class="uk-width-1-1">
						<label>
							Vigencia
							<input type="date" id="vigencia" name="vigencia" class="uk-input" required>
						<label>
					</div>
					<div class="uk-width-1-1 uk-text-center">
						<a href="#" class="uk-button uk-button-white uk-button-large uk-modal-close" tabindex="10">Cancelar</a>
						<button onclick="agregarC()" class="uk-button uk-button-primary uk-button-large">Agregar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	';

   
$scripts='

    function agregarC() {
        var codigo = document.getElementById("codigo").value;
        var txt = document.getElementById("txt").value;
        var descuento = document.getElementById("descuento").value;
        var vigencia = document.getElementById("vigencia").value;

        //var URLactual = window.location.origin;
	    //var UrlAjax = URLactual+"/tiendaNaturista/includes/widgets.php";
	    var UrlAjax = "modulos/configuracion/acciones.php";
		    $.ajax({
    		url : UrlAjax,
	    	type : "POST",
		    dataType : "html",
	    	data : {codigo: codigo, txt: txt, descuento: descuento, vigencia: vigencia}
	    })
        .done(function(resultado){
            if(resultado == 1){
            toastr["success"]("Cupón agregado exitosamente", "Nuevo cupón");
            setTimeout(function () { location.reload(); }, 2500);
            }else{
                toastr["error"]("Error eliminar ", "Fallo");
            }
        })
    }

    function eliminarC(id) {
        var id_cupon = id;
	
	    //var URLactual = window.location.origin;
	    //var UrlAjax = URLactual+"/tiendaNaturista/includes/widgets.php";
        var UrlAjax = "modulos/configuracion/acciones.php";
    		$.ajax({
	    	url : UrlAjax,
		    type : "POST",
    		dataType : "html",
	    	data : {id_cupon: id_cupon},
	    })
	    .done(function(resultado){
		    if(resultado == 1){
	    	    setTimeout(function () { location.reload(); }, 2500);
		    }else{
	    	}
	    })
	}
   

	// Elimina general
	function eliminargeneral (id,tabla) { 
		UIkit.modal.confirm("Realmente desea borrar esto?").then(function() {
			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					eliminargeneral: 1,
					id: id,
					tabla: "'.$tabla.'"
				}
			})
			.done(function( response ) {
				console.log( response );
				UIkit.notification.closeAll();
				datos = JSON.parse( response );
				UIkit.notification(datos.msj,{pos:"bottom-right"});
				if(datos.estatus==1){
					$("#row"+id).fadeOut();
				}
			});
		}, function () {
			console.log("Rechazado")
		});
	}

	
	$(".fichalink").click(function(){
		var id = $(this).attr("data-id");
		$("#fichaid").val(id);
	})

	';










