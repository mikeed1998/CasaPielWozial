<?php
$pedido=$row_CONSULTA['id'];
$fechaSQL=$row_CONSULTA['fecha'];
$user=$row_CONSULTA['id'];
$pagarButton='';

if ( $languaje == 'es') {
    $title= "Datos de su pedido";
    $titleText ="Su pedido se encuentra en estado";
    $inputText1 = "nombre"; 
    $inputText2 = "rfc";
    $inputText3 = "Email";
    $personalText ="Datos personales";
    $bankText = "Datos para pago bancario";
    $adviseText1 = "Una vez que haya realizado su pago podrá notificarlo en el ";
    $adviseText2 = "panel de cliente.";
    $descargar = "Descarga tu ticket de pago";
    $instruccionestitle = "Instrucciones.";
    $instruccionestxt = $instrucciones;


  }elseif ( $languaje == 'en') {
    $titleText ="you order is in status";
    $title= "Order details";
    $inputText1 = "name"; 
    $inputText2 = "rfc";
    $inputText3 = "Email";
    $personalText ="Personal data";
    $bankText = "Data for bank payment";
    $adviseText1 = "Once you have made your payment you can notify it in the ";
    $adviseText2 = "client panel.";
    $descargar = "Download ticket";
    $instruccionestitle = "Instrucctions";
    $instruccionestxt = $instrucciones;
  }

$ConsultaDeposito= $CONEXION -> query("SELECT bank FROM configuracion WHERE id = 1");
$rowConsultaDeposito = $ConsultaDeposito-> fetch_assoc();

$estatus=$row_CONSULTA['estatus'];
switch ($estatus) {
  case 1:
    $estatusClase='primary';
    $estatusMensaje='pagado';
    break;
  case 2:
    $estatusClase='warning';
    $estatusMensaje='Enviado';
    if ($row_CONSULTA['guia']!='') {
      $estatusMensaje.='.<br>Número de guía: '.$row_CONSULTA['guia'];
    }
    break;
  case 3:
    $estatusClase='success';
    $estatusMensaje='Entregado';
    break;
  default:
    $pagarButton='
        <div class="uk-width-1-2@m uk-width-1-1">
          <div class="uk-card uk-card-default">
            <div class="uk-card-body">
              <div class="uk-width-1-1">
                <p>
                  <b>'.$bankText.'</b><br>
                  '.nl2br($rowConsultaDeposito['bank']).'
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-width-1-1 uk-text-center text-lg">
          '.$adviseText1.'<br>
          <a href="mi-cuenta" class="uk-button uk-button-personal">'.$adviseText2.'</a>
        </div>
        ';
    $estatusClase='warning';
    $estatusMensaje='registrado';
    break;
}

$dom=$row_CONSULTA['dom'];
switch ($dom) {
  case 0:
    $dom1='';
    $dom2='uk-hidden';
    $dom3='uk-hidden';
  case 1:
    $dom1='';
    $dom2='';
    $dom3='uk-hidden';
  case 2:
    $dom1='uk-hidden';
    $dom2='uk-hidden';
    $dom3='';

}
?>
<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>



<div class="uk-container">
  
  <div class="color-blanco bg-primary padding-20 text-lg">
    <?= $title ?>
  </div>

  <div uk-grid>
    <div class="uk-width-1-1 margin-top-20">
      <div class="uk-alert uk-alert-<?=$estatusClase?> uk-text-center" data-uk-alert>
        <a href="#" class="uk-alert-close uk-close"></a>
        <?= $titleText ?> <b><?=$estatusMensaje?></b>
      </div>
    </div>

    <div class="uk-width-1-1 margin-v-20">
      <div uk-grid class="uk-child-width-1-3@m">

      <?php
      echo '
        <div class="uk-width-1-2@m uk-width-1-1">
          <b class="uk-text-large">'.$personalText.'</b><br>
          <span class="uk-text-muted">'.$inputText1.':</span> <b>'.$row_USER['nombre'].'</b><br>
          <span class="uk-text-muted">'.$inputText2.':</span> <b>'.$row_USER['rfc'].'</b><br>
          <span class="uk-text-muted">'.$inputText3.':</span> <b>'.$row_USER['email'].'</b><br>
          <span class="uk-text-muted">Fecha de creación:</span> <b><br>'.fechaDisplay($fechaSQL).'</b><br><br>
          <div uk-grid class="uk-grid-small">
            <div class="uk-card uk-card-hover uk-card-body" style="padding:15px">
              <h3 class="negritas text-xl" style="color:#666">'.$instruccionestitle.'</h3>
              <p class="uk-text-left">'.$instruccionestxt.'</p>
           </div>
          </div>
          <div class="uk-width-1-1 margin-v-20">
            <a href="'.$idmd5.'_orden.pdf" class="uk-button uk-button-large uk-button-personal" target="_blank"><i class="far fa-2x fa-file-pdf"></i> &nbsp;'.$descargar.'</a>
          </div>
        </div>

        '.$pagarButton.'

        <div class="'.$dom1.'">
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Nombre:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['nombre'].'
          </div>
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Email:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['email'].'
          </div>
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Telefono:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['telefono'].'
          </div>
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Domicilio:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['calle'].',
            No. '.$row_USER['noexterior'].'
            &nbsp; '.$row_USER['nointerior'].'<br>
            '.$row_USER['colonia'].',
            CP: '.$row_USER['cp'].'<br>
            '.$row_USER['municipio'].',
            '.$row_USER['estado'].',
            '.$row_USER['pais'].'
          </div>
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Entrecalles:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['entrecalles'].'
          </div>
        </div>
        ';
    if ($dom==1) {
      $titulo='Dirección de entrega';
      echo'
        <div class="'.$dom2.'">
          <div class="uk-width-1-1 uk-text-large">
            '.$titulo.'
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['calle2'].',
            No. '.$row_USER['noexterior2'].'
            &nbsp; '.$row_USER['nointerior2'].'<br>
            '.$row_USER['colonia2'].',
            CP: '.$row_USER['cp2'].'<br>
            '.$row_USER['municipio2'].',
            '.$row_USER['estado2'].',
            '.$row_USER['pais2'].'
          </div>
          <div class="uk-width-1-1 uk-text-muted uk-text-small">
            Entrecalles:
          </div>
          <div class="uk-width-1-1">
            '.$row_USER['entrecalles2'].'
          </div>
        </div>
        ';
    }
    if ($dom==2) {
      $titulo='Recoge en tienda';
      echo'
        <div class="'.$dom3.'">
          <div class="uk-width-1-1 uk-text-large">
            <h2>'.$titulo.'</h2>
          </div>
        </div>
        ';
    }

    echo '    
      </div>
    </div>';
?>


    <div class="uk-width-1-1 margin-top-50">
        <?php
        $tabla = str_replace('<table', '<table class="uk-table uk-table-striped uk-table-hover uk-table-middle"', $row_CONSULTA['tabla']);
        echo str_replace('color: white;', 'color: white; background-color: #999;', $tabla);
        ?>
    </div>

    <div class="uk-width-1-1 uk-text-center margin-top-50">
    </div>
  </div> <!-- /grid -->
</div> <!-- /container -->

<div class="padding-v-50">
</div>

<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>