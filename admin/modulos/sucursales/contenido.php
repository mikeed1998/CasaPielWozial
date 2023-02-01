

<div class="uk-width-1-1 margen-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<?php 
		echo '
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'" class="color-red">'.$seccion.'</a></li>
		';
		?>

	</ul>
</div>


<div class="uk-width-1-1 margen-v-50">
	<table class="uk-table uk-table-striped uk-table-hover uk-table-small uk-table-middle uk-table-responsive" id="ordenar">
		<thead>
			<tr class="uk-text-muted">
				<th width="90px"></th>
				<th onclick="sortTable(0)">Titulo</th>
				<th width="120px"></th>
			</tr>
		</thead>
		<tbody class="sortable" data-tabla="<?=$seccion?>">
		<?php
		$consulta1 = $CONEXION -> query("SELECT * FROM $seccion ORDER BY orden");
		while ($row_Consulta1 = $consulta1 -> fetch_assoc()) {
			$prodID=$row_Consulta1['id'];
			
			$picTxt='';
			$pic=$rutaFinal.$row_Consulta1['imagen'];
			if(strlen($row_Consulta1['imagen'])>0 AND file_exists($pic)){
				$picTxt='
					<div class="uk-inline">
						<i uk-icon="camera"></i>
						<div uk-drop="pos: right-justify">
							<img src="'.$pic.'" class="uk-border-rounded">
						</div>
					</div>';
			}elseif(strlen($row_Consulta1['imagen'])>0 AND strpos($row_Consulta1['imagen'], 'ttp')>0){
				$pic=$row_Consulta1['imagen'];
				$picTxt= '
					<div class="uk-inline">
						<i uk-icon="camera"></i>
						<div uk-drop="pos: right-justify">
							<img src="'.$pic.'" class="uk-border-rounded">
						</div>
					</div>';
			}

			$link='index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=detalle&id='.$row_Consulta1['id'];

			$estatusIcon=($row_Consulta1['estatus']==1)?'off uk-text-muted':'on uk-text-primary';

			echo '
			<tr id="'.$row_Consulta1['id'].'">
				<td>
					'.$picTxt.'
				</td>
				<td>
					'.$row_Consulta1['titulo'].'
				</td>
				<td class="uk-text-center">
					<button data-id="'.$row_Consulta1['id'].'" class="eliminaprod uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="'.$link.'" class="uk-icon-button uk-button-primary"><i class="fa fa-search-plus"></i></a>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
</div>

<div>
	<div id="buttons">
		<a href="index.php?rand=<?=rand(1,1000)?>&seccion=<?=$seccion?>&subseccion=nuevo" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon:plus;ratio:1.4;"></a> &nbsp;&nbsp;&nbsp;
		<a href="#menu-movil" class="uk-icon-button uk-button-primary uk-box-shadow-large uk-hidden@l" uk-icon="icon:menu;ratio:1.4;" uk-toggle></a>
	</div>
</div>


<?php 
$scripts='
	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarProd&id="+id);
		} 
	});

	$(".estatuschange").click(function(){
		var id = $(this).attr("data-id");
		var estatus = $(this).attr("data-estatus");

		if(estatus==0) {
			estatus=1;
			$("#button" +id + " > i ").addClass("fa-toggle-off");
			$("#button" +id + " > i ").addClass("uk-text-muted");
			$("#button" +id + " > i ").removeClass("fa-toggle-on");
			$("#button" +id + " > i ").removeClass("uk-text-primary");
		}else{
			estatus=0;
			$("#button" +id + " > i ").addClass("fa-toggle-on");
			$("#button" +id + " > i ").addClass("uk-text-primary");
			$("#button" +id + " > i ").removeClass("fa-toggle-off");
			$("#button" +id + " > i ").removeClass("uk-text-muted");
		}
		$(this).attr("data-estatus",estatus);
		console.log(estatus);

		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				id: id,
				estatuschange: 1,
				estatus: estatus
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});

	});

	$(".precio").keypress(function(e) {
		console.log("1");
		if(e.which == 13) {
			var id = $(this).attr("data-id");
			var precio = $(this).val();

			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					id: id,
					changeprecio: 1,
					precio: precio
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		}
	});

	$(".preciodescuento").keypress(function(e) {
		//console.log("1");
		if(e.which == 13) {
			var id = $(this).attr("data-id");
			var preciodescuento = $(this).val();

			$.ajax({
				method: "POST",
				url: "modulos/'.$seccion.'/acciones.php",
				data: { 
					id: id,
					changepreciodescuento: 1,
					preciodescuento: preciodescuento
				}
			})
			.done(function( msg ) {
				UIkit.notification.closeAll();
				UIkit.notification(msg);
			});
		}
	});

	';
?>

