<?php

    $domicilio2=(isset($_SESSION['domicilio2']))?$_SESSION['domicilio2']:0;
    $domicilio2Icon =(isset($_SESSION['domicilio2']) AND $_SESSION['domicilio2']==1)?'fas fa-check color-verde':'far fa-square uk-text-muted';
    $domicilio2Class=(isset($_SESSION['domicilio2']) AND $_SESSION['domicilio2']==1)?'':'uk-hidden';

    $requiereFactura=(isset($_SESSION['requierefactura']))?$_SESSION['requierefactura']:0;
    $requiereFacturaIcon=(isset($_SESSION['requierefactura']) AND $_SESSION['requierefactura']==1)?'fas fa-check color-verde':'far fa-square uk-text-muted';

    $rfccorrecto=($_SESSION['requierefactura']==1 AND strlen($row_USER['rfc']) < 5)?'uk-hidden':'';

    $desccc = $_SESSION['descuento'];

    if ( $languaje == 'es') {

        $titleText ="Productos y cantidades";
        $titulo = "Revise que todos los datos sean correctos";
        $titulo2 ="Datos de cliente";
        $btnText ="Editar datos personales";
        $btnTextF ="Editar domicilio fiscal";
        $textdomi ="Enviar a otro domicilio";
        $titleText ="Productos y cantidades";
        $tableText0 = "Productos  ";
        $tableText1 = "Talla";
        $tableText2 = "Color";
        $tableText3 = "Cantidad";
        $tableText4 = "Precio de lista";
        $tableText5 = "Precio final";
        $tableText6 = "importe";
        $inputText1 = "nombre";
        $inputText2 = "Email";
        $inputText3 = "Telefono";
        $inputText4 = "empresa";
        $inputText5 = "rfc";
        $btnText1 = "Depósito o transferencia";
        $btnText2 = "Paga con paypal";
        $pText = "Personales";
        $pDomicilio ="Domicilio de entrega";
        $editarFiscalesT = "Editar datos";
        $envioText="Datos de envío";

        $domicilioEntrega= "Domicilio de entrega";
        $calle          = 'calle';
        $noExterior     = 'Numero exterior';
        $noInterior     = 'Numero interior';
        $pais           = 'Pais';
        $estado         = 'Estado';
        $municipio      = 'Municipio';
        $colonia        = 'Colonia';
        $cp             = 'CP';
        $terminar       = "Terminar";

    }elseif ($languaje == 'en') {

        $titleText ="Products and quantities";
        $titulo ="Check that all you information is correct";
        $titulo2="Client information";
        $btnText="Edit";
        $btnTextF ="Fiscal data";
        $textdomi ="Send to another address";
        $titleText ="Products and quantities";
        $tableText0 = "Product";
        $tableText1 = "Size";
        $tableText2 = "Color";
        $tableText3 = "Quantity";
        $tableText4 = "List price";
        $tableText5 = "Final price";
        $tableText6 = "Amount";
        $inputText1 = "name";
        $inputText2 = "Email";
        $inputText3 = "Phone";
        $inputText4 = "company";
        $inputText5 = "rfc";
        $btnText1 = "Deposit or bank transfer";
        $btnText2 = "pay with paypal";
        $pText = "Personal";
        $pDomicilio ="Shipping address";
        $editarFiscalesT = "Edit data";
  
        $envioText="Shipping data";

        $domicilioEntrega= "Shipping address";
        $calle          = 'Street';
        $noExterior     = 'Number';
        $noInterior     = 'Interior number';
        $pais           = 'Contry';
        $estado         = 'State';
        $municipio      = 'City';
        $colonia        = 'Suburb';
        $cp             = 'CP';
        $terminar       = "Finish";
    }

?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

    <style type="text/css">
        #spinner{
            background: rgba(255,255,255,.8);
            position: fixed;
            top: -10000px;
            left: 0;
            width: 100%;
        }
    </style>

    <div class="uk-container <?=$rfccorrecto?> margin-top-50">
        <div class="uk-width-1-1">
            <div id="revisardatos">
                <div>
                    <p class="text-xl uk-text-center"><?= $titulo  ?> &nbsp; 
                </p>
            </div>

            <div class="uk-child-width-1-2@m" uk-grid>
                <div>
                    <div>
                        <h2><?=$pText?></h2>
                    </div>
                    <div>
                        <label for="nombre" class="uk-form-label uk-text-capitalize"><?= $inputText1 ?></label>
                        <input type="text" data-campo="nombre" id="nombre" value="<?=$row_USER['nombre']?>" class="uk-input uk-input-grey">
                    </div>
                    <div>
                        <label for="email" class="uk-form-label uk-text-capitalize"><?= $inputText2 ?></label>
                        <input type="text" data-campo="email" id="email" value="<?=$row_USER['email']?>" class="uk-input uk-input-grey">
                    </div>
                    <div>
                        <label for="telefono" class="uk-form-label uk-text-capitalize"><?= $inputText3 ?></label>
                        <input type="text" data-campo="telefono" id="telefono" value="<?=$row_USER['telefono']?>" class="uk-input uk-input-grey">
                    </div>
                    <div>
                        <label for="rfc" class="uk-form-label uk-text-uppercase"><?= $inputText5  ?></label>
                        <input type="text" data-campo="rfc" id="rfc" value="<?=$row_USER['rfc']?>" class="uk-input uk-input-grey uk-text-uppercase">
                    </div>
                </div>
                <div>
                    <div>
                        <h2><?=$envioText?></h2>
                    </div>
                    <div>
                        <label for="calle" class="uk-form-label uk-text-capitalize"><?= $calle  ?></label>
                        <input type="text" data-campo="calle" id="calle" value="<?=$row_USER['calle']?>" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="noexterior" class="uk-form-label uk-text-capitalize"><?= $noExterior ?></label>
                        <input type="text" data-campo="noexterior" id="noexterior" value="<?=$row_USER['noexterior']?>" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="nointerior" class="uk-form-label uk-text-capitalize"><?= $noInterior ?></label>
                        <input type="text" data-campo="nointerior" id="nointerior" value="<?=$row_USER['nointerior']?>" class="uk-input uk-input-grey">
                    </div>
                    <div>
                        <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
                        <input type="text" readonly value="México" id="pais" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="estado" class="uk-form-label uk-text-capitalize"><?=$estado  ?></label>
                        <input type="text" data-campo="estado" id="estado" value="<?=$row_USER['estado']?>" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="municipio" class="uk-form-label uk-text-capitalize"><?= $municipio ?></label>
                        <input type="text" data-campo="municipio" id="municipio" value="<?=$row_USER['municipio']?>" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="colonia" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
                        <input type="text" data-campo="colonia" id="colonia" value="<?=$row_USER['colonia']?>" class="uk-input uk-input-grey" >
                    </div>
                    <div>
                        <label for="cp" class="uk-form-label uk-text-uppercase"><?= $cp ?></label>
                        <input type="text" data-campo="cp" id="cp" value="<?=$row_USER['cp']?>" class="uk-input uk-input-grey" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-width-1-1 uk-flex uk-flex-center margin-top-50">
        <div class="uk-panel uk-panel-box">
            <h3 class="uk-text-center"><i class="uk-icon uk-icon-small uk-icon-check-square-o"></i> &nbsp;<?=$titleText?></h3>
            <table class="uk-table uk-table-striped uk-table-hover uk-table-middle" id="tabla">
                <thead>
                    <tr>
                        <th ><?=$tableText0?></th>
                        <th width="100px"><?=$tableText1?></th>
                        <th width="100px"><?=$tableText2?></th>
                        <th width="100px"><?=$tableText3?></th>
                        <th width="100px" class="uk-text-right"><?=$tableText4?></th>
                        <th width="100px" class="uk-text-right"><?=$tableText5?></th>
                        <th width="100px" class="uk-text-right"><?=$tableText6?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $subtotal=0;
                        $num=0;
                        
                        if(isset($_SESSION['carro'])) {
                            foreach ($arreglo as $key) {
                                $itemId=$key['Id'];
                                $CONSULTA0 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $itemId");
                                $row_CONSULTA0 = $CONSULTA0 -> fetch_assoc();
                                $prodId=$row_CONSULTA0['producto'];
                                $tallaId=$row_CONSULTA0['talla'];
                                $colorId=$row_CONSULTA0['color'];
                                $precio=$row_CONSULTA0['precio'];
                                $CONSULTA1 = $CONEXION -> query("SELECT * FROM productos WHERE id = $prodId");
                                $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
                                $producto=$row_CONSULTA1['sku'].' - '.$row_CONSULTA1['titulo'];

                                $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaId");
                                $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
                                $talla=$row_CONSULTA2['txt'];

                                $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorId");
                                $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
                                $imagen   = 'img/contenido/productoscolor/'.$row_CONSULTA3['imagen'];
                                $color=(strlen($row_CONSULTA3['imagen'])>0)?'<img src="'.$imagen.'" class="uk-border-circle" style="width:35px;height:35px;">':'<div class="uk-border-circle" style="background:'.$row_CONSULTA3['txt'].';width:32px;height:32px;border:solid 1px #999;">&nbsp;</div>';
                                $colorName=$row_CONSULTA3['name'];

                                $link=$prodId.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['titulo'])))).'-.html';

                                // $importe=($precio*$aumementoPrecio*(100-$row_CONSULTA1['descuento'])/100)*$key['Cantidad']*$aumementoPrecio;
                                $importe=($precio*$aumementoPrecio*(100-$desccc)/100)*$key['Cantidad']*$aumementoPrecio;
                                $subtotal+=$importe;

                                echo '
                                    <tr>
                                        <td>
                                            <a href="'.$link.'" target="_blank">'.$producto.'</a>
                                        </td>
                                        <td>
                                            '.$talla.'
                                        </td>
                                        <td>
                                            '.$colorName.'
                                        </td>
                                        <td class="uk-text-right">
                                            '.$key['Cantidad'].'
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format(($precio*$aumementoPrecio),2).'
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format(($precio*$aumementoPrecio*(100-$desccc)/100),2).'
                                        </td>
                                        <td class="uk-text-right">
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
          
                        echo '<input type="hidden" name="precio_total" id="precio_total" value="'.$total.'"/>';

                        if ($total>0) {
                            if ($shippingGlobal>0) {
                                echo '
                                    <tr>
                                        <td style="text-align: left;" colspan="4">
                                            Envío global
                                        </td>
                                        <td style="text-align: right; ">
                                            1
                                        </td>
                                        <td style="text-align: right; ">
                                            '.number_format($shippingGlobal,2).'
                                        </td>
                                        <td style="text-align: right; ">
                                            '.number_format($shippingGlobal,2).'
                                        </td>
                                    </tr>';
                            }

                            if ($shipping>0) {
                                echo '
                                    <tr>
                                        <td style="text-align: left; " colspan="4">
                                            Envío por pieza
                                        </td>
                                        <td style="text-align: right; ">
                                            '.$carroTotalProds.'
                                        </td>
                                        <td style="text-align: right; ">
                                            '.number_format($shipping,2).'
                                        </td>
                                        <td style="text-align: right; ">
                                            '.number_format($envio,2).'
                                        </td>
                                    </tr>';
                            }

                            if($taxIVA>0){
                                echo '
                                    <tr>
                                        <td colspan="6" class="uk-text-right">
                                            Subtotal
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format($subtotal,2).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="uk-text-right">
                                            IVA
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format($iva,2).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="uk-text-right">
                                            Total
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format($total,2).'
                                        </td>
                                    </tr>
                                ';
                            } else {
                                echo '
                                    <tr>
                                        <td colspan="6" class="uk-text-right">
                                            Total
                                        </td>
                                        <td class="uk-text-right">
                                            '.number_format($subtotal,2).'
                                        </td>
                                    </tr>';
                            }
                        }
                        
                        echo '
                </tbody>
            </table>
        </div>
    </div>
    <div class="uk-width-1-1 uk-text-center padding-v-50">
        <div uk-grid class="uk-child-width-1-1@m">
            <div class="uk-text-center@m uk-text-center">
                <button data-enlace="procesar-deposito" class="siguiente uk-button uk-button-personal uk-hidden">Proceder al pago</button>
                <button onclick="agregarProductoFinal()" class="siguientefalso uk-button uk-button-personal">Proceder al pago</button>
            </div>
        </div>
    </div>';
?>

</div>

<?=$footer?>
<?=$scriptGNRL?>

<script>

    function agregarProductoFinal() {
        $nombre         = document.getElementById("nombre").value;
        $email          = document.getElementById("email").value;
        $telefono       = document.getElementById("telefono").value;
        $rfc            = document.getElementById("rfc").value;
        $calle          = document.getElementById("calle").value;
        $numeroE        = document.getElementById("numeroE").value;
        $numeroI        = document.getElementById("numeroI").value;
        $pais           = document.getElementById("pais").value;
        $estado         = document.getElementById("estado").value;
        $municipio      = document.getElementById("municipio").value;
        $colonia        = document.getElementById("colonia").value;
        $cp             = document.getElementById("cp").value;
        $precio_final   = document.getElementById("precio_total").value;

        var UrlAjax = "../pages-cart/pago.php";
		$.ajax({
    		url : UrlAjax,
	    	type : "POST",
		    dataType : "html",
	    	data : {
                nombre:         nombre, 
                email:          email, 
                telefono:       telefono, 
                rfc:            rfc,
                calle:          calle,
                numeroE:        numeroE,
                numeroI:        numeroI,
                pais:           pais,
                estado:         estado,
                municipio:      municipio,
                colonia:        colonia,
                cp:             cp,
                precio_final:   precio_final
            }
	    })
        .done(function(resultado){
            if(resultado == 1){
            toastr["success"]("Cupón agregado exitosamente", "Nuevo cupón");
            setTimeout(function () { location.reload(); }, 2500);
            }else{
                toastr["error"]("Error, no se pudo crear el cupon ", "Fallo");
            }
        })
    }


  $('.siguiente').click(function(){
    var datos = $(this).data();
      $('#spinner').css('top','0');
      UIkit.scroll(this).scrollTo('#tabla');
      window.location = (datos.enlace);
  });

  <?php  
    if ($_SESSION['requierefactura']==1 AND strlen($row_USER['rfc']) < 5) {
      echo 'UIkit.modal("#rfcmodal").show();

          UIkit.util.on("#rfcmodal", "hide", function () {
            location.reload();
          }); ';

    }
  ?>

  $(".editarinfopersonalinput").focusout(function() {
    var campo = $(this).attr("data-campo");
    var valor = $(this).val();
    $.ajax({
      method: "POST",
      url: "../includes/acciones.php",
      data: { 
        editacliente: 1,
        campo: campo,
        valor: valor
      }
    })
    .done(function( response ) {
      console.log( response )
      datos = JSON.parse(response);
      UIkit.notification.closeAll();
      if (datos.estatus==0) {
        UIkit.notification(datos.msj);
      }
    });
  });

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


  UIkit.util.on('#editarinfopersonalmodal', 'hidden', function () {
    location.reload();
  });
  UIkit.util.on('#domicilioentregamodal', 'hidden', function () {
    location.reload();
  });

   <?php  
    if (strlen($row_USER['calle']) > 0 && strlen($row_USER['noexterior']) > 0  && strlen($row_USER['pais']) > 0  && strlen($row_USER['estado']) > 0 && strlen($row_USER['municipio']) > 0  && strlen($row_USER['cp']) > 4 && $domicilio2 == 0) {
      echo '
          $(".siguiente").removeClass("uk-hidden");
          $(".siguientefalso").addClass("uk-hidden");';
    }
    if($domicilio2 == 1){
      if (strlen($row_USER['calle2']) > 0 && strlen($row_USER['noexterior2']) > 0  && strlen($row_USER['pais2']) > 0  && strlen($row_USER['estado2']) > 0 && strlen($row_USER['municipio2']) > 0  && strlen($row_USER['cp2']) > 4 ) {
      echo '
          $(".siguiente").removeClass("uk-hidden");
          $(".siguientefalso").addClass("uk-hidden");';
      }
    }
  ?>


  $(".siguientefalso").click(function(){
      UIkit.notification.closeAll();
      UIkit.notification("<div class=\' color-blanco\' style=\'border-radius:20px;background:#7c573a\'>Completa tus datos de envío</div>");
  });

  $('#domicilioentregabutton').click(function(){
    var domicilio2 = $(this).attr("data-domicilio2");
    if (domicilio2==0) {
      domicilio2 = 1;
      $(this).removeClass("fa-square");
      $(this).removeClass("far");
      $(this).removeClass("uk-text-muted");
      $(this).addClass("fa-check");
      $(this).addClass("fas");
      $(this).addClass("color-verde");
    }else{
      domicilio2 = 0;
      $(this).removeClass("fa-check");
      $(this).removeClass("fas");
      $(this).removeClass("color-verde");
      $(this).addClass("fa-square");
      $(this).addClass("far");
      $(this).addClass("uk-text-muted");
    }
    $(this).attr("data-domicilio2",domicilio2);
    $.ajax({
      method: "POST",
      url: "../includes/acciones.php",
      data: {
        domicilio2: domicilio2
      }
    })
    .done(function( response ) {
      console.log( response );
      datos = JSON.parse( response );
      if (datos.domicilio2==0) {
        location.reload();
      }
    });
  });

</script>

</body>
</html>