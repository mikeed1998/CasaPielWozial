<!DOCTYPE html>
<?=$headGNRL?>
<body>

    <?php
        $id_pedido = $_POST['id_pedido'];
        $usu_id = $_POST['usu_id'];
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$telefono = $_POST['telefono'];
		$precio_total = $_POST['precio_total'];
		$descripcion_pago = $_POST['descripcion_pago'];
		//$descuento = $_SESSION['descuento'];
		$producto_id = $_POST['producto_id'];
		$item_id = $_POST['item_id'];
		// $p_d = $_POST['producto_descripcion'];
		// $p_i = $_POST['precio_indv'];
		// $importe = $_POST['importe'];
		$calle = $_POST['calle'];
		$noexterior = $_POST['noexterior'];
		$nointerior = $_POST['nointerior'];
		$pais = $_POST['pais'];
		$estado = $_POST['estado'];
		$municipio = $_POST['municipio'];
		$colonia = $_POST['colonia'];
		$cp = $_POST['cp'];
        $cantidad = $_POST['cantidad'];
        $cupon = $_POST['cupon'];
        $cupon_desc = $_POST['cupon_desc'];

        if(isset($_POST['token_id'])){

            // require_once '../includes/connection.php';
            require_once('C:\xampp\htdocs\CasaPiel\includes\connection.php');
           
            //require_once '../library/Openpay3.3/Openpay.php';
            // $id_cot = $_POST['idcot'];
        
            // require(dirname(_FILE_) . '/../library/Openpay/Openpay.php');
            require('C:\xampp\htdocs\CasaPiel\library\Openpay\Openpay.php');
        
            $op = new Openpay\Data\Openpay();
            $MERCHANT_ID = $op->setId('mqq6zbbrv6kqpilztchv');
            $PRIVATE_KEY = $op->setApiKey('sk_1ee6fad5051f44d9b72fdcead6336af7');
            $op->setProductionMode(false);
            $op->setCountry('MX');
            // $openpay = $op->getInstance('mjib8v8utgkjed5sp0nj', 'pk_22d6f1fda1054c6cbb1340b200f821f5', 'MX');
        
            $openpay = $op->getInstance($MERCHANT_ID, $PRIVATE_KEY, 'MX');
        
            $customer = array(
                'name' => $_POST['nombre'],
                'last_name' => '',
                'phone_number' => $_POST['telefono'],
                'email' => $_POST['email'],
            );
        
            $chargeData = array(
                'method' => 'card',
                'source_id' => $_POST['token_id'],
                'amount' => $_POST['precio_total'], // formato númerico con hasta dos dígitos decimales. 
                'description' => $_POST['descripcion_pago'],
                'device_session_id' =>  $_POST['deviceIdHiddenFieldName'],
                'customer' => $customer
                );
        
            $charge = $openpay->charges->create($chargeData);
        
            if($charge->status == "completed"){
                // $registrarPago = "INSERT INTO `pedidost`(`idmd5`, `uid`,     `nombre`,  `email`,  `estatus`,   `invisible`, `notify`, `guia`, `fecha`,  `dom`, `factura`, `tabla`, `cantidad`,  `importe`,       `envio`, `comprobante`, `imagen`, `ipn`, `calle`,  `noexterior`,  `nointerior`,  `entrecalles`, `pais`,  `estado`,  `municipio`,  `colonia`,  `cp`, `cupon`,   `cupon_desc`) 
                //                                VALUES   ('',      '$usu_id', '$nombre', '$email', '',          '',          '',       '',     '$ahora', '',    '',        '',      '$cantidad', '$precio_total', '',      '',            '',       '',    '$calle', '$noexterior', '$nointerior', '',            '$pais', '$estado', '$municipio', '$colonia', '$cp', '$cupon', '$cupon_desc')";                                             
                $registrarPago = "UPDATE `pedidost` SET `uid` = '$usu_id', `nombre` = '$nombre',  `email` = '$email',  `fecha` = '$ahora', `cantidad` = '$cantidad',  `importe` = '$precio_total', `calle` = '$calle',  `noexterior` = '$noexterior',  `nointerior` = '$nointerior', `pais` = '$pais',  `estado` = '$estado',  `$municipio` = '$municipio', `colonia` = '$colonia',  `cp` = '$cp', `cupon` = '$cupon', `cupon_desc` = '$cupon_desc' WHERE `id` = '$id_pedido'"; 
                // mysqli_query($CONEXION, $registrarPago) or die(mysqli_error($CONEXION));
                
                if (mysqli_query($CONEXION, $registrarPago)) {
                    echo '
                        <div class="container mt-5 mb-5 py-5">
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-success"><strong>Success!</strong> Pago realizado con exito, regresando a la página principal.</div>
                                </div>
                            </div>
                        </div>
                    ';
                } else {
                    echo "error";
                }


            //     $update_open = "UPDATE cotizacion_personalizada SET estado_openpay = 1 WHERE id_cot_p = $id_cot";
            //     if (mysqli_query($CONEXION, $update_open)) {
            //         echo "completed";
            //   } else {
            //         echo "error";
                    
            //   }
            }else{
                echo $charge->status;
            }
        
        }
    ?>

<?=$scriptGNRL?>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            window.location.href = "<?=$rutaInicio?>"
        }, 5000);
    });
</script>
</body>
</html>




