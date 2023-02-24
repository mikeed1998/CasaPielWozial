<!DOCTYPE html>
<?=$headGNRL?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<body>
<?=$header?>
	<?php
		$id_usu = $_POST['usu_id'];
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$telefono = $_POST['telefono'];
		$precio_total = $_POST['precio_total'];
		$descripcion_pago = $_POST['descripcion_pago'];
		$descuento = $_SESSION['descuento'];
	?>
  
    <?php
		echo "ID: " . $_POST['usu_id'] . '<br>';
        echo 'Nombre: ' . $_POST['nombre'] . '<br>'; 
        echo 'Correo: ' . $_POST['email'] . '<br>';
        echo 'Telefono: ' . $_POST['telefono'] . '<br>';
        echo 'Precio Total: ' . $_POST['precio_total'] . '<br>';
        echo 'Descripción del pago: ' . $_POST['descripcion_pago'] . '<br>';
		echo 'Descuento del ' . $_SESSION['descuento'] . '%<br>';
    ?>

    <div class="container py-5 d-flex justify-content-center">				
		<form class="col-8" action="AccionesPago" method="POST" id="payment-form">
		    <input type="hidden" name="token_id" id="token_id">
			<input type="hidden" name="nombre" id="nombre" value="<?php echo $nombre;?>">
			<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
			<input type="hidden" name="telefono" id="telefono" value="<?php echo $telefono;?>">
			<input type="hidden" name="precio_total" id="precio_total" value="<?php echo $precio_total;?>">
			<input type="hidden" name="descripcion_pago" id="descripcion_pago" value="<?php echo $descripcion_pago;?>">
			<input type="hidden" name="use_card_points" id="use_card_points" value="false">
		    <div class="pymnt-itm card  active" style="border-radius:16px; background:#f7f7f7;">
			    <div class="card-header " style="background:#e8e8e8;">
				    <h5 class="my-auto">Tarjeta de crédito o débito</h5>
				</div>
				<div class="pymnt-cntnt p-3">
					<div class="card-expl p-3 d-flex row mb-4">
						<div class="credit col-4"><h5>Tarjetas de crédito</h5><img src="../img/design/tarjetas-mini.jpg" style="width:150px;"></div>
							<div class="debit col-8"><h5>Tarjetas de débito</h5><img src="../img/design/bancos.jpg" style="width:600px;"></div>
						</div>
						<div class="sctn-row">
							<div class="col-12 p-3 d-flex row">
								<div class="col-6">
									<label>Nombre del titular</label><input class="form-control" type="text" placeholder="Como aparece en la tarjeta" maxlength="" autocomplete="off" data-openpay-card="holder_name">
								</div>
								<div class="col-6">
									<label>Número de tarjeta</label><input class="form-control" type="text" autocomplete="off" maxlength="16" data-openpay-card="card_number"></div>
								</div>
							</div>
							<div class="col-12 p-3 d-flex row">
								<div class="col-6">
									<label>Fecha de expiración</label>
									<div class="col-12  d-flex row">
										<div class="col-4 half l"><input class="form-control" type="text" placeholder="Mes" maxlength="2" data-openpay-card="expiration_month"></div>
										<div class="col-4 half l"><input class="form-control" type="text" placeholder="Año" maxlength="2" data-openpay-card="expiration_year"></div>
									</div>
								</div>
								<div class="col-6 cvv"><label>Código de seguridad</label>
									<div class="col-12  d-flex row">
										<div class="col-5 half l"><input class="form-control" type="text" placeholder="3 dígitos" maxlength="3" autocomplete="off" data-openpay-card="cvv2"></div>
										<div class="col-4"><i class="far fa-credit-card" style="font-size:35px;"></i></div>
									</div>
								</div>
							</div>
							<div>
								<div><div></div>
								<div></div>
							</div>
							<div class="col-12 p-3 d-flex row justify-content-end">
								<div class="openpay col-5 d-flex flex-column justify-content-center">
									<p class="col-12 text-end">Transacciones realizadas vía:</p>
									<div class="col-12 d-flex row justify-content-end">
										<img src="../img/design/openpay-color.jpg" style="width:150px;">
									</div>
								</div>
								<div class="col-1" style="border-right: 1px solid #000;">	
									</div>
										<div  class="shield col-6 d-flex flex-column justify-content-center">
											<div class="col-12 d-flex row">
											<div class="col-1 m-auto" style="font-size:30px;"><i class="fas fa-check-circle "></i></div>
												<p class="col-11 my-auto p-4">Tus pagos se realizan de forma segura con encriptación de 256 bits.</p>
											</div>		
										</div>
									</div>
								</div>
								<div class="sctn-row col-12 d-flex justify-content-end">
									<a class="btn btn-danger col-2 m-3" id="pay-button" style="border-radius:16px;">Pagar</a>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
		</form>
	</div>
	
	<script type="text/javascript">
	 	$(document).ready(function() {
  			OpenPay.setId('mqq6zbbrv6kqpilztchv');
  			OpenPay.setApiKey('pk_f2c3003e1aab4048a7880a6fdd308abf');
  			OpenPay.setSandboxMode(true);
  			var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
  			console.log(deviceSessionId);
  		});

  		$('#pay-button').on('click', function(event) {
      	 	event.preventDefault();
       		$("#pay-button").prop( "disabled", true);
       		OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);              
		});

		var success_callbak = function(response) {
            var token_id = response.data.id;
            $('#token_id').val(token_id);

			console.log(response.data);
            $('#payment-form').submit();


		};

		var error_callbak = function(response) {
    		console.log(response.data);
    		var desc = response.data.description != undefined ? response.data.description : response.message;
			//console.log(response);

			switch(response.data.error_code){
				case 2004:
					Swal.fire({
						position: 'center',
						icon: 'info',
						title: 'Numero de tarjeta invalido',
						showConfirmButton: false,
					})
					break;
				case 2005:
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Fecha de expiracion caduca',
						showConfirmButton: false,
					})
					break;
				case 1001:
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Fecha de expiracion caduca',
						showConfirmButton: false,
					})
					break;
				case 2006:
					Swal.fire({
						position: 'center',
						icon: 'info',
						title: 'Se requiere el código de seguridad CVV2',
						showConfirmButton: false,
					})
					break;
			}
 		   	
			//  var desc = response.data.description != undefined ?
    		//     response.data.description : response.message;
    		//  alert("ERROR [" + response.status + "] " + desc);
    		//  $("#pay-button").prop("disabled", false);
		};
    </script>
<?=$footer?>
<?=$scriptGNRL?>
</body>
</html>