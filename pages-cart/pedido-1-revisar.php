<?php
$requiereFactura=(isset($_SESSION['requierefactura']))?$_SESSION['requierefactura']:0;
$requiereFacturaIcon=(isset($_SESSION['requierefactura']) AND $_SESSION['requierefactura']==1)?'fas fa-check color-verde':'far fa-square uk-text-muted';

$descuentoCupon=0;
$descuentoCuponTxt='';

if (isset($_SESSION['cupon'])) {
  $cupon=$_SESSION['cupon'];
  $CONSULTA= $CONEXION -> query("SELECT * FROM cupones WHERE codigo = '$cupon'");
  $numCupones=$CONSULTA->num_rows;
  if ($numCupones>0) {
    $rowCONSULTA = $CONSULTA -> fetch_assoc();
    $descuentoCupon=$rowCONSULTA['descuento'];
    $descuentoCuponTxt=$rowCONSULTA['txt'];
  }
  $cuponForm='';
  
}else{
  $cuponForm='
  <div class="uk-width-1-1 margin-v-20">
    <div uk-grid class="uk-grid-small uk-flex-center">
      <div>
        <div style="padding-top:8px;">
          ¿Tienes un cupón de descuento?
        </div>
      </div>
      <div>
        <input class="uk-input" id="cuponinput" placeholder="Ingresa tu cupón">
      </div>
      <div>
        <span class="uk-button uk-button-default" id="cuponavalidar">Validar cupón</span>
      </div>
    </div>
  </div>';
}


?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<div class="uk-container">
  <?php
 
  if ( $languaje == 'es') {
    $titleText ="Productos y cantidades";
    $tableText1 = "Talla";
    $tableText2 = "Color";
    $tableText3 = "Cantidad";
    $tableText4 = "Precio de lista";
    $tableText5 = "Precio final";
    $tableText6 = "importe";
    $btnText1 = "Seguir comprando";
    $btnText2 = "Vaciar carrito";
    $btnText3 = "Actualizar";
    $btnText4 = "Continuar";
    $instruccionestitle = "Instrucciones.";
    $instruccionestxt = $instrucciones;

  }elseif ( $languaje == 'en') {
    $titleText ="Products and quantities";
    $tableText1 = "Size";
    $tableText2 = "Color";
    $tableText3 = "Quantity";
    $tableText4 = "List price";
    $tableText5 = "Final price";
    $tableText6 = "Amount";
    $btnText1 = "keep buying";
    $btnText2 = "Empty cart ";
    $btnText3 = "Update";
    $btnText4 = "Continue";
    $instruccionestitle = "Instrucctions.";
    $instruccionestxt = $instruccionesEng;
  }
  
  //echo '<div class="padding-v-20 bg-dark color-blanco">'.$carroTotalProds.'</div>';
  if ($carroTotalProds>0) {
    echo '
    <form method="post">
      <input type="hidden" name="actualizarcarro" value="1">

      <div class="uk-width-1-1 margin-top-50">
        <div class="uk-panel uk-panel-box">
          <h3 class="uk-text-center"><i class="uk-icon uk-icon-small uk-icon-check-square-o"></i> &nbsp; '.$titleText.':</h3>

          <table class="uk-table uk-table-striped uk-table-hover uk-table-middle uk-table-responsive uk-text-center">
            <thead>
              <tr>
                <th width="50px"></th>
                <th >Producto</th>
                <th width="70px">'.$tableText1.'</th>
                <th width="70px">'.$tableText2.'</th>
                <th width="100px">'.$tableText3.'</th>
                <th width="100px" class="uk-text-right uk-visible@m">'.$tableText4.'</th>
                <th width="100px" class="uk-text-right uk-visible@m">'.$tableText5.'</th>
                <th width="100px" class="uk-text-right">'.$tableText6.'</th>
              </tr>
            </thead>
            <tbody>';

            $subtotal=0;
            $num=0;
            if(isset($_SESSION['carro'])){
              //unset($_SESSION['carro']);
             
              foreach ($arreglo as $key) {

                $itemId=$key['Id'];
                
                $CONSULTA0 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $itemId");
                $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
                //debug($row_CONSULTA0);
                $prodId=$row_CONSULTA0['producto'];
                $tallaId=$row_CONSULTA0['talla'];
                $colorId=$row_CONSULTA0['color'];
                $existencias=$row_CONSULTA0['existencias'];
                $precio = $row_CONSULTA0['precio'];
                
                $CONSULTA = $CONEXION -> query("SELECT * FROM productos WHERE id = $prodId");
                $rowCONSULTA = $CONSULTA -> fetch_assoc();
                $producto=$rowCONSULTA['sku'].' - '.$rowCONSULTA['titulo'];

                $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaId");
                $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
                $talla=$row_CONSULTA2['txt'];

                $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorId");
                $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();

                $imagen   = '../img/contenido/productoscolor/'.$row_CONSULTA3['imagen'];
                $color=(strlen($row_CONSULTA3['imagen'])>0)?'<img src="'.$imagen.'" class="uk-border-circle" style="width:35px;height:35px;">':'<div class="uk-border-circle" style="background:'.$row_CONSULTA3['txt'].';width:32px;height:32px;border:solid 1px #999;">&nbsp;</div>';
                $colorName=$row_CONSULTA3['name'];

                $link=$prodId.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($rowCONSULTA['titulo'])))).'-.html';

                $importe=($precio*$aumementoPrecio*(100-$rowCONSULTA['descuento'])/100)*$key['Cantidad']*$aumementoPrecio;
                $subtotal+=$importe;

                echo '
                <tr>
                  <td>
                    <span class="quitar uk-icon-button uk-button-danger" data-id="'.$itemId.'" uk-icon="icon:trash"></span><br>
                  </td>
                  <td class="uk-text-left@m">
                    <a href="#pics" uk-scroll>'.$producto.'</a>
                  </td>
                  <td>
                    '.$talla.'
                  </td>
                  <td>
                    '.$colorName.'
                  </td>
                  <td class="uk-text-right@m">
                    <input type="number" name="cantidad'.$num.'" value="'.$key['Cantidad'].'" min="1" max="'.$existencias.'" data-inventario="'.$existencias.'" class="cantidad uk-input uk-form-width-small uk-text-right" tabindex="10">
                  </td>
                  <td class="uk-text-right@m uk-visible@m">
                    '.number_format(($precio*$aumementoPrecio),2).'
                  </td>
                  <td class="uk-text-right@m uk-visible@m">
                    '.number_format(($precio*$aumementoPrecio*(100-$rowCONSULTA['descuento'])/100),2).'
                  </td>
                  <td class="uk-text-right@m">
                    '.number_format($importe,2).'
                  </td>
                </tr>';

                $num++;
              }
            }

            $envio=$shipping*$carroTotalProds;
            $subtotal=$subtotal+$envio+$shippingGlobal;
            $iva=($taxIVA>0)?$subtotal*$taxIVA:0;
            $total=$subtotal+$iva;

            if ($total>0) {
              if ($shippingGlobal>0) {
                echo '
                <tr>
                  <td>
                  </td>
                  <td class="uk-text-left@m" colspan="4">
                    Envío global
                  </td>
                  <td class="uk-text-right@m">
                    1
                  </td>
                  <td class="uk-text-right@m uk-visible@m">
                    '.number_format($shippingGlobal,2).'
                  </td>
                  <td class="uk-text-right@m">
                    '.number_format($shippingGlobal,2).'
                  </td>
                </tr>';
              }
              if ($shipping>0) {
                echo '
                <tr>
                  <td>
                  </td>
                  <td class="uk-text-left@m" colspan="4">
                    Envío por pieza
                  </td>
                  <td class="uk-text-right@m">
                    '.$carroTotalProds.'
                  </td>
                  <td class="uk-text-right@m uk-visible@m">
                    '.number_format($shipping,2).'
                  </td>
                  <td class="uk-text-right@m">
                    '.number_format($envio,2).'
                  </td>
                </tr>';
              }

              if($taxIVA>0){
                echo '
                <tr>
                  <td colspan="7" class="uk-text-right">
                    Subtotal
                  </td>
                  <td class="uk-text-right">
                    '.number_format($subtotal,2).'
                  </td>
                </tr>
                <tr>
                  <td colspan="7" class="uk-text-right">
                    IVA
                  </td>
                  <td class="uk-text-right">
                    '.number_format($iva,2).'
                  </td>
                </tr>
                <tr>
                  <td colspan="7" class="uk-text-right">
                    Total
                  </td>
                  <td class="uk-text-right">
                    '.number_format($total,2).'
                  </td>
                </tr>
                ';
              }else{
                echo '
                <tr>
                  <td colspan="7" class="uk-text-right@m">
                    Total
                  </td>
                  <td class="uk-text-right@m">
                    '.number_format($subtotal,2).'
                  </td>
                </tr>';
              }
            }
      echo '
            </tbody>
          </table>
           <!--div class="uk-width-1-1 uk-flex uk-flex-right padding-top-20">
            <i id="factura" class="'.$requiereFacturaIcon.' fa-2x pointer" data-factura="'.$requiereFactura.'"></i> &nbsp;&nbsp;Necesito factura
          </div-->

        </div>
      </div>
      
      <div class="uk-width-1-1 uk-text-center margen-v-50">
        <div uk-grid class="uk-flex-center">
          <div class="uk-width-1-1 margin-v-20">
            <div uk-grid class="uk-grid-small uk-flex-center">
              <div>
                <div style="padding-top:8px;">
                  ¿Tienes un cupón de descuento?
                </div>
              </div>
              <div>
                <input class="uk-input" id="cuponinput" placeholder="Ingresa tu cupón">
              </div>
              <div>
                <span class="uk-button uk-button-default" id="cuponavalidar">Validar cupón</span>
              </div>
            </div>
          </div>
        </div>
        <div uk-grid class="uk-flex-center">
          <div>
            <a href="productos" class="uk-button uk-button-large uk-button-default"><i uk-icon="icon:arrow-left;ratio:1.5;"></i> &nbsp; '.$btnText1.'</a>
          </div>
          <div>
            <span class="emptycart uk-button uk-button-large uk-button-default"><i uk-icon="icon:trash"></i> &nbsp; '.$btnText2.'</span>
          </div>
          <div>
            <button class="uk-button uk-button-personal uk-button-large uk-hidden" id="actualizar">'.$btnText3.' &nbsp; <i uk-icon="icon:refresh;ratio:1.5;"></i></button>
            <a href="Revisar_datos_personales" class="uk-button uk-button-large uk-button-personal" id="siguiente">'.$btnText4.' &nbsp; <i uk-icon="icon:arrow-right;ratio:1.5;"></i></a>
          </div>
        </div>
      </div>
    </form>

    <div uk-grid id="pics">
      <div class="uk-text-center margin-v-50 uk-width-1-1@m">
        <h3 class="uk-card-title">'.$instruccionestitle.'</h3>
        <p class="uk-text-left">'.$instruccionestxt.'</p>
      </div>
    ';


    $prodArray[]=0;
    if(isset($_SESSION['carro'])){
      foreach ($arreglo as $key) {
        $itemId=$key['Id'];
        $CONSULTA0 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $itemId");
        $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
        $prodId=$row_CONSULTA0['producto'];
        $prodArray[$prodId]=1;
      }
    }

    foreach ($prodArray as $key => $value) {
      if ($key!=0) {
        $CONSULTA = $CONEXION -> query("SELECT * FROM productos WHERE id = $key");
        $rowCONSULTA = $CONSULTA -> fetch_assoc();
        
        $link=$key.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($rowCONSULTA['titulo'])))).'-.html';

        // Fotos
        $CONSULTA2 = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $key ORDER BY orden");
        $rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
        $pic='../img/contenido/productos/'.$rowCONSULTA2['id'].'.jpg';
        $picHtml=(file_exists($pic))?$pic:$noPic;

        echo '
        <div class="margin-v-50 uk-width-1-5@m">
            <div class="uk-card uk-card-hover uk-card-body uk-card-default">
              <div>
                <img class="uk-align-center" src="'.$pic.'" style="max-height:200px;margin-bottom:5px!important"> 
              </div>
              <div class="padding-0 uk-text-center">
                '.$rowCONSULTA['titulo'].'
              </div>
            </div>
        </div>
      
        ';
      }
    }
  echo '
  </div> <!-- grid -->';

  }else{
    echo '
  <div class="uk-width-1-1 uk-text-center margin-v-50">
    <div class="uk-alert uk-alert-danger text-xl">El carro está vacío</div>
  </div>';
  }
  ?>
</div> <!-- container -->


<div class="uk-width-1-1 uk-text-center margin-top-50">
  &nbsp;
</div>

<?=$footer?>

<?=$scriptGNRL?>

<script type="text/javascript">
   $('#factura').click(function(){
    var factura = $(this).attr("data-factura");
    if (factura==0) {
      factura = 1;
      $(this).removeClass("fa-square");
      $(this).removeClass("far");
      $(this).removeClass("uk-text-muted");
      $(this).addClass("fa-check");
      $(this).addClass("fas");
      $(this).addClass("color-verde");
    }else{
      factura = 0;
      $(this).removeClass("fa-check");
      $(this).removeClass("fas");
      $(this).removeClass("color-verde");
      $(this).addClass("fa-square");
      $(this).addClass("far");
      $(this).addClass("uk-text-muted");
    }
    $(this).attr("data-factura",factura);
    $.ajax({
      method: "POST",
      url: "../includes/acciones.php",
      data: {
        requierefactura: factura
      }
    })
    .done(function( response ) {
      console.log(response);
      datos = JSON.parse(response);
      location.reload();
    });
  });

  $(".quitar").click(function(){
    var id = $(this).data("id");
    $.ajax({
      method: "POST",
      url: "addtocart",
      data: { 
        id: id,
        cantidad: 0,
        removefromcart: 1
      }
    })
    .done(function() {
      location.reload();
    });
  })

  $(".emptycart").click(function(){
    console.log("vaciando...");
    $.ajax({
      method: "POST",
      url: "../emptycart",
      data: { 
        emptycart: 1
      }
    })
    .done(function() {
      location.reload();
    });
  })

  $(".cantidad").keyup(function() {
    var inventario = $(this).attr("data-inventario");
    var cantidad = $(this).val();
    inventario=1*inventario;
    cantidad=1*cantidad;
    if(inventario<=cantidad){
      $(this).val(inventario);
    }
    $("#actualizar").removeClass("uk-hidden");
    $("#siguiente").addClass("uk-hidden");
  })

  $(".cantidad").focusout(function() {
    var inventario = $(this).attr("data-inventario");
    var cantidad = $(this).val();
    console.log(cantidad);
    inventario=1*inventario;
    cantidad=1*cantidad;
    if(inventario<=cantidad){
      console.log(inventario*2+" - "+cantidad);
      $(this).val(inventario);
    }
    $("#actualizar").removeClass("uk-hidden");
    $("#siguiente").addClass("uk-hidden");
  })

  $("#cuponavalidar").click(function(){
    var cupon = $("#cuponinput").val();
    $.ajax({
      method: "POST",
      url: "includes/acciones.php",
      data: {
        cuponaplicar: cupon
      }
    })
    .done(function( response ) {
      console.log( response );
      datos = JSON.parse( response );
      UIkit.notification.closeAll();
      UIkit.notification(datos.msj);
      if(datos.estatus==0){
        setTimeout(function(){
          location.reload();
        },2000);
      }
    });
  });
</script>
</body>
</html>