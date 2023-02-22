<?php
/* %%%%%%%%%%%%%%%%%%%% MENSAJES               */
	if($mensaje!=''){
		$mensajes='
			<div class="uk-container">
				<div uk-grid>
					<div class="uk-width-1-1 margen-v-20">
						<div class="uk-alert-'.$mensajeClase.'" uk-alert>
							<a class="uk-alert-close" uk-close></a>
							'.$mensaje.'
						</div>					
					</div>
				</div>
			</div>';
	}


/* %%%%%%%%%%%%%%%%%%%% RUTAS AMIGABLES        */
		$rutaInicio			=	'Inicio';
		$rutaNosotros		=	'nosotros';
		$rutaTienda			=	'productos';
		// $rutaPedido			=	$ruta.'Revisar_orden';
		$rutaPedido			=	$ruta.'ProcesoCompra';
		$rutaCuidados		=	'cuidados';
		$rutaContacto		=	'contacto';


		if ($languaje == 'es') {
			$menu0 = 'INICIAR SESÍON';
			$menu1 = 'HOME';
			$menu2 = 'NOSOTROS';
			$menu3 = 'PRODUCTOS';
			$menu4 = 'MI PEDIDO';
			$menu5 = 'CUIDADOS';
			$menu6 = 'CONTACTO';
			$helpText = "AYUDA";
			$navText="NAVEGACIÓN";
			$languajeText = "en";
			$rutaFlag="../img/design/usa.png";
			$faqs1="PREGUNTAS FRECUENTES";
			$faqs2="AVISO DE PRIVACIDAD";
			$faqs3="TERMINOS Y CONDICIONES";
			$faqs4="POLÍTICAS DE ENVIO";
			$derechosText = "TODOS LOS DERECHOS RESERVADOS";

		}elseif ($languaje == 'en') {
			
			$menu1 = 'HOME';
			$menu2 = 'ABOUT';
			$menu3 = 'PRODUCTS';
			$menu4 = 'MY ORDER';
			$menu5 = 'CARES';
			$menu6 = 'CONTACT US';
			$helpText="HELP";
			$navText="MENU";
			$languajeText = "es	";
			$rutaFlag="../img/design/mex.png";
			$faqs1="FAQS";
			$faqs2="NOTICE OF PRIVACY";
			$faqs3="TERMS AND CONDITIONS";
			$faqs4="SHIPPING POLICIES";
			$derechosText = "ALL RIGHTS RESERVED";

		}
		


/* %%%%%%%%%%%%%%%%%%%% MENU                   */
	$menu='

		<li class="'.$nav2.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset" href="'.$rutaInicio.'">'.$menu1.'</a></li>
		<li class="'.$nav3.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset" href="'.$rutaNosotros.'">'.$menu2.'</a></li>
		<li class="'.$nav4.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset" href="'.$rutaTienda.'">'.$menu3.'</a></li>
		<!--li class="'.$nav5.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset" href="'.$rutaPedido.'">'.$menu4.'</a></li-->
		<li class="'.$nav6.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset" href="'.$rutaCuidados.'">'.$menu5.'</a></li>
		<li class="'.$nav7.' uk-margin-medium-right color-primary negritas text-9"><a  class="uk-link-reset"  href="'.$rutaContacto.'">'.$menu6	.'</a></li>
		';

	$menuMovil='
		<li class="uk-margin-medium-right"><a href="Registro">'.$menu0.'</a></li>
		<li class="'.$nav1.' uk-margin-medium-right"><a href="'.$rutaInicio.'">'.$menu1.'</a></li>
		<li class="'.$nav2.' uk-margin-medium-right"><a href="'.$rutaNosotros.'">'.$menu2.'</a></li>
		<li class="'.$nav3.' uk-margin-medium-right"><a href="'.$rutaTienda.'">'.$menu3.'</a></li>
		<!--li class="'.$nav4.' uk-margin-medium-right"><a href="'.$rutaPedido.'">'.$menu4.'</a></li-->
		<li class="'.$nav5.' uk-margin-medium-right"><a href="'.$rutaCuidados.'">'.$menu5.'</a></li>
		<li class="'.$nav6.' uk-margin-medium-right"><a href="'.$rutaContacto.'">'.$menu6.'</a></li>
		';

/* %%%%%%%%%%%%%%%%%%%% HEADER                 */
	$header='
		<div class="uk-offcanvas-content uk-position-relative">
			<header>
				<div class="uk-container uk-container-large margin-bottom-20">
					<div class="" style="margin-left: 0;" uk-grid>
						<div class="uk-width-1-3@m uk-width-1-2@l uk-padding-remove">
							<div style="margin-left: 0" class="uk-flex uk-flex-bottom uk-flex-right uk-visible@m" uk-grid>
								<div class="uk-width-1-1@s uk-width-1-3@m padding-h-5 buscador">
									<div class="custom-search uk-flex uk-flex-right uk-flex-middle margin-right-5">
							        	<input class="uk-search-input search color-primary" type="search" placeholder="Search...">
							    		<span class="uk-search-icon-flip color-primary" uk-search-icon></span>
							    	</div>
								</div>
							</div>
						</div>
						<!-- MENU DESKTOP -->
						<div class="uk-width-1-2@m  uk-width-1-2@l padding-5 uk-visible@m">
							<div uk-grid style="margin-left: 0;" class="uk-flex uk-flex-right">
								<div class="uk-width-1-1@s uk-width-1-4@m uk-flex uk-flex-middle uk-flex-right">
									<div class="margin-5 color-primary text-lg">
						    		<a class="uk-link-reset" id="idioma" href="../'.$langNew.'/" style="text-transform: uppercase;">
						    			'.$languajeText.'
										<span class="uk-icon uk-icon-image" 
										style="background-image: url('.$rutaFlag.');margin-right: 5px;margin-bottom: 3px;">
										</span>
						    		</a>
							    </div>
								</div>
								<div class="uk-width-1-1@s uk-width-3-4@m bg-primary padding-5 color-blanco ">
									<div class="uk-grid-small uk-flex uk-flex-center uk-flex-middle" uk-grid>
										<div class="margin-h-5 text-9">
										Tel. '.$telefono.'
										</div>
										<div class="margin-h-5">
											<a href="'.$socialWhats.'" target="_blank" uk-icon="icon:whatsapp; ratio:1"></a>&nbsp;
											<a href="'.$socialFace.'" target="_blank" uk-icon="icon:facebook; ratio:1"></a>&nbsp;
											<a href="'.$socialInst.'" target="_blank" uk-icon="icon:instagram; ratio:1"></a>&nbsp;
										</div>
										<div class="margin-h-5">
											'.$loginButton.'
										</div>
										<div class="margin-h-5">
											<i class="fa fa-shopping-bag cartcount" aria-hidden="true">
												<span class="numerito">'.$carroTotalProds.'</span>
											</i>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<div class="uk-width-1-1@m margin-top-5 uk-padding-remove">
							<div class="uk-cover-container uk-flex uk-flex-center">
							   <a href="Inicio">
								 <img class="movil-logo uk-align-center" data-src="../img/design/logo.png" width="240" height="120" alt="" uk-img>
								 </a>
							</div>
						</div>
						<!-- MENU MOVIL -->
						<div class="uk-width-1-1@s uk-padding-remove uk-hidden@m margin-top-5" style="min-height: 40px; background: black">
							<nav class="uk-navbar">
							    <div class="uk-navbar-left uk-width-auto" href="#menu-movil" uk-toggle id="menu">
							        <a class="uk-navbar-toggle" uk-navbar-toggle-icon style="color: white;padding: 10px;"></a>
							    </div>
						
							     <div class="uk-width-expand uk-flex uk-flex-middle uk-flex-right margin-right-20">
							     	<!--div class="custom-search uk-flex uk-flex-right uk-flex-middle margin-right-5">
				        				<input class="uk-search-input search color-primary" type="search" placeholder="Search...">
				    					<span class="uk-search-icon-flip color-black" uk-search-icon></span>
				    				</div-->
							     	<a class="uk-link-reset color-blanco margin-right-20" id="idioma" href="../'.$langNew.'/" style="text-transform: uppercase;color:white!important;font-size: 16px">
						    			'.$languajeText.'		
						    		</a>	
								    <i class="fa fa-shopping-bag cartcount color-blanco" aria-hidden="true">
											<span class="numerito">'.$carroTotalProds.'</span>
									</i>
									<a href="#modal-search" uk-toggle>
										<span class="uk-margin-small-right color-blanco" style="padding-left: 15px" uk-icon="icon: search; ratio: 1"></span></div>
									</a>
									
							</nav>
							<!-- This is the modal -->
							<div id="modal-search" uk-modal>
							    <div class="uk-modal-dialog uk-modal-body padding-5">
							        <div class="custom-search uk-flex uk-flex-right uk-flex-middle margin-right-5">
				        				<input class="uk-search-input search color-primary" type="search" placeholder="Search...">
				    					<span class="uk-search-icon-flip color-black" uk-search-icon></span>
				    				</div>
							    </div>
							</div>

						</div>
					</div>
					
			</div>
				<!-- SECCION MENU -->
				<div class="uk-container uk-container-large margin-bottom-30 uk-visible@s">
					<div class="text-8">
						<nav class=" bg-menu-border bg-white" uk-navbar  uk-sticky="animation: uk-animation-slide-top bottom: #offset">
							<div class="uk-navbar-center">
								<ul class="uk-navbar-nav">
									'.$menu.'
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</header>

			'.$mensajes.'

			<!-- Off-canvas -->
			<div id="menu-movil" uk-offcanvas="mode: push;overlay: true">
				<div class="uk-offcanvas-bar bg-principal uk-flex uk-flex-column">
					<button class="uk-offcanvas-close" type="button" uk-close></button>
					
					<ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-nav-center uk-margin-auto-vertical" uk-nav>
						'.$menuMovil.'
					</ul>

				</div>
			</div>';

/* %%%%%%%%%%%%%%%%%%%% FOOTER                 */
	$stickerClass=($carroTotalProds==0 OR $identificador==500 OR $identificador==501 OR $identificador==502)?'uk-hidden':'';
	$footer = '
		<footer>
			<div class="bg-footer" style="z-index: 0;">
				<div class="uk-container uk-container-large uk-position-relative uk-width-1-1@s bg-secondary">	
					<div class="uk-container uk-container-small margin-top-50">
						<div uk-grid style="margin-left:0;" class="margin-top-5">
							<div class="uk-width-1-2@m">
								<div class="uk-cover-container">
									<a href="Inicio">
										<img data-src="../img/design/logo-blanco.png" width="220" height="150" alt="" uk-img>
									</a>
						    		
								</div>
							</div>
							<div class="uk-width-1-2@m">
								<div uk-grid style="margin-left:0;" class="padding-top-10">
									<div class="uk-width-expand uk-width-3-4@m color-white margin-0 padding-h-0 uk-flex uk-flex-right uk-flex-middle">
										<div class="padding-right-10" style="color:white!important">'.$loginButton.' </div>				
									</div>		
									<div class="uk-width-auto uk-width-1-4@m color-white padding-h-0 uk-flex uk-flex-center uk-flex-middle carrito-icon">
										<i class="fa fa-shopping-bag margin-left color-blanco" aria-hidden="true"><span class="numerito" style="color:white">'.$carroTotalProds.'</span></i>	
									</div>
								</div>
							</div>
							<div class="uk-width-1-3@m">
								<ul class="uk-nav uk-nav-default footer-nav">
							        <li class="color-blanco bottom-line">'.$navText.'</li>
							        <li><a href="'.$rutaInicio.'">'.$menu1.'</a></li>
							        <li><a href="'.$rutaNosotros.'">'.$menu2.'</a></li>
							        <li><a href="'.$rutaTienda.'">'.$menu3.'</a></li>
							        <li class="bottom-line padding-bottom-30"><a href="'.$rutaContacto.'">'.$menu6.'</a></li>
							    </ul>
							</div>
							<div class="uk-width-1-3@m">
								<ul class="uk-nav uk-nav-default footer-nav">
							        <li class="color-blanco bottom-line">'.$helpText.'</li>
							        <li><a href="preguntas-frecuentes">'.$faqs1.' </a></li>
							        <li><a href="1_politicas">'.$faqs2.'</a></li>
							        <li><a href="4_politicas">'.$faqs3.'</a></li>
							        <li class="bottom-line padding-bottom-30"><a href="3_politicas">'.$faqs4.'</a></li>
							    </ul>
							</div>
							<div class="uk-width-1-3@m">
								<ul class="uk-nav uk-nav-default footer-nav">
							        <li class="color-blanco bottom-line">SOCIAL</li>
							        <li><a href="'.$rutaPedido.'">'.$menu4.'</a></li>
							        <li><a href="'.$socialFace.'">FACEBOOK</a></li>
							        <li><a href="'.$socialInst.'">INSTAGRAM</a></li>
							        <li class="bottom-line padding-bottom-30"><a  href="#" class="hidden zero" style="color:black!important">NADA</a></li>
							    </ul>
							</div>
							<div class="uk-width-1-1 uk-text-center">
								<div class="margin-bottom-20 margin-top-menos-20">
									<a href="'.$socialWhats.'" target="_blank" class="uk-margin-small-right color-blanco" uk-icon="whatsapp"></a>
									<a href="'.$socialFace.'" target="_blank" class="uk-margin-small-right color-blanco" uk-icon="facebook"></a>
									<a href="'.$socialInst.'" class="uk-margin-small-right color-blanco" uk-icon="instagram"></a>
								</div>
								<div class="padding-top-10 color-blanco">
									<p class="text-8 zero">CASAPIEL '.date('Y').' '.$derechosText.' <p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<p class="text-8 uk-text-center color-primary margin-0">	DISEÑO POR WOZIAL MARKETING LOVERS </p>
			</div>
		</footer>

		<div id="cotizacion-fixed" class="uk-position-top uk-height-viewport '.$stickerClass.'">
			<div>
				<a href="'.$rutaPedido.'"><img src="../img/design/checkout.png"></a>
			</div>
		</div>

		'.$loginModal.'

		<!--div id="totop">
			<a href="#menu-movil" uk-toggle id="menu" class="uk-icon-button uk-button-totop uk-box-shadow-large claro uk-hidden@m"><i class="fa fa-bars fa-1x" aria-hidden="true"></i></a>
			</div>
		</div-->

		<!-- Whatsapp Plugin -->

			<div id="whatsapp-plugin" class="uk-hidden">
				<div id="whats-head" class="uk-position-relative">
					<div uk-grid class="uk-grid-small uk-grid-match">
						<div>
							<div class="uk-flex uk-flex-center uk-flex-middle">
								<img class="uk-border-circle padding-10" src="img/design/logo-whatsapp.jpg" style="width:70px;">
							</div>
						</div>
						<div>
							<div class="uk-flex uk-flex-center uk-flex-middle color-blanco">
								<div>
									<span class="text-sm">Casapiel</span><br>
									<span class="text-6 uk-text-light">Atención en línea vía chat</span>
								</div>
							</div>
						</div>
					</div>
					<div class="uk-position-right color-blanco text-sm">
						<span class="pointer padding-10" id="whats-close">x</spam>
					</div>
				</div>
				<div id="whats-body-1" class="uk-flex uk-flex-middle">
					<div class="bg-white uk-border-rounded padding-h-10" style="margin-left:20px;">
						<img src="library/whats/loading.gif" style="height:40px;">
					</div>
				</div>
				<div id="whats-body-2" class="uk-hidden">
					<span class="uk-text-bold uk-text-muted">'.$Brand.'</span><br>
					Hola 👋<br>
					¿Cómo puedo ayudarte?
				</div>
				<div id="whats-footer" class="uk-flex uk-flex-center uk-flex-middle">
					<a href="'.$socialWhats.'" target="_blank" class="uk-button uk-button-small" id="button-whats"><i class="fab fa-whatsapp fa-lg"></i> <span style="font-weight:400;">Comenzar chat</span></a>
				</div>
			</div>
		<!-- Whatsapp Plugin -->
	
	</div>';

/* %%%%%%%%%%%%%%%%%%%% HEAD GENERAL                */
	$headGNRL='
		<html lang="'.$languaje.'">
		<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

			<meta charset="utf-8">
			<title>'.$title.'</title>
			<meta name="description" content="'.$description.'" />
			<meta property="fb:app_id" content="'.$appID.'" />
			<link rel="image_src" href="'.$ruta.$logoOg.'" />

			<meta property="og:type" content="website" />
			<meta property="og:title" content="'.$title.'" />
			<meta property="og:description" content="'.$description.'" />
			<meta property="og:url" content="'.$rutaEstaPagina.'" />
			<meta property="og:image" content="'.$ruta.$logoOg.'" />

			<meta itemprop="name" content="'.$title.'" />
			<meta itemprop="description" content="'.$description.'" />
			<meta itemprop="url" content="'.$rutaEstaPagina.'" />
			<meta itemprop="thumbnailUrl" content="'.$ruta.$logoOg.'" />
			<meta itemprop="image" content="'.$ruta.$logoOg.'" />

			<meta name="twitter:title" content="'.$title.'" />
			<meta name="twitter:description" content="'.$description.'" />
			<meta name="twitter:url" content="'.$rutaEstaPagina.'" />
			<meta name="twitter:image" content="'.$ruta.$logoOg.'" />
			<meta name="twitter:card" content="summary" />

			<meta name="viewport"       content="width=device-width, initial-scale=1">

			<link rel="icon"            href="'.$ruta.'img/design/favicon.ico" type="image/x-icon">
			<link rel="shortcut icon"   href="../img/design/favicon.ico" type="image/x-icon">
			<link rel="stylesheet"      href="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/css/uikit.min.css" />
			<link rel="stylesheet"      href="../css/general.css">
			<link rel="stylesheet"      href="https://fonts.googleapis.com/css?family=Lato:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
			<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700&display=swap" rel="stylesheet">
			<link rel="stylesheet"      href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
			<script src="https://kit.fontawesome.com/910783a909.js" crossorigin="anonymous"></script>

			<!-- mensaje toatr -->
			<link rel="stylesheet" href="../library/toastr/toastr.min.css">
			<script src="../library/toastr/toastr.min.js" ></script>
			<!-- mensaje toatr -->

			<!-- jQuery is required -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- UIkit JS -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/js/uikit.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/'.$uikitVersion.'/js/uikit-icons.min.js"></script>
		</head>';


/* %%%%%%%%%%%%%%%%%%%% SCRIPTS                */
	$scriptGNRL='
		<script src="../js/general.js"></script>

		<script>
			$(".cantidad").keyup(function() {
				var inventario = $(this).attr("data-inventario");
				var cantidad = $(this).val();
				inventario=1*inventario;
				cantidad=1*cantidad;
				if(inventario<=cantidad){
					$(this).val(inventario);
				}
				console.log(inventario+" - "+cantidad);
			})
			$(".cantidad").focusout(function() {
				var inventario = $(this).attr("data-inventario");
				var cantidad = $(this).val();
				inventario=1*inventario;
				cantidad=1*cantidad;
				if(inventario<=cantidad){
					//console.log(inventario*2+" - "+cantidad);
					$(this).val(inventario);
				}
			})

			// Agregar al carro
			$(".buybutton").click(function(){
				var id=$(this).data("id");
				var idExis =$(this).data("idexis");
				var cantidad=$("#"+id).val();			
				//console.log("cantidad",cantidad);
				//console.log("El otro id",idExis);
				$.ajax({
					method: "POST",
					url: "addtocart",
					data: { 
						id: idExis,
						cantidad: cantidad,
						addtocart: 1
					}
				})
				.done(function( msg ) {
					datos = JSON.parse(msg);
					UIkit.notification.closeAll();
					UIkit.notification(datos.msg);
					$("#cartcount").html(datos.count);
					$("#cotizacion-fixed").removeClass("uk-hidden");
				});
			})
		</script>
		';



	// Script login Facebook
	$facebookLogin=1;
	$scriptGNRL.=(!isset($_SESSION['uid']) AND $dominio != 'localhost' AND isset($facebookLogin))?'
		<script>
			// Esta es la llamada a facebook FB.getLoginStatus()
			function statusChangeCallback(response) {
				if (response.status === "connected") {
					procesarLogin();
				} else {
					console.log("No se pudo identificar");
				}
			}

			// Verificar el estatus del login
			function checkLoginState() {
				FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				});
			}

			// Definir características de nuestra app
			window.fbAsyncInit = function() {
				FB.init({
					appId      : "'.$appID.'",
					xfbml      : true,
					version    : "v3.2"
				});
				FB.AppEvents.logPageView();
			};

			// Ejecutar el script
			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/es_LA/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));
			
			// Procesar Login
			function procesarLogin() {
				FB.api(\'/me?fields=id,name,email\', function(response) {
					console.log(response);
					$.ajax({
						method: "POST",
						url: "../includes/acciones.php",
						data: { 
							facebooklogin: 1,
							nombre: response.name,
							email: response.email,
							id: response.id
						}
					})
					.done(function( response ) {
						console.log( response );
						datos = JSON.parse( response );
						UIkit.notification.closeAll();
						UIkit.notification(datos.msj);
						if(datos.estatus==0){
							location.reload();
						}
					});
				});
			}
		</script>

		':'';


// Reportar actividad
	$scriptGNRL.=(!isset($_SESSION['uid']))?'':'
		<script>
			var w;
			function startWorker() {
			  if(typeof(Worker) !== "undefined") {
			    if(typeof(w) == "undefined") {
			      w = new Worker("../js/activityClientFront.js");
			    }
			    w.onmessage = function(event) {
					//console.log(event.data);
			    };
			  } else {
			    document.getElementById("result").innerHTML = "Por favor, utiliza un navegador moderno";
			  }
			}
			startWorker();
		</script>
		';

		

/* %%%%%%%%%%%%%%%%%%%% BUSQUEDA               */
	$scriptGNRL.='
		<script>
			$(document).ready(function(){
				$(".search").keyup(function(e){
					if(e.which==13){
						var consulta=$(this).val();
						var l = consulta.length;
						if(l>2){
							window.location = ("'.$ruta.'"+consulta+"_resultado");
						}else{
							UIkit.notification.closeAll();
							UIkit.notification("<div class=\'bg-danger color-blanco\'>Se requiren al menos 3 caracteres</div>");
						}
					}
				});
				$(".search-button").click(function(){
					var consulta=$(".search-bar-input").val();
					var l = consulta.length;
					if(l>2){
						window.location = ("'.$ruta.'"+consulta+"_gdl");
					}else{
						UIkit.notification.closeAll();
						UIkit.notification("<div class=\'bg-danger color-blanco\'>Se requiren al menos 3 caracteres</div>");
					}
				});
			});
		</script>';





