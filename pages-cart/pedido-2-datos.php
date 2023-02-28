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

}elseif ( $languaje == 'en') {
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
        <p class="text-xl"><?= $titulo  ?> &nbsp; 
          <!--a href="#editarinfopersonalmodal" uk-toggle class="uk-button uk-button-personal border-orange"><?=$btnText?></a--> 
        </p>
      </div>

      <div class="uk-child-width-1-3@m" uk-grid>
        <!--DATOS PERSONALES -->
        <div>
          <div>
            <h2><?=$pText ?></h2>
          </div>
          <div>
          <label for="nombre" class="uk-form-label uk-text-capitalize"><?= $inputText1 ?></label>
          <input type="text" data-campo="nombre" value="<?=$row_USER['nombre']?>" class="editarinfopersonalinput uk-input uk-input-grey">
          </div>
          <div>
            <label for="email" class="uk-form-label uk-text-capitalize"><?= $inputText2 ?></label>
            <input type="text" data-campo="email" value="<?=$row_USER['email']?>" class="editarinfopersonalinput uk-input uk-input-grey">
          </div>
          <div>
            <label for="telefono" class="uk-form-label uk-text-capitalize"><?= $inputText3 ?></label>
            <input type="text" data-campo="telefono" value="<?=$row_USER['telefono']?>" class="editarinfopersonalinput uk-input uk-input-grey">
          </div>
           <div>
                <label for="rfc" class="uk-form-label uk-text-uppercase"><?= $inputText5  ?></label>
                <input type="text" data-campo="rfc" value="<?=$row_USER['rfc']?>" class="editarinfopersonalinput uk-input uk-input-grey uk-text-uppercase">
              </div>
          <!--div>
            <label for="empresa" class="uk-form-label uk-text-capitalize"><?= $inputText4 ?></label>
            <input type="text" data-campo="empresa" value="<?=$row_USER['empresa']?>" class="editarinfopersonalinput uk-input uk-input-grey">
          </div-->
         
        </div>
        <div>
            <div>
              <h2><?=$envioText?></h2>
            </div>
            <div>
              <label for="calle" class="uk-form-label uk-text-capitalize"><?= $calle  ?></label>
              <input type="text" data-campo="calle" value="<?=$row_USER['calle']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
            <div>
              <label for="noexterior" class="uk-form-label uk-text-capitalize"><?= $noExterior ?></label>
              <input type="text" data-campo="noexterior" value="<?=$row_USER['noexterior']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
            <div>
              <label for="nointerior" class="uk-form-label uk-text-capitalize"><?= $noInterior ?></label>
              <input type="text" data-campo="nointerior" value="<?=$row_USER['nointerior']?>" class="editarinfopersonalinput uk-input uk-input-grey">
            </div>
            <div>
              <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
              <input type="text" readonly value="México" class="uk-input uk-input-grey" >
            </div>
            <div>
              <label for="estado" class="uk-form-label uk-text-capitalize"><?=$estado  ?></label>
              <input type="text" data-campo="estado" value="<?=$row_USER['estado']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
            <div>
              <label for="municipio" class="uk-form-label uk-text-capitalize"><?= $municipio ?></label>
              <input type="text" data-campo="municipio" value="<?=$row_USER['municipio']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
            <div>
              <label for="colonia" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
              <input type="text" data-campo="colonia" value="<?=$row_USER['colonia']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
            <div>
              <label for="cp" class="uk-form-label uk-text-uppercase"><?= $cp ?></label>
              <input type="text" data-campo="cp" value="<?=$row_USER['cp']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
            </div>
        </div>
        <div>
            <!--div>
              <h2>
              <a href="#domicilioentregamodal" uk-toggle id="domicilioentregabutton" class="'.$domicilio2Icon.' fa-2x pointer" data-domicilio2="'.$domicilio2.'"></a> &nbsp;&nbsp;Enviar a otro domicilio</a>
              </h2>
            </div-->
          <div class="uk-width-1-1 uk-flex ">
            <i id="factura" class="<?= $requiereFacturaIcon ?> fa-2x pointer" data-factura="<?=$requiereFactura ?>"></i> &nbsp;&nbsp;Necesito factura
          </div>
          <!--div class="'.$domicilio2Class.'">
            <div>
              <label class="uk-form-label uk-text-capitalize">calle:</label>
              '.$row_USER['calle2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">no. exterior:</label>
              '.$row_USER['noexterior2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">no. interior:</label>
              '.$row_USER['nointerior2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">pais:</label>
              '.$row_USER['pais2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">estado:</label>
              '.$row_USER['estado2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">municipio:</label>
              '.$row_USER['municipio2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-capitalize">colonia:</label>
              '.$row_USER['colonia2'].'
            </div>
            <div>
              <label class="uk-form-label uk-text-uppercase">cp:</label>
              '.$row_USER['cp2'].'
            </div>
          </div-->



          <!-- <?php if ($_SESSION['requierefactura']==1):?>
            <div>
               <div>
                <h2><?= $pDomicilio  ?></h2>
              </div>
              <div>
                <label for="rfc" class="uk-form-label uk-text-uppercase"><?= $inputText5  ?></label>
                <input type="text" data-campo="rfc" value="<?=$row_USER['rfc']?>" class="editarinfopersonalinput uk-input uk-input-grey uk-text-uppercase">
              </div>
              <div>
                <label for="callefiscal" class="uk-form-label uk-text-capitalize"><?= $calle  ?></label>
                <input type="text" data-campo="callefiscal" value="<?=$row_USER['callefiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
              <div>
                <label for="noexteriorfiscal" class="uk-form-label uk-text-capitalize"><?= $noExterior ?></label>
                <input type="text" data-campo="noexteriorfiscal" value="<?=$row_USER['noexteriorfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
              <div>
                <label for="nointeriorfiscal" class="uk-form-label uk-text-capitalize"><?= $noInterior ?></label>
                <input type="text" data-campo="nointeriorfiscal" value="<?=$row_USER['nointeriorfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey">
              </div>
              <div>
                <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
                <input type="text" readonly value="México" class="uk-input uk-input-grey" >
              </div>
              <div>
                <label for="estadofiscal" class="uk-form-label uk-text-capitalize"><?=$estado  ?></label>
                <input type="text" data-campo="estadofiscal" value="<?=$row_USER['estadofiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
              <div>
                <label for="municipiofiscal" class="uk-form-label uk-text-capitalize"><?= $municipio ?></label>
                <input type="text" data-campo="municipiofiscal" value="<?=$row_USER['municipiofiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
              <div>
                <label for="coloniafiscal" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
                <input type="text" data-campo="coloniafiscal" value="<?=$row_USER['coloniafiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
              <div>
                <label for="cpfiscal" class="uk-form-label uk-text-uppercase"><?= $cp ?></label>
                <input type="text" data-campo="cpfiscal" value="<?=$row_USER['cpfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
              </div>
            </div>
          <?php endif ?> -->


          
        </div>
      </div>
    </div>
  </div>
  <div class="uk-width-1-1 margin-top-50">
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
          if(isset($_SESSION['carro'])){
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
            }else{
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
    <div uk-grid class="uk-child-width-1-2@s">
      <div class="uk-text-right@m uk-text-center">
        <button data-enlace="procesar-deposito" class="siguiente uk-button uk-button-personal uk-hidden">'.$btnText1.'</button>
        <button  class="siguientefalso uk-button uk-button-personal ">'.$btnText1.'</button>
      </div>
      <div class="uk-text-left@m uk-text-center">
        <button data-enlace="procesar-pedido" class="siguiente uk-button uk-button-personal uk-hidden">'.$btnText2.'</button>
        <button  class="siguientefalso uk-button uk-button-personal ">'.$btnText2.'</button>
      </div>
    </div>
    <div uk-grid class="uk-child-width-1-2@s">
      <div class="uk-text-right@m uk-text-center">
        <img src="../img/design/pago-oxxo.jpg">
      </div>
      <div class="uk-text-left@m uk-text-center">
        <img src="../img/design/pago-paypal.jpg">
      </div>
    </div>
  </div>';
?>

</div>

<div class="padding-v-50">
</div>

<?=$footer?>

<div id="spinner" class="uk-flex uk-flex-middle uk-flex-center uk-height-viewport">
  <div>
    <div uk-spinner="ratio: 6"></div>
  </div>
</div>

<div id="editarinfopersonalmodal" uk-modal class="modal uk-modal-container" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <p class="text-xl"> <?= $editarFiscalesT  ?> </p>

    <div class="uk-child-width-1-2@m" uk-grid>
      <div>
        <div>
          <h2><?=  $pText  ?></h2>
        </div>
        <div>
          <label for="nombre" class="uk-form-label uk-text-capitalize"><?= $inputText1 ?></label>
          <input type="text" data-campo="nombre" value="<?=$row_USER['nombre']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="email" class="uk-form-label uk-text-capitalize"><?= $inputText2 ?></label>
          <input type="text" data-campo="email" value="<?=$row_USER['email']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="telefono" class="uk-form-label uk-text-capitalize"><?= $inputText3 ?></label>
          <input type="text" data-campo="telefono" value="<?=$row_USER['telefono']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="empresa" class="uk-form-label uk-text-capitalize"><?= $inputText4 ?></label>
          <input type="text" data-campo="empresa" value="<?=$row_USER['empresa']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="rfc" class="uk-form-label uk-text-uppercase"><?= $inputText5  ?></label>
          <input type="text" data-campo="rfc" value="<?=$row_USER['rfc']?>" class="editarinfopersonalinput uk-input uk-input-grey uk-text-uppercase">
        </div>
      </div>
      <div>
        <div>
          <h2><?= $pDomicilio  ?></h2>
        </div>
        <div>
          <label for="calle" class="uk-form-label uk-text-capitalize"><?= $calle  ?></label>
          <input type="text" data-campo="calle" value="<?=$row_USER['calle']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="noexterior" class="uk-form-label uk-text-capitalize"><?= $noExterior ?></label>
          <input type="text" data-campo="noexterior" value="<?=$row_USER['noexterior']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="nointerior" class="uk-form-label uk-text-capitalize"><?= $noInterior ?></label>
          <input type="text" data-campo="nointerior" value="<?=$row_USER['nointerior']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
          <input type="text" readonly value="México" class="uk-input uk-input-grey" >
        </div>
        <div>
          <label for="estado" class="uk-form-label uk-text-capitalize"><?=$estado  ?></label>
          <input type="text" data-campo="estado" value="<?=$row_USER['estado']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="municipio" class="uk-form-label uk-text-capitalize"><?= $municipio ?></label>
          <input type="text" data-campo="municipio" value="<?=$row_USER['municipio']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="colonia" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
          <input type="text" data-campo="colonia" value="<?=$row_USER['colonia']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="cp" class="uk-form-label uk-text-uppercase"><?= $cp ?></label>
          <input type="text" data-campo="cp" value="<?=$row_USER['cp']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
      </div>
    </div>
    <div class="uk-text-center uk-margin">
      <button class="uk-modal-close uk-button uk-button-default uk-button-large" type="button"><?= $terminar  ?></button>
    </div>
  </div>
</div>

<div id="editarfiscalmodal" uk-modal class="modal uk-modal-container" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <p class="text-xl"> <?= $editarFiscalesT  ?> </p>

    <div class="uk-child-width-1-1@m" uk-grid>
      <div>
        <div>
          <h2><?= $pDomicilio  ?></h2>
        </div>
        <div>
          <label for="callefiscal" class="uk-form-label uk-text-capitalize"><?= $calle  ?></label>
          <input type="text" data-campo="callefiscal" value="<?=$row_USER['callefiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="noexteriorfiscal" class="uk-form-label uk-text-capitalize"><?= $noExterior ?></label>
          <input type="text" data-campo="noexteriorfiscal" value="<?=$row_USER['noexteriorfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="nointeriorfiscal" class="uk-form-label uk-text-capitalize"><?= $noInterior ?></label>
          <input type="text" data-campo="nointeriorfiscal" value="<?=$row_USER['nointeriorfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey">
        </div>
        <div>
          <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
          <input type="text" readonly value="México" class="uk-input uk-input-grey" >
        </div>
        <div>
          <label for="estadofiscal" class="uk-form-label uk-text-capitalize"><?=$estado  ?></label>
          <input type="text" data-campo="estadofiscal" value="<?=$row_USER['estadofiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="municipiofiscal" class="uk-form-label uk-text-capitalize"><?= $municipio ?></label>
          <input type="text" data-campo="municipiofiscal" value="<?=$row_USER['municipiofiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="coloniafiscal" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
          <input type="text" data-campo="coloniafiscal" value="<?=$row_USER['coloniafiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
        <div>
          <label for="cpfiscal" class="uk-form-label uk-text-uppercase"><?= $cp ?></label>
          <input type="text" data-campo="cpfiscal" value="<?=$row_USER['cpfiscal']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
        </div>
      </div>
    </div>
    <div class="uk-text-center uk-margin">
      <button class="uk-modal-close uk-button uk-button-default uk-button-large" type="button"><?= $terminar  ?></button>
    </div>
  </div>
</div>
<div id="domicilioentregamodal" uk-modal class="modal uk-modal-container" uk-modal>
  <div class="uk-modal-dialog uk-modal-body">
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <p class="text-xl"><?= $domicilioEntrega ?></p>

    <div class="uk-child-width-1-3@m" uk-grid>
      <div>
        <label for="calle" class="uk-form-label uk-text-capitalize"><?= $domicilio  ?></label>
        <input type="text" data-campo="calle2" value="<?=$row_USER['calle2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="noexterior" class="uk-form-label uk-text-capitalize"><?= $noInterior  ?></label>
        <input type="text" data-campo="noexterior2" value="<?=$row_USER['noexterior2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="nointerior" class="uk-form-label uk-text-capitalize"><?= $noExterior  ?></label>
        <input type="text" data-campo="nointerior2" value="<?=$row_USER['nointerior2']?>" class="editarinfopersonalinput uk-input uk-input-grey">
      </div>
      <div>
        <label for="pais" class="uk-form-label uk-text-capitalize"><?= $pais  ?></label>
        <input type="text" readonly value="México" class="uk-input uk-input-grey" >
      </div>
      <div>
        <label for="estado" class="uk-form-label uk-text-capitalize"><?= $estado  ?></label>
        <input type="text" data-campo="estado2" value="<?=$row_USER['estado2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="municipio" class="uk-form-label uk-text-capitalize"><?= $municipio  ?></label>
        <input type="text" data-campo="municipio2" value="<?=$row_USER['municipio2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="colonia" class="uk-form-label uk-text-capitalize"><?= $colonia  ?></label>
        <input type="text" data-campo="colonia2" value="<?=$row_USER['colonia2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
      <div>
        <label for="cp" class="uk-form-label uk-text-uppercase"><?= $cp  ?></label>
        <input type="text" data-campo="cp2" value="<?=$row_USER['cp2']?>" class="editarinfopersonalinput uk-input uk-input-grey" >
      </div>
    </div>
    <div class="uk-text-center uk-margin">
      <button class="uk-modal-close uk-button uk-button-default uk-button-large" type="button"><?= $terminar  ?></button>
    </div>
  </div>
</div>
<div id="rfcmodal" class="uk-modal-full" uk-modal>
  <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle uk-height-viewport">
    <div>
      <div class="uk-text-center" style="padding-top:50px;">
        Proporciona RFC:
        <input type="text" class="uk-input editarinfopersonalinput" data-campo="rfc" data-valor="<?=$row_USER['rfc']?>" value="<?=$row_USER['rfc']?>">
        <div class="margin-top-20">
          <button class="uk-modal-close uk-button uk-button-large uk-button-personal uk-text-uppercase" type="button">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<?=$scriptGNRL?>

<script>

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