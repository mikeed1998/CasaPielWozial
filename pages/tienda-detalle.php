<?php
  $ConsultaCatalogo = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
  $rowConsultaCatalogo = $ConsultaCatalogo -> fetch_assoc();
  $file='img/contenido/varios/'.$rowConsultaCatalogo['imagen1'];
  if(strlen($rowConsultaCatalogo['imagen1'])>0 AND file_exists($file)){
    $catalogo='
      <div class="uk-width-expand uk-flex uk-flex-right">
        <div>
          <a href="'.$file.'" target="_blank" download="catalogo.pdf"><img src="img/design/button-catalogo.png"></a>
        </div>
      </div>';
  }else{
    $catalogo='';
  }


  $rutaImg='img/contenido/productos/';
  $precio='';
  if ($rowCONSULTA['precio']>0) {
    $precio = ($rowCONSULTA['descuento']>0)?'
    <del class="text-8 uk-text-light uk-text-muted">Precio: $'.number_format(($rowCONSULTA['precio']*$aumementoPrecio),2).'</del><br>
    <div class="uk-card uk-card-default text-dark uk-width-2-3@s uk-text-center" style="min-height: 35px; color:white; width: 250px;">
      Precio: <span class="text-lg">'.number_format(($rowCONSULTA['precio']*$aumementoPrecio*(100-$rowCONSULTA['descuento'])/100),2).'</span>
    </div>':'
    <div class="uk-card uk-card-default text-dark uk-width-2-3@s uk-text-center" style="height: 35px; color:white; min-width: 250px; max-width: 250px;">
      Precio: <span class="text-lg">'.number_format(($rowCONSULTA['precio']*$aumementoPrecio*(100-$rowCONSULTA['descuento'])/100),2).'</span>
    </div>';
  }

  $categoria='';
  $categoriaId=$rowCONSULTA['categoria'];
  $CONSULTA2 = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $categoriaId");
  $num = $CONSULTA2->num_rows;
  if ($num>0) {
    $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
    $parentId=$row_CONSULTA2['parent'];
    $link=$row_CONSULTA2['id'].'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA2['txt'])))).'_.php';
    $categoria='<li><a href="'.$link.'" class="color-primary uk-text-capitalize">'.strtolower($row_CONSULTA2['txt']).'</a></li>';
  }

  $parent='';
  $CONSULTA2 = $CONEXION -> query("SELECT * FROM productoscat WHERE id = $parentId");
  $num = $CONSULTA2->num_rows;
  if ($num>0) {
    $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
    $link=$parentId.'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA2['txt'])))).'-.php';
    $parent='<li><a href="'.$link.'" class="color-primary uk-text-capitalize">'.strtolower($row_CONSULTA2['txt']).'</a></li>';
  }

  $marca='';
  $marcaId=$rowCONSULTA['marca'];
  $CONSULTA2 = $CONEXION -> query("SELECT * FROM productosmarcas WHERE id = $marcaId");
  $num = $CONSULTA2->num_rows;
  if ($num>0) {
    $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
    $link=$row_CONSULTA2['id'].'_0_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA2['txt'])))).'_.html';
    $marca='<li><a href="'.$link.'" class="color-primary uk-text-capitalize">'.strtolower($row_CONSULTA2['txt']).'</a></li>';
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
  <meta property="og:image" content="<?=$ruta.$picOg?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>

<?=$header?>

<?php if ($numProds>0) { ?>

<div class="padding-v-100">
  <div class="uk-container">
    <div uk-grid>

      <div class="uk-width-auto@m">
        <ul class="uk-breadcrumb">
          <?=$parent?>
          <?=$categoria?>
          <?=$marca?>
        </ul>
      </div>

      <?=$catalogo?>
    </div>

    <div uk-grid>
      <div class="uk-width-1-2@m">
        <div class="uk-card uk-card-default">
          <?php 
          if (file_exists($picOg)) {
            $pic=$picOg;
          }else{
            $pic='img/design/camara.jpg';
          }
          echo '
          <div class="uk-text-center">
            <img id="pic" data-zoom-image="'.$pic.'" src="'.$pic.'">
          </div>';
          ?>
        </div><!-- END Card -->
        <div class="padding-v-50">
          <div uk-grid class="uk-grid-small uk-child-width-1-4 uk-flex-center">
          <?php
          $num=0;
          $consultafotos = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden");
          $numPics=$consultafotos->num_rows;
          if ($numPics>1) {
            while($rowConsultaFotos = $consultafotos -> fetch_assoc()){

              if (isset($arreglo)) {
                $arreglo .= ',"'.$rowConsultaFotos['id'].'"';
              }else{
                $arreglo = '"'.$rowConsultaFotos['id'].'"';
              }

              $pic=$rutaImg.$rowConsultaFotos['id'].'.jpg';    
              if (file_exists($pic)) {
                $lightboxA1=($es_movil===TRUE)?'<a href="'.$picLG.'">':'';
                $lightboxA2=($es_movil===TRUE)?'</a>':'';
                echo '
                <div>
                  '.$lightboxA1.'
                    <div class="pic uk-border-rounded pointer uk-flex uk-flex-center uk-flex-middle" style="height:120px;" data-id="'.$num.'" >
                      <img src="'.$pic.'" style="max-height:100%">
                    </div>
                  '.$lightboxA2.'
                </div>';
                $num++;
              }
            }
          }
          ?>

          </div><!-- End grid -->
        </div><!-- End padding-v-50 -->
      </div><!-- End uk-width-1-2 -->

      <div class="uk-width-1-2@m">
        <div class="padding-bottom-brown">
          <span class="uk-text-muted">Modelo:</span> <?=$rowCONSULTA['titulo']?><br>
          <span class="uk-text-muted">SKU:</span> <?=$rowCONSULTA['sku']?><br>
          <span class="uk-text-muted">Material:</span> <b><?=$rowCONSULTA['material']?></b>
        </div>

        <div class="padding-bottom-brown">
          <?=$rowCONSULTA['txt']?>
        </div>

<?php
  echo '
  <div uk-grid class="padding-top-20">
    <div class="uk-width-expand">
      <div class="uk-margin">
        Tallas disponibles <span id="swich">swich</span>
      </div>

      <div class="uk-margin">
        <select class="uk-select" id="seleccionartalla" style="max-width:200px;">';
  $num=0;
  $CONSULTA1 = $CONEXION -> query("SELECT DISTINCT talla FROM productosexistencias WHERE producto = $id AND existencias > 0");
  while ($rowCONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
    $tallaID=$rowCONSULTA1['talla'];
    $num++;
    
    $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaID");
    $numTallas = $CONSULTA2->num_rows;
    if ($numTallas>0) {
      $rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
      echo '
          <option value="'.$num.'">'.$rowCONSULTA2['txt'].'</option>';
    }
  }

  echo '</select>
      </div>

      <div class="uk-margin uk-hidden">
        <ul class="uk-subnav uk-subnav-pill uk-flex-left" uk-switcher="connect: #colores">';
  $CONSULTA1 = $CONEXION -> query("SELECT DISTINCT talla FROM productosexistencias WHERE producto = $id AND existencias > 0");
  while ($rowCONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
    $tallaID=$rowCONSULTA1['talla'];
    
    $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaID");
    $numTallas = $CONSULTA2->num_rows;
    if ($numTallas>0) {
      $rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
      echo '
          <li><a href="#">'.$rowCONSULTA2['txt'].'</a></li>';
    }
  }

  echo '
        </ul>
      </div>

      <div>
        <ul id="colores" class="uk-switcher uk-margin seleccionproducto">';
  $CONSULTA1 = $CONEXION -> query("SELECT DISTINCT talla FROM productosexistencias WHERE producto = $id AND existencias > 0");
  while ($rowCONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
    $tallaID=$rowCONSULTA1['talla'];
    $CONSULTA2 = $CONEXION -> query("SELECT * FROM productostalla WHERE id = $tallaID");
    $numTallas = $CONSULTA2->num_rows;
    if ($numTallas>0) {
      $rowCONSULTA2 = $CONSULTA2 -> fetch_assoc();
      $tallaName=$rowCONSULTA2['txt'];
      echo '
          <li>
            <div uk-grid>';
      $CONSULTA2 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE producto = $id AND talla = $tallaID AND existencias > 0");
      while($rowCONSULTA2 = $CONSULTA2 -> fetch_assoc()){

        $itemId=$rowCONSULTA2['id'];
        $colorID=$rowCONSULTA2['color'];
        $colorName=$rowCONSULTA2['name'];
        $existencias=$rowCONSULTA2['existencias'];

        if(!isset($selectedId)){
          $selectedId=$itemId;
          $max=$existencias;
          $selectedClass='colorseleccionado';
          $firstTalla=$tallaName;
        }else{
          $selectedClass='';
        }

        $CONSULTA3 = $CONEXION -> query("SELECT * FROM productoscolor WHERE id = $colorID");
        $numColors = $CONSULTA3->num_rows;
        if ($numColors>0) {
          $rowCONSULTA3 = $CONSULTA3 -> fetch_assoc();

          if(!isset($colorCanged)){
            $colorCanged=1;
            $firstColor=$rowCONSULTA3['name'];
          }

          $imagen   = 'img/contenido/productoscolor/'.$rowCONSULTA3['imagen'];
          $colorTxt = (strlen($rowCONSULTA3['imagen'])>0 AND file_exists($imagen))?'background:url('.$imagen.');background-size:cover;':'background:'.$rowCONSULTA3['txt'].';';

          echo '
              <div>
                <div id="'.$itemId.'" class="item uk-border-circle pointer '.$selectedClass.'" style="'.$colorTxt.'width:30px;height:30px;" data-inventario="'.$existencias.'" data-id="'.$itemId.'">
                  &nbsp;
                </div>
              </div>';
        }
      }
      echo '
            </div>
          </li>';
    }
  }
  echo '
        </ul>
      </div>';

  if ($rowCONSULTA['precio']>0) {
    echo $precio.'
      <div class="uk-margin text-8 padding-top-50" id="productoselectedtxt">
        Talla seleccionada: '.$firstTalla.'<br>
        Color seleccionado: '.$firstColor.'
      </div>
      <div class="uk-margin">
        <input class="cantidad" type="hidden" value="1">
        <button class="buybutton uk-button uk-text-nowrap uk-button-personal" data-id="'.$selectedId.'"><i class="fas fa-cart-plus fa-lg"></i> &nbsp; AGREGAR AL CARRO</button>
      </div>
      <div class="padding-top-20">
        <img src="img/design/metodos-pago.png">
      </div>
    </div>
  </div>
      ';
  }
?>


      </div><!-- End uk-width-1-2 -->
    </div><!-- End grid -->


    <div class="padding-top-50 uk-position-relative" id="otros-productos">
      <div class="padding-v-20 color-primary text-xl">
        OTROS PRODUCTOS DE LA MISMA CATEGORIA
      </div>
      <div uk-grid class="uk-child-width-1-4@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid-match " uk-scrollspy="cls: uk-animation-fade; target: > div; delay: 300; repeat: false" uk-height-match="target: > div > a > div > .itemtxt">
        
        <?php
        $CONSULTA2 = $CONEXION -> query("SELECT id FROM productos WHERE estatus = 1 AND categoria = $categoriaId AND id != $id LIMIT 4");
        while($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()){
          echo item($row_CONSULTA2['id'],'hidden');
        } 
        ?>

      </div><!-- End uk-width-1-2 -->
    </div><!-- End Otros Productos -->

  </div><!-- END container -->
</div><!-- END padding-v-100 -->

<?php
}else{
  echo '
  <div class="uk-container uk-text-center padding-v-100">
    <div class="uk-h1 color-rojo">
      Parece no haber nada aquí
    </div>
  </div>
  ';
}
?>

<?=$footer?>

<?=$scriptGNRL?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
if($es_movil!==TRUE){
  echo "<script src='library/elevatezoom/jquery.elevatezoom.js'></script>";
}
?>

<script type="text/javascript">
  $("#pic").elevateZoom({ 
    zoomType : "lens", 
    lensShape : "round", 
    lensSize : 130,
    scrollZoom: true,
    minZoomLevel: .4,
    maxZoomLevel: 1
  });

  $('.pic').click(function(){
    var arreglo = [<?=$arreglo?>];
    var id = $(this).attr('data-id');
    $('#actual').val(id);
    $( "#pic" ).addClass( "alpha0", 200 );
    setTimeout(function() {
      $('#pic').attr('src','<?=$rutaImg?>'+arreglo[id]+'.jpg');
      $('#pic').attr('data-zoom-image','<?=$rutaImg?>'+arreglo[id]+'.jpg');
      $('#pic').removeClass( "alpha0", 500 );
      var ez = $('#pic').data('elevateZoom');
      ez.swaptheimage('<?=$rutaImg?>'+arreglo[id]+'.jpg', '<?=$rutaImg?>'+arreglo[id]+'.jpg');
    }, 200 );
  });

  $('.item').click(function(){
    var datos = $(this).data();
    $('.buybutton').attr('data-id', datos.id);
    $('.cantidad').attr('max', datos.inventario);
    $('.item').removeClass('colorseleccionado');
    $(this).addClass('colorseleccionado');
    $.ajax({
      method: "POST",
      url: "includes/acciones.php",
      data: {
        tallaycolor: 1,
        datos
      }
    })
    .done(function( response ) {
      console.log(response);
      datos = JSON.parse(response);
      $('#productoselectedtxt').html(datos.xtras);
    });
  });
  
  // Agregar al carro
  $(".buybutton").click(function(){
    var id=$(this).attr("data-id");
    var cantidad=$(".cantidad").val();
    var l=id.length;
    //console.log( id + ' - ' + cantidad );
    if (l>0) {
      $.ajax({
        method: "POST",
        url: "addtocart",
        data: { 
          id: id,
          cantidad: cantidad,
          addtocart: 1
        }
      })
      .done(function( response ) {
        console.log( response );
        datos = JSON.parse(response);
        UIkit.notification.closeAll();
        UIkit.notification(datos.msj);
        $(".cartcount").html(datos.count);
        $("#cotizacion-fixed").removeClass("uk-hidden");
      });
    }
  });


  $("#seleccionartalla").change(function(){
    var valor = $(this).val();
    UIkit.switcher("#colores").show(valor);
  });
  
</script>
</body>
</html>

