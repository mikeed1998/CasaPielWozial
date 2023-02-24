<!DOCTYPE html>
<?=$headGNRL?>
<body>

    <?php
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
                $u = $_POST['email']; 
                $d = $_POST['descripcion_pago'];
                $t = $_POST['precio_total'];

                $open = "INSERT INTO historial_pagos(usuario, descripcion, total) VALUES ('$u', '$d', '$t')";

                if (mysqli_query($CONEXION, $open)) {
                    echo "completed";
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
</body>
</html>




