<?php
// DIRECCIONES
	$calle=$row_USER['calle'];
	$noexterior=$row_USER['noexterior'];
	$nointerior=$row_USER['nointerior'];
	$entrecalles=$row_USER['entrecalles'];
	$pais=$row_USER['pais'];
	$estado=$row_USER['estado'];
	$municipio=$row_USER['municipio'];
	$colonia=$row_USER['colonia'];
	$cp=$row_USER['cp'];
	$total = 0;

// TRADUCCION DE PAGINA
	$datosUsuario   = 'Datos de usuario';
    $nombre         = 'Nombre';
    $correo         = 'Email';
    $empresa        = 'Company';
    $telefonoText 	= 'Teléfono';
    $rfc            = 'RFC';
    $domicilio      = 'Domicilio';

    $calleT 			= 'calle';
    $noExterior 	= 'No. Exterior';
    $noInterior 	= 'No. Interior';
    $paisT 			= 'Pais';
    $estadoT 		= 'Estado';
	$municipioT		= 'Municipio';
	$coloniaT		= 'Colonia';
	$cpT 			= 'CP';

    $entre          = 'Between';
    $envio          = 'Send to this address';
    $datosBanco 	= 'Datos para pago bancario';
    $compras 		= 'Compras';
    $contra 		= 'Contraseña';
    $verificarInfo  = 'Si alguna información no es correcta, modifíquela aquí y los cambios se guardarán automáticamente.';
    $cambiar 		= 'Cambiar';
    $cerrarSesion 	= 'Cerrar sesión'; 
    $informacion 	= 'Si alguna información no es correcta, modifíquela aquí y los cambios se guardarán automáticamente.';
    $domicilioFiscal= 'Domicilio Fiscal';

    $sinPedidos 	= 'No ha realizado pedidos';
    $ordenNum 		= 'Orden no.';
    $fechaCuenta 	= 'Fecha';
    $productosCuenta= 'Productos';
    $importeCuenta 	= 'Importe';
    $estatusCuenta 	= 'Estatus';
    $cuentaCuenta	= 'Acciones';

	$pendiente 		= 'Pendiente';
	$pagado 		= 'Pagado';
	$entregado 		= 'Entregado';
	$enviado 		= 'Enviado';

    $borrarCuenta 	= 'Borrar';
    $detalles 		= 'Detalles';

    $guardar 		= 'Guardar';
    $cambiarContra  = 'Cambiar contraseña';
    $repetirContra 	= 'Repetir contraseña';
    $cambiarPerfil 	= 'Cambiar foto de perfil';
    $cargar 		= 'Cargar';
    $subirCompr 	= 'Subir comprobante';

	if ( $languaje == 'en') {

	    $datosUsuario   = 'User data';
	    $nombre         = 'Name';
	    $correo         = 'Email';
	    $empresa        = 'Company';
	    $telefonoText 	= 'Phone';
	    $rfc            = 'RFC';
	    $domicilio      = 'Address';
	    $entre          = 'Between';
	    $envio          = 'Send to this address';

    	$calleT 		= 'Street';
	    $noExterior 	= 'Number';
	    $noInterior 	= 'No. Interior';
	    $paisT 			= 'Country';
	    $estadoT 		= 'State';
		$municipioT		= 'City';
		$coloniaT		= 'Colonia';
		$cpT 			= 'CP';

	    $datosBanco 	= 'Data for bank payment';
    	$compras 		= 'Shopping';
    	$contra 		= 'Password';
    	$verificarInfo  = 'If any information is not correct, modify it here and the changes will be saved automatically.';
	    $cambiar 		= 'Change';
    	$cerrarSesion 	= 'Exit';
    	$informacion 	= 'If any information is not correct, modify it here and the changes will be saved automatically.';
    	$domicilioFiscal= 'Tax residence';

    	$sinPedidos 	= 'You have not placed orders';
    	$ordenNum 		= 'Order number';
    	$fechaCuenta 	= 'Date';
    	$productosCuenta= 'Products';
    	$importeCuenta 	= 'Amount';
	    $estatusCuenta 	= 'Status';
	    $cuentaCuenta	= 'Actions';

	    $pendiente 		= 'Pending';
		$pagado 		= 'Paid';
		$entregado 		= 'Delivered';
		$enviado 		= 'Sent';

    	$borrarCuenta 	= 'Delete';
    	$detalles 		= 'Details';

    	$guardar 		= 'Save';
    	$cambiarContra  = 'Change Password';
    	$repetirContra 	= 'Repeat password';
    	$cambiarPerfil 	= 'Change profile picture';
    	$cargar 		= 'Upload';
    	$subirCompr 	= 'Upload voucher';


	}

?>
<!DOCTYPE html>
<html lang="<?=$languaje?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="description" content="<?=$description?>">
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?=$title?>">
  <meta property="og:description" content="<?=$description?>">
  <meta property="og:url" content="<?=$rutaEstaPagina?>">
  <meta property="og:image" content="<?=$ruta?>img/design/logo-og.jpg">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>

<?=$header?>

<div class="uk-container padding-v-100">
	<div class="uk-card uk-card-default uk-card-body">
		<div class="uk-grid-match" uk-grid>
			<div class="uk-width-auto@m uk-width-1-1">
				<div>
					<?php
					$profileRuta= '../img/contenido/profile/';
					$profilePic = (strlen($row_USER['imagen'])>0 AND file_exists($profileRuta.$row_USER['imagen'].'.jpg'))?$profileRuta.$row_USER['imagen'].'.jpg':$profileRuta.'default.jpg';
					echo '
					<div class="uk-inline-clip uk-transition-toggle">
						<img src="'.$profilePic.'" class="uk-border-rounded" alt="Profile picture">
						<a href="#profilepic" uk-toggle>
							<div class="uk-transition-slide-bottom uk-position-bottom uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
								<p class="uk-h4 uk-margin-remove">'.$cambiar.'</p>
							</div>
						</a>
					</div>';
					?>
				</div>
				<div>
					<a href="logout" class="uk-button uk-button-danger"><?=$cerrarSesion?></a>
				</div>
			</div>
			<div class="uk-width-1-3@m uk-width-1-1">
				<div class="uk-card uk-card-default">
					<div class="uk-card-body">
						<p><i class="fa fa-2x fa-user"></i> &nbsp;&nbsp; <?=$datosUsuario?></p>
						<p>
							<span class="uk-text-muted"><?=$nombre?>:</span> <?=$unombre?><br>
							<span class="uk-text-muted"><?=$correo?>:</span> <?=$uemail?><br>
							<span class="uk-text-muted"><?=$telefonoText?>:</span> <?=$row_USER['telefono']?><br>
							
							<span class="uk-text-muted"><?=$rfc?>:</span> <?=$row_USER['rfc']?>
						</p>
					</div>
				</div>
			</div>
			<div class="uk-width-expand@m uk-width-1-1">
				<div class="uk-card uk-card-default">
					<div class="uk-card-body">
						<p><?=$datosBanco?></p>
						<p>
						<?php
						$CONSULTA= $CONEXION -> query("SELECT bank FROM configuracion WHERE id = 1");
						$rowCONSULTA = $CONSULTA-> fetch_assoc();
						echo nl2br($rowCONSULTA['bank']);
						?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div uk-grid>
			<div class="uk-width-1-1 padding-v-50">
				<ul uk-tab uk-switcher>
					<li class="uk-active"><a href=""><?=$compras?></a></li>
					<li><a href=""><?=$domicilio?></a></li>
					<li><a href=""><?=$contra?></a></li>
				</ul>

				<ul class="uk-switcher">
					<!-- Pedidos -->
					<li>
						<?php
						$CONSULTA = $CONEXION -> query("SELECT * FROM pedidos WHERE invisible = 0 AND uid = $uid ORDER BY id DESC");
						$numPedidos=$CONSULTA->num_rows;
						if ($numPedidos==0) {
							echo '
							<div uk-alert class="uk-alert-danger uk-text-center">
								'.$sinPedidos.'
							</div>';
						}else{
							echo '
							<table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-responsive uk-text-center">
								<thead>
									<tr>
										<td>'.$ordenNum.'</td>
										<td>'.$fechaCuenta.'</td>
										<td>'.$productosCuenta.'</td>
										<td>'.$importeCuenta.'</td>
										<td>'.$estatusCuenta.'</td>
										<td>'.$cuentaCuenta.'</td>
									</tr>
								</thead>
								<tbody>
							';
							while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
								$pedido=$row_CONSULTA['id'];
								$segundos=strtotime($row_CONSULTA['fecha']);
								$fecha=date('d-m-Y',$segundos);
								$guia='';
								$fichaUpload='';



								// Verificamos el estatus del pedido
								switch ($row_CONSULTA['estatus']) {
									case 0:
										$clasePagar='';
										$estatusLegend=$pendiente;
										$estatusClase='danger';
										$fichaUpload='
										<br><br>
										<a href="#comprobantemodal" class="comprobantebutton uk-button uk-button-primary uk-button-small" uk-toggle data-id="'.$pedido.'">'.$subirCompr.'</a>';
										$fichaUpload.=(strlen($row_CONSULTA['comprobante'])>0 AND file_exists('img/contenido/comprobantes/'.$row_CONSULTA['comprobante']))?'
										<br><br>
										<a href="../img/contenido/comprobantes/'.$row_CONSULTA['comprobante'].'" target="_blank" class="uk-button uk-button-white uk-button-small">Ver adjuntos</a>':'';
										break;
									case 1:
										$clasePagar='uk-hidden';
										$estatusLegend=$pagado;
										$estatusClase='primary';
										break;
									case 2:
										$clasePagar='uk-hidden';
										$estatusLegend=$enviado;
										$estatusClase='warning';
										if (strlen($row_CONSULTA['guia'])>0) {
											$guia='<button class="uk-button uk-width-1-1">Guía:<br>'.$row_CONSULTA['guia'].'</button>';
										}
										break;
									case 3:
										$clasePagar='uk-hidden';
										$estatusLegend=$entregado;
										$estatusClase='success';
										break;
								}

								$numProds=0;
								$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $pedido");
								while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
									$numProds+=$row_CONSULTA1['cantidad'];
								}
								echo '
										<tr id="pedido'.$pedido.'">
											<td><span class="uk-hidden@m uk-text-muted">'.$ordenNum.'</span>'.$pedido.'</td>
											<td><span class="uk-hidden@m uk-text-muted">'.$fechaCuenta.'</span>'.$fecha.'</td>
											<td><span class="uk-hidden@m uk-text-muted">'.$productosCuenta.'</span>'.$numProds.'</td>
											<td><span class="uk-hidden@m uk-text-muted">'.$importeCuenta.'</span>$'.number_format($row_CONSULTA['importe'],2).'</td>
											<td><span class="uk-hidden@m uk-text-muted">'.$estatusCuenta.'</span>
												<span class="uk-alert-'.$estatusClase.' padding-10" uk-alert>'.$estatusLegend.'</span>
												'.$fichaUpload.'
											</td>
											<td width="270px" class="uk-text-right">
												'.$guia.'
												<a href="'.$row_CONSULTA['idmd5'].'_por_pagar" class="'.$clasePagar.' uk-button uk-button-small uk-button-primary">PayPal</a>
												<button class="borrarpedido uk-button uk-button-small uk-button-danger" data-id="'.$pedido.'">'.$borrarCuenta.'</button>
												<a href="'.$row_CONSULTA['idmd5'].'_detalle" class="uk-button uk-button-small uk-button-default">'.$detalles.'</a>	
											</td>
										</tr>
									';

								$CONSULTA1 = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $pedido");
								while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){

									$link=$row_CONSULTA1['producto'].'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['productotxt'])))).'_.html';
									
								}
								mysqli_free_result($CONSULTA1);
							}
							mysqli_free_result($CONSULTA);
							echo '
								</tbody>
							</table>
							';
						}
						?>
					</li>
					<!-- Domicilios -->
					<li>
						<div class="uk-child-width-1-2@m" uk-grid>
							<div class="uk-width-1-1 uk-text-muted">
								<?=$informacion?>
							</div>
							<div>
								<div>
									<h2><?=$datosUsuario?></h2>
								</div>
								<div>
									<label for="nombre" class="uk-form-label uk-text-capitalize"><?=$nombre?></label>
									<input type="text" data-campo="nombre" value="<?=$row_USER['nombre']?>" class="editar uk-input uk-input-grey">
								</div>
								<div>
									<label for="email" class="uk-form-label uk-text-capitalize"><?=$correo?></label>
									<input type="text" data-campo="email" value="<?=$row_USER['email']?>" class="editar uk-input uk-input-grey">
								</div>
								<div>
									<label for="telefono" class="uk-form-label uk-text-capitalize"><?=$telefonoText?></label>
									<input type="text" data-campo="telefono" value="<?=$row_USER['telefono']?>" class="editar uk-input uk-input-grey">
								</div>
								<div>
									<label for="empresa" class="uk-form-label uk-text-capitalize"><?=$empresa?></label>
									<input type="text" data-campo="empresa" value="<?=$row_USER['empresa']?>" class="editar uk-input uk-input-grey">
								</div>
								<div>
									<label for="rfc" class="uk-form-label uk-text-uppercase"><?=$rfc?></label>
									<input type="text" data-campo="rfc" value="<?=$row_USER['rfc']?>" class="editar uk-input uk-input-grey uk-text-uppercase">
								</div>
							</div>
							<div>
								<div>
									<h2><?=$domicilioFiscal?></h2>
								</div>
								<div>
									<label for="calle" class="uk-form-label uk-text-capitalize"><?=$calleT?></label>
									<input type="text" data-campo="calle" value="<?=$calle?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="noexterior" class="uk-form-label uk-text-capitalize"><?=$noExterior?></label>
									<input type="text" data-campo="noexterior" value="<?=$noexterior?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="nointerior" class="uk-form-label uk-text-capitalize"><?=$noInterior?></label>
									<input type="text" data-campo="nointerior" value="<?=$nointerior?>" class="editar uk-input uk-input-grey">
								</div>
								<div>
									<label for="entrecalles" class="uk-form-label uk-text-capitalize"><?=$entre?></label>
									<input type="text" data-campo="entrecalles" value="<?=$entrecalles?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="pais" class="uk-form-label uk-text-capitalize"><?=$paisT?></label>
									<input type="text" data-campo="pais" value="<?=$pais?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="estado" class="uk-form-label uk-text-capitalize"><?=$estadoT?></label>
									<input type="text" data-campo="estado" value="<?=$estado?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="municipio" class="uk-form-label uk-text-capitalize"><?=$municipioT?></label>
									<input type="text" data-campo="municipio" value="<?=$municipio?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="colonia" class="uk-form-label uk-text-capitalize"><?=$coloniaT?></label>
									<input type="text" data-campo="colonia" value="<?=$colonia?>" class="editar uk-input uk-input-grey" >
								</div>
								<div>
									<label for="cp" class="uk-form-label uk-text-uppercase"><?=$cpT?></label>
									<input type="text" data-campo="cp" value="<?=$cp?>" class="editar uk-input uk-input-grey" >
								</div>
							</div>
						</div>
					</li>
					<!-- Contraseña -->
					<li>
						<div class="uk-container uk-container-small">
							<h3><?=$cambiarContra?></h3>
							<input type="password" id="pass1" name="pass1" class="uk-input" required>
							<label for="pass2" class="uk-form-label"><?=$repetirContra?></label>
							<input type="password" id="pass2" name="pass2" class="uk-input" required>
							<button id="enviarpass" class="uk-button uk-button-personal uk-margin-top"><?=$guardar?></button>
						</div>
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>

<div class="padding-v-20">
</div>

<?=$footer?>

<div id="profilepic" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<h2 class="uk-modal-title"><?=$cambiarPerfil?></h2>
		<div id="fileuploader">
			<?=$cargar?>
		</div>
	</div>
</div>
 
<div id="comprobantemodal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<button class="uk-modal-close-default" type="button" uk-close></button>
		<h2 class="uk-modal-title">Subir comprobante</h2>
		<input type="hidden" id="pedidoid">
		<div id="comprobante">
			Cargar
		</div>
	</div>
</div>
 
<?=$scriptGNRL?>

<!-- Imágenes -->
<link href="../library/upload-file/css/uploadfile.custom.css" rel="stylesheet">
<script src="../library/upload-file/js/jquery.uploadfile.js"></script>

<script>
	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: 'false',
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview: false,
			returnType:'json',
			onSuccess:function(data){ 
				window.location = ('../includes/acciones.php?profilepicchange='+data);
			}
		});

		$('.comprobantebutton').click(function(){
			var id=$(this).attr('data-id');
			$('#pedidoid').val(id);
		})

		$("#comprobante").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: 'false',
			allowedTypes: "jpeg,jpg,png,gif,pdf",
			maxFileSize: 6291456,
			showFileCounter: false,
			showPreview: false,
			returnType:'json',
			onSuccess:function(data){ 
				var id = $('#pedidoid').val();
				window.location = ('../includes/acciones.php?id='+id+'&comprobantefile='+data);
			}
		});

		$("#pass1").keyup(function() {
			var pass  = $("#pass1").val();
			var len   = (pass).length;

			if(len>6){
				$('#pass1').removeClass("uk-form-danger");
				$('#pass1').addClass("uk-form-success");
			}else{
				$('#pass1').removeClass("uk-form-success");
				$('#pass1').addClass("uk-form-danger");
			}
		});

		$("#pass2").keyup(function() {
			var pass  = $("#pass1").val();
			var len   = (pass).length;
			var passc = $(this).val();

			if(len>6){
				$('#pass1').removeClass("uk-form-danger");
				$('#pass2').addClass("uk-form-danger");
				if(pass!=passc){
					$('#pass1').addClass("uk-form-success");
				}else{
					$('#pass2').addClass("uk-form-success");
				}
			}else{
				$('#pass1').addClass("uk-form-danger");
			}

		});

		$('#enviarpass').click(function(){
			var pass1 = $('#pass1').val();
			var pass2 = $('#pass2').val();
			var len   = (pass1).length;

			if (pass1==pass2 && len > 6) {
				$.ajax({
					method: "POST",
					url: "../includes/acciones.php",
					data: { 
						passwordchange: 1,
						pass1: pass1,
						pass2: pass2
					}
				})
				.done(function( response ) {
					console.log(response);
					datos = JSON.parse(response);
					UIkit.notification.closeAll();
					UIkit.notification(datos.msj);
				});
			}
		})

		$(".editar").focusout(function() {
			var id    = '<?=$uid?>';
			var tipo  = 'personal';
			var campo = $(this).attr("data-campo");
			var valor = $(this).val();
			//console.log('ID: ' + id  + ' - Tipo: ' + tipo  + ' - Campo: ' + campo  + ' - Valor: ' + valor );
			$.ajax({
				method: "POST",
				url: "../includes/acciones.php",
				data: { 
					editacliente: 1,
					id: id,
					tipo: tipo,
					campo: campo,
					valor: valor
				}
			})
			.done(function( response ) {
				console.log( response );
				datos = JSON.parse(response);
				UIkit.notification.closeAll();
				UIkit.notification(datos.msj);
			});
		});

		$(".borrarpedido").click(function() {
			var id    = $(this).attr("data-id");

			UIkit.modal.confirm('Está seguro de borrar este pedido?').then(function () {
				console.log('Confirmed.');
				$.ajax({
					method: "POST",
					url: "../includes/acciones.php",
					data: { 
						borrarpedido: 1,
						id: id
					}
				})
				.done(function( response ) {
					console.log( response );
					datos = JSON.parse(response);
					UIkit.notification.closeAll();
					UIkit.notification(datos.msj);
					if (datos.estatus==0) {
						$('#pedido'+id).toggle();
					}
				});
			}, function () {
				console.log('Rejected.')
			});
		});
	});
</script>

</body>
</html>