<?php
if(isset($_SESSION['carro']) AND count($arreglo)>0){
  // Sandobox o Público
  $sandbox=($payPalCliente=='business@efra.biz')?'sandbox.':'';

  $style[0]='style="background-color:#EEE;"';
  $style[1]='style="background-color:#FFF;"';
  $num=0;
    // Requiere factura
  $requiereFactura=(isset($_SESSION['requierefactura']))?$_SESSION['requierefactura']:0;

  // Formar la tabla del pedido
  $tabla='
    <table style="width: 100%;" cellspacing="2" border="0" bgcolor="grey">
      <tr '.$style[1].'>
        <td style="width: 25%; padding:8px;">Producto</td>
        <td style="width: 9%; padding:8px;">Talla</td>
        <td style="width: 9%; padding:8px;">Color</td>
        <td style="width: 14%; padding:8px; text-align: center;">Cantidad</td>
        <td style="width: 14%; padding:8px; text-align: right; ">Precio lista</td>
        <td style="width: 14%; padding:8px; text-align: right; ">Precio final</td>
        <td style="width: 15%; padding:8px; text-align: right; ">Importe</td>
      </tr>';

  $subtotal=0;
  $envioGlobal=$shippingGlobal;
  $count=0;


  $sql = "INSERT INTO pedidos (uid,fecha,factura) VALUES ('$uid','$ahora','$requiereFactura')";
  if($insertar = $CONEXION->query($sql)){
    $pedidoId=$CONEXION->insert_id;
    $idmd5=md5($pedidoId);

    // Build the query string
    $queryString  = "?cmd=_cart";
    $queryString .= "&upload=1";
    $queryString .= "&trackingId=".$pedidoId;
    $queryString .= "&noshipping=0";
    $queryString .= "&charset=utf-8";
    $queryString .= "&currency_code=MXN";
    $queryString .= "&business=" . urlencode($payPalCliente);
    $queryString .= "&return=".$ruta . 'success';
    $queryString .= "&notify_url=".$ruta . urlencode($idmd5.'_IPN');


    foreach ($arreglo as $key) {
      $itemId=$key['Id'];

      $CONSULTA0 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $itemId");
      $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
      $prodId=$row_CONSULTA0['producto'];
      $tallaId=$row_CONSULTA0['talla'];
      $colorId=$row_CONSULTA0['color'];
      

      $CONSULTA1 = $CONEXION -> query("SELECT * FROM productos WHERE id = $prodId");
      $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
      $producto=$row_CONSULTA1['sku'].' - '.$row_CONSULTA1['titulo'];

      $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaId");
      $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
      $talla=$row_CONSULTA2['txt'];

      $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorId");
      $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
      $colorName=$row_CONSULTA3['name'];

      $imagen   = $ruta.'img/contenido/productoscolor/'.$row_CONSULTA3['imagen'];
      $color=(strlen($row_CONSULTA3['imagen'])>0)?'<img src="'.$imagen.'" class="uk-border-circle" style="width:35px;height:35px;">':'<div class="uk-border-circle" style="background:'.$row_CONSULTA3['txt'].';width:32px;height:32px;border:solid 1px #999;">&nbsp;</div>';
      
      $link=$prodId.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['titulo'])))).'-.html';

      $precio=($row_CONSULTA0['precio']*$aumementoPrecio*(100-$row_CONSULTA1['descuento'])/100);

      $importe=$precio*$key['Cantidad'];
      $subtotal+=$importe;

      $cantidad=$key['Cantidad'];
      $existenciasFinales=$row_CONSULTA0['existencias']-$cantidad;
      $actualizar = $CONEXION->query("UPDATE productosexistencias SET existencias = '$existenciasFinales' WHERE id = $itemId");

      $productotxt=$row_CONSULTA1['sku'].' | '.$row_CONSULTA1['titulo'].' | '.$talla.' | '.$colorName;

      $sql = "INSERT INTO pedidosdetalle (pedido,producto,item,productotxt,cantidad,precio,importe)".
        "VALUES ('$pedidoId','$prodId','$itemId','$productotxt','$cantidad','$precio','$importe')";
      $insertar = $CONEXION->query($sql);

      $count++;

      $queryString .= '&item_number_' . $count . '=' . urlencode($prodId);
      $queryString .= '&item_name_' . $count . '=' . urlencode($productotxt);
      $queryString .= '&amount_' . $count . '=' . urlencode($precio*(1+$taxIVA));
      $queryString .= '&quantity_' . $count . '=' . urlencode($cantidad);
      $queryString .= '&shipping_' . $count . '='.((($cantidad*$shipping)+$envioGlobal)*(1+$taxIVA));

      $envioGlobal=0;// Para que solo se cobre una vez

      $num++; 
      if ($num==2) {
        $num=0; 
      }

      $tabla.='
        <tr '.$style[$num].'>
          <td style="padding: 8px;">
            '.$producto.'
          </td>
          <td style="padding: 8px;">
            '.$talla.'
          </td>
          <td style="padding: 8px;">
            '.$colorName.'
          </td>
          <td style="padding: 8px; text-align: center;">
            '.$key['Cantidad'].'
          </td>
          <td style="padding: 8px; text-align: right;">
            '.number_format(($row_CONSULTA0['precio']*$aumementoPrecio),2).'
          </td>
          <td style="padding: 8px; text-align: right;">
            '.number_format($precio,2).'
          </td>
          <td style="padding: 8px; text-align: right;">
            '.number_format($importe,2).'
          </td>
        </tr>'; 
    }
  }

  $envio=$shipping*$carroTotalProds;
  $subtotal=$subtotal+$envio+$shippingGlobal;
  $iva=($taxIVA>0)?$subtotal*$taxIVA:0;
  $total=$subtotal+$iva;

  if ($total>0) {
    if ($shippingGlobal>0) {
      $tabla.='
      <tr '.$style[$num].'>
        <td style="padding: 8px; text-align: left; " colspan="3">
          Envío global
        </td>
        <td style="padding: 8px; text-align: center; ">
          1
        </td>
        <td style="padding: 8px; text-align: right; " colspan="2">
          '.number_format($shippingGlobal,2).'
        </td>
        <td style="padding: 8px; text-align: right; ">
          '.number_format($shippingGlobal,2).'
        </td>
      </tr>';
      $num=($num==0)?1:0;
    }
    if ($shipping>0) {
      $tabla.='
      <tr '.$style[$num].'>
        <td style="padding: 8px; text-align: left;" colspan="3">
          Envío por pieza
        </td>
        <td style="padding: 8px; text-align: center;">
          '.$carroTotalProds.'
        </td>
        <td style="padding: 8px; text-align: right;" colspan="2">
          '.number_format($shipping,2).'
        </td>
        <td style="padding: 8px; text-align: right;">
          '.number_format($envio,2).'
        </td>
      </tr>';
    }

    $tabla.=($taxIVA>0)?'
      <tr '.$style[$num].'>
        <td colspan="6" style="padding: 8px;text-align:right;">
          Subtotal
        </td>
        <td style="padding: 8px;text-align:right;">
          '.number_format($subtotal,2).'
        </td>
      </tr>
      <tr '.$style[$num].'>
        <td colspan="6" style="padding: 8px;text-align:right;">
          IVA
        </td>
        <td style="padding: 8px;text-align:right;">
          '.number_format($iva,2).'
        </td>
      </tr>':'';

    $tabla.='
      <tr '.$style[$num].'>
        <td colspan="6" style="padding: 8px;text-align:right;">
          Total
        </td>
        <td style="padding: 8px;text-align:right;">
          '.number_format($total,2).'
        </td>
      </tr>
      ';
  }

  $tabla.='
    </table>';

  $actualizar = $CONEXION->query("UPDATE pedidos SET 
    idmd5 = '$idmd5',
    tabla = '$tabla',
    importe = '$total',
    cantidad = '$carroTotalProds'
    WHERE id = $pedidoId");

  unset($_SESSION['carro']);


  $CONSULTA = $CONEXION -> query("SELECT * FROM usuarios WHERE id = '$uid'");
  $numUser=$CONSULTA->num_rows;
  if ($numUser>0) {
    $row_CONSULTA = $CONSULTA -> fetch_assoc();

    // Almacenar domicilio de entrega
      $domNum=(isset($_SESSION['domicilio2']) AND $_SESSION['domicilio2']==1)?2:'';

      $nombre = $row_CONSULTA['nombre'];
      $email = $row_CONSULTA['email'];
      $calle = $row_CONSULTA['calle'.$domNum];
      $noexterior = $row_CONSULTA['noexterior'.$domNum];
      $nointerior = $row_CONSULTA['nointerior'.$domNum];
      $entrecalles = $row_CONSULTA['entrecalles'.$domNum];
      $pais = $row_CONSULTA['pais'.$domNum];
      $estado = $row_CONSULTA['estado'.$domNum];
      $municipio = $row_CONSULTA['municipio'.$domNum];
      $colonia = $row_CONSULTA['colonia'.$domNum];
      $cp = $row_CONSULTA['cp'.$domNum];

      $actualizar = $CONEXION->query("UPDATE pedidos SET
        nombre = '$nombre',
        email = '$email',
        calle = '$calle',
        noexterior = '$noexterior',
        nointerior = '$nointerior',
        entrecalles = '$entrecalles',
        pais = '$pais',
        estado = '$estado',
        municipio = '$municipio',
        colonia = '$colonia',
        cp = '$cp'
        WHERE id = $pedidoId");

      unset($_SESSION['domicilio2']);

    // Envío de correos    
      $nombre=$row_CONSULTA['nombre'];
      $email =$row_CONSULTA['email'];
      $send2user=1;
      $colorPrimary='#333';
      $asuntoCorreo='Orden #'.$pedidoId.' en '.$Brand;
      $cuerpoCorreo='
        <div style="width:700px;">
          <div style="width:100%;padding-top:20px;color:'.$colorPrimary.';font-size:22px;">
            <b>Gracias por su compra</b>
          </div>
          <div style="width:100%;padding-top:20px;color:'.$colorPrimary.';font-size:17px;">
            A continuaci&oacute;n el resumen de su compra:
          </div>
          <div style="width:100%;padding-top:30px;">
            <a href="'.$ruta.$idmd5.'_revisar.pdf" style="background-color:'.$mailButton.';color:white;text-decoration:none;border-radius:8px;padding:13px;font-weight:700;">Versi&oacute;n PDF</a>
          </div>
          <div style="width:100%;padding-top:30px;">
            '.$tabla.'
          </div>
          <div style="width:100%;text-align:center;padding-top:50px;padding-bottom:50px;font-size:16px;">
            <a style="color:'.$colorPrimary.';text-decoration:none;" href="mailto:'.$destinatario1.'">'.$destinatario1.'</a><br><br>
            <a style="color:'.$colorPrimary.';text-decoration:none;" href="'.$ruta.'">www.'.$dominio.'</a>
          </div>
        </div>';
      include 'includes/sendmail.php';
  }

  if (isset($_GET['deposito'])) {
      header('Location: ' .$idmd5.'_detalle');
  }else{
  	//echo 'https://www.paypal.com/cgi-bin/webscr'.$queryString;
    header('Location: https://www.'.$sandbox.'paypal.com/cgi-bin/webscr' .$queryString);
	}

}