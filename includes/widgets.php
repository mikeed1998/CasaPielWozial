<?php
// CARRO DE COMPRA 
   if ($languaje == 'es') {
      $addText = " Agregado al pedido";
        
    }elseif ($languaje == 'en') {
      $addText = " Add to order";

    }      
  //unset($_SESSION['carro']);
  if (isset($_POST['emptycart'])) {
    unset($_SESSION['carro']);
  }

  $carroTotalProds=0;
  // Si ya hay productos en la variable de sesión
  if(isset($_SESSION['carro'])){
    $arreglo=$_SESSION['carro'];
    foreach ($arreglo as $key => $value) {
      $carroTotalProds+=$value['Cantidad'];
    }
  }

  // Remover artículos del carro
  if (isset($_POST['removefromcart'])) {
    $id=$_POST['id'];
    $arregloAux=$_SESSION['carro'];
    unset($arreglo);
    $num=0;
    foreach ($arregloAux as $key => $value) {
      if ($id!=$value['Id']) {
        $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$arregloAux[$num]['Cantidad']);
      }
      $num++;
    }
    $_SESSION['carro']=$arreglo;
  }

  // Agregar artículos al carro
  if (isset($_POST['addtocart'])) {
    if (isset($_POST['cantidad']) and $_POST['cantidad']!==0 and $_POST['cantidad']!=='') {

      $id=$_POST['id'];

      $carroTotalProds+=$_POST['cantidad'];
      $arregloNuevo[]=array('Id'=>$id,'Cantidad'=>$_POST['cantidad']);

      if (!isset($arreglo)) {
        $arreglo=$arregloNuevo;
      }else{
        $arregloAux=$arreglo;
        unset($arreglo);
        $num=0;
        foreach ($arregloAux as $key => $value) {
          if ($id!=$arregloAux[$num]['Id']) {
            $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$arregloAux[$num]['Cantidad']);
          }else{
            $carroTotalProds-=$arregloAux[$num]['Cantidad'];
          }
          $num++;
        }
        if ($_POST['cantidad']>0) {
          $arreglo[]=array('Id'=>$id,'Cantidad'=>$_POST['cantidad']);
        }
      }
      
      echo '{ "msg":"<div class=\'uk-text-center color-blanco bg-success padding-10 text-lg\'><i class=\'fa fa-check\'></i> &nbsp; '.$addText.'</div>", "count":'.$carroTotalProds.' }';

      $_SESSION['carro']=$arreglo;
    }
  }

  if (isset($_POST['actualizarcarro'])) {
    $arregloAux=$_SESSION['carro'];
    unset($arreglo);
    $carroTotalProds=0;
    $num=0;
    foreach ($arregloAux as $key => $value) {
      $arreglo[]=array('Id'=>$arregloAux[$num]['Id'],'Cantidad'=>$_POST['cantidad'.$num]);
      $carroTotalProds+=$_POST['cantidad'.$num];
      $num++;
    }
    $_SESSION['carro']=$arreglo;
  }

// LIMITAR PALABRAS      
  function wordlimit($string, $length , $ellipsis)
  {
    $words = explode(' ', strip_tags($string));
    if (count($words) > $length)
    {
      return implode(' ', array_slice($words, 0, $length)) ." ". $ellipsis;
    }
    else
    {
      return $string;
    }
  }

// FECHA                 
  // FECHA CORTA
    function fechaCorta($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      return $fechaD.'-'.$fechaM.'-'.$fechaY;
    }
    
  // FECHA Y HORA
    function fechaHora($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaH=date('H',$fechaSegundos);
      $fechaI=date('i',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      return $fechaD.'-'.$fechaM.'-'.$fechaY.'<br>'.$fechaH.':'.$fechaI;
    }
    
  // SOLO HORA
    function soloHora($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaH=date('H',$fechaSegundos);
      $fechaI=date('i',$fechaSegundos);

      return $fechaH.':'.$fechaI;
    }

  function fechaSQL($fechaSQL){
    $fechaSegundos=strtotime($fechaSQL);

    $fechaY=date('Y',$fechaSegundos);
    $fechaM=date('m',$fechaSegundos);
    $fechaD=date('d',$fechaSegundos);
   
    return $fechaY.'/'.$fechaM.'/'.$fechaD;
  }
  
  // FECHA DIA
    function fechaDisplayDia($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaDay) {
        case 'mon':
        $fechaDia='Lunes';
        break;
        case 'tue':
        $fechaDia='Martes';
        break;
        case 'wed':
        $fechaDia='Miércoles';
        break;
        case 'thu':
        $fechaDia='Jueves';
        break;
        case 'fri':
        $fechaDia='Viernes';
        break;
        case 'sat':
        $fechaDia='Sábado';
        break;
        default:
        $fechaDia='Domingo';
        break;
      }
      return $fechaDia;
    }

  // FECHA MES
    function fechaDisplayMes($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaM) {
        case 1:
        $mes='enero';
        break;
        
        case 2:
        $mes='febrero';
        break;
        
        case 3:
        $mes='marzo';
        break;
        
        case 4:
        $mes='abril';
        break;
        
        case 5:
        $mes='mayo';
        break;
        
        case 6:
        $mes='junio';
        break;
        
        case 7:
        $mes='julio';
        break;
        
        case 8:
        $mes='agosto';
        break;
        
        case 9:
        $mes='septiembre';
        break;
        
        case 10:
        $mes='octubre';
        break;
        
        case 11:
        $mes='noviembre';
        break;
        
        default:
        $mes='diciembre';
        break;
      }

      return $mes;
    }

  // FECHA LARGA
    function fechaDisplay($fechaSQL){
      $fechaSegundos=strtotime($fechaSQL);
      $fechaY=date('Y',$fechaSegundos);
      $fechaM=date('m',$fechaSegundos);
      $fechaD=date('d',$fechaSegundos);
      $fechaDay=strtolower(date('D',$fechaSegundos));

      switch ($fechaM) {
        case 1:
        $mes='enero';
        break;
        
        case 2:
        $mes='febrero';
        break;
        
        case 3:
        $mes='marzo';
        break;
        
        case 4:
        $mes='abril';
        break;
        
        case 5:
        $mes='mayo';
        break;
        
        case 6:
        $mes='junio';
        break;
        
        case 7:
        $mes='julio';
        break;
        
        case 8:
        $mes='agosto';
        break;
        
        case 9:
        $mes='septiembre';
        break;
        
        case 10:
        $mes='octubre';
        break;
        
        case 11:
        $mes='noviembre';
        break;
        
        default:
        $mes='diciembre';
        break;
      }

      switch ($fechaDay) {
        case 'mon':
        $fechaDia='Lunes';
        break;
        case 'tue':
        $fechaDia='Martes';
        break;
        case 'wed':
        $fechaDia='Miércoles';
        break;
        case 'thu':
        $fechaDia='Jueves';
        break;
        case 'fri':
        $fechaDia='Viernes';
        break;
        case 'sat':
        $fechaDia='Sábado';
        break;
        default:
        $fechaDia='Domingo';
        break;
      }

      return $fechaDia.' '.$fechaD.' de '.$mes.' de '.$fechaY;
    }

// CARRUSEL              
  // Carousel Inicio
    function carousel($carousel){
      global $CONEXION;
      global $dominio;

      $CONSULTA= $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
      $row_CONSULTA = $CONSULTA -> fetch_assoc();
      switch ($row_CONSULTA['slideranim']) {
        case 0:
          $animation='fade';
          break;
        case 1:
          $animation='slide';
          break;
        case 2:
          $animation='scale';
          break;
        case 3:
          $animation='pull';
          break;
        case 4:
          $animation='push';
          break;
        default:
          $animation='fade';
          break;
      }
      $CAROUSEL = $CONEXION -> query("SELECT * FROM $carousel ORDER BY orden");
      $numPics=$CAROUSEL->num_rows;
      if ($numPics>0) {
        echo '
            <!-- Start Carousel -->
            <div class="slider-inicio" uk-slideshow="autoplay:true;autoplay-interval:5000;ratio:'.$row_CONSULTA['sliderproporcion'].';animation:'.$animation.';min-height:'.$row_CONSULTA['sliderhmin'].';max-height:'.$row_CONSULTA['sliderhmax'].';" class="uk-grid-collapse" uk-grid>
              <div class="uk-visible-toggle uk-width-1-1 uk-flex-first">
                <div class="uk-position-relative">
                  <ul class="uk-slideshow-items">';
                    $num=0;
                    $activo=' active';
                    while ($row_CAROUSEL = $CAROUSEL -> fetch_assoc()) {
                      $caption='';
                      if (strlen($row_CAROUSEL['url'])>0) {
                        $pos=strpos($row_CAROUSEL['url'], $dominio);
                        $target=($pos>0)?'':'target="_blank"';
                        if ($row_CONSULTA['slidertextos']==1 AND strlen($row_CAROUSEL['titulo'])>0 AND strlen($row_CAROUSEL['url'])>0) {
                          $caption='
                          <div class="uk-position-bottom uk-transition-slide-bottom">
                            <div style="min-width:200px;min-height:100px;" class="uk-text-center">
                              <a href="'.$row_CAROUSEL['url'].'" '.$target.' class="uk-button uk-button-white uk-button-large">
                                '.$row_CAROUSEL['titulo'].'
                              </a>
                            </div>
                          </div>';
                        }
                      }
                      echo '
                          <li>
                            <img class="img-slider" src="../img/contenido/'.$carousel.'/'.$row_CAROUSEL['id'].'.jpg" uk-cover>
                            '.$caption.'
                          </li>';
                    }

                    echo '
                  </ul>
                    <!-- CONTROLES SLIDER -->
                   <div class="margin-top-10" uk-grid>
                        <div class="uk-width-1-2 uk-padding-remove uk-visible@s">
                        </div>
                        <div class="uk-width-1-2@s uk-width-1-4@m uk-padding-remove">
                            <ul class="uk-slideshow-nav uk-dotnav uk-flex-right uk-margin" style="margin-top: 10px;margin-right: 10px;"></ul>
                        </div>
                        <div class="uk-width-1-2@s uk-width-1-4@m uk-flex uk-flex-middle uk-padding-remove">
                            <div class="larger-line-black padding-h-10"></div>
                        </div>
                      
                  </div>

                    <!--div class=" uk-width-1-2@m uk-position-center-right uk-position-small" uk-slider style="width:45%; ">
                        <div class="uk-position-relative uk-visible-toggle uk-dark aling-center" tabindex="-1" uk-slider style="height:450px;width:450px;">
                            <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-1@s uk-child-width-1-1@m  aling-center" style="margin:0 2em">
                          
                                <li class="uk-margins-right">
                                    <div class="uk-padding">
                                        <div class="uk-card uk-card-default uk-transition-toggle" style="border: 1px solid #7c573a;margin-right: 20px;">
                                            <div class="uk-card-media-top uk-flex uk-flex-center">
                                                <div class="uk-cover-container" style="width:200px; height: 220px">
                                                     <img src="./../img/design/chamarra.png" alt="" uk-cover>
                                                </div>
                                            </div>
                                            <a href="1_chamarra_item">
                                                <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
                                                    
                                                    <p class="uk-text-uppercase">Ver detalles</p>
                                                    <hr class="uk-divider-small">
                                                    <i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

                                                </div>
                                            </a>
                                            <div class="uk-card-body uk-text-center padding-10">
                                                <hr class="uk-divider-small">
                                                <p class="uk-text-uppercase">Chamarra de piel</p>
                                                <p>$4500 MX</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="uk-margins-right">
                                    <div class="uk-padding">
                                        <div class="uk-card uk-card-default uk-transition-toggle" style="border: 1px solid #7c573a;margin-right: 20px;">
                                            <div class="uk-card-media-top uk-flex uk-flex-center">
                                                <div class="uk-cover-container" style="width:200px; min-height: 220px">
                                                     <img src="./../img/design/chamarra.png" alt="" uk-cover>
                                                </div>
                                            </div>
                                            <a href="1_chamarra_item">
                                                 <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-primary uk-text-center productos-overlay">
                                                    
                                                    <p class="uk-text-uppercase">Ver detalles</p>
                                                    <hr class="uk-divider-small">
                                                    <i class="fa fa-shopping-bag cartcount" aria-hidden="true"></i>

                                                </div>
                                            </a>
                                            <div class="uk-card-body uk-text-center padding-10">
                                                <hr class="uk-divider-small">
                                                <p class="uk-text-uppercase">Chamarra de piel</p>
                                                <p>$4500 MX</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                           
                            </ul>
                            
                        </div>
                    </div-->

                </div>         

              </div>
            </div>
            <!-- End Carousel -->
            ';
      }
      mysqli_free_result($CAROUSEL);
    }




// ITEM                   
  function item($id){
    global $CONEXION;
    global $caracteres_si_validos;
    global $caracteres_no_validos;

    $widget    = '';
    $style     = 'max-width:200px;';  
    $noPic     = '../img/design/camara.jpg';
    $rutaPics  = '../img/contenido/productos/';
    $firstPic  = $noPic;

    $CONSULTA1 = $CONEXION -> query("SELECT * FROM productos WHERE id = $id");
    $row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
    $link=$id.'_'.urlencode(str_replace($caracteres_no_validos,$caracteres_si_validos,html_entity_decode(strtolower($row_CONSULTA1['titulo'])))).'-.html';

    // Fotografía
      $CONSULTA3 = $CONEXION -> query("SELECT * FROM productospic WHERE producto = $id ORDER BY orden,id LIMIT 1");
      while ($rowCONSULTA3 = $CONSULTA3 -> fetch_assoc()) {
        $firstPic = $rutaPics.$rowCONSULTA3['id'].'.jpg';
      }

      $picWidth=0;
      $picHeight=0;
      $picSize=getimagesize($firstPic);
      foreach ($picSize as $key => $value) {
        if ($key==3) {
          $arrayCadena1=explode(' ',$value);
          $arrayCadena1=str_replace('"', '', $arrayCadena1);
          foreach ($arrayCadena1 as $key1 => $value1) {

            $arrayCadena2=explode('=',$value1);
            foreach ($arrayCadena2 as $key2 => $value2) {
              if (is_numeric($value2)) {
                $picProp[]=$value2;
              }
            }
          }
        }
      }
      if (isset($picProp)) {
        $picWidth=$picProp[0];
        $picHeight=$picProp[1];

        $style=($picWidth<$picHeight)?'max-height:200px;':$style;
      }

    $widget.='
      <div id="item'.$id.'" class="uk-text-center">
        <div class="bg-white padding-20" style="border:solid 1px #CCC;">
          <a href="'.$link.'" style="color:black;">
            <div class="margin-10">
              <div class="uk-flex uk-flex-center uk-flex-middle" style="height: 200px;">
                <img data-src="'.$firstPic.'" uk-img style="'.$style.'">
              </div>
              <div style="min-height:100px;">
                <div>
                  '.$row_CONSULTA1['sku'].'
                </div>
                <div class="uk-flex uk-flex-center">
                  <div class="line-yellow"></div>
                </div>
                <div class="padding-v-10">
                </div>
                <div>
                  '.$row_CONSULTA1['titulo'].'
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>';

    return $widget;
  }

