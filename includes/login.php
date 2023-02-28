<?php

/* %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 
						LOGIN USING EMAIL
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  */
	// Modal para logueo
  
	$iniciarSesion = 'Inicia sesión';
	$iniciarSesion 		= 'Inicia sesión';
	$correo 			= 'Correo';
	$contra 			= 'Contrase&ntilde;a';
	$entrar 			= 'Iniciar sesión';
	$nuevo 				= '¿Nuevo en el sitio?';
	$registar 			= 'Regístrate';
	$recuperarPass 		= '¿Olvidaste tu contraseña?';
	$recuperar 			= 'recover';
	$passIncorrecto 	= 'Contraseña incorrecta';
	$datosAcceso 		= 'Escriba sus datos de acceso';
	$noExiste 			= 'No existe el usuario';
	$salir              = 'Salir';

	if ($languaje == 'en') {
	   	$salir 			= 'Close';
		$iniciarSesion 	= 'Login';
		$correo 		= 'Email';
		$contra 		= 'Password';
		$entrar			= 'Login';
		$nuevo 			= 'New in the site?';
		$registar 		= 'Sign up';
		$recuperarPass 	= 'Forgot your password?';
		$recuperar 		= 'recover';
		$passIncorrecto = 'Incorrect password';
		$datosAcceso	= 'Enter your access data';
		$noExiste 		= 'There is no user';
	}
	
	$fallo			= 0;
	$rutaMiCta		= $ruta.'mi-cuenta';
	$loginButton    = '
		<a href="#login"   class="uk-button uk-button-personal" uk-toggle>
			'.$iniciarSesion.'
		</a>';

	$loginButtonWhite    = '
		<a href="#login"   class="uk-button uk-button-personal-white" uk-toggle style="font-size:12px; padding: 0 25px;">
			'.$iniciarSesion.'
		</a>';

		
	// Ventana modal de logueo
	$loginModal='
	<div id="login" uk-modal class="modal-login">
		<div class="uk-modal-dialog">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<div class="uk-modal-header">
				<div class="uk-text-center">
					<img src="'.$logo.'" style="max-height:100px;" alt="'.$Brand.'">
				</div>
			</div>
			<div class="padding-20">
				<div class="">
					<form action="'.$rutaEstaPagina.'" method="post">
						<input type="hidden" name="login" value="1">
						<label for="pass">*'.$correo.':</label>
						<div class="input-container">
							<input name="loginemail" class="uk-input input-personal" type="email" required>
						</div>
						<label for="pass">*'.$contra.':</label>
						<div class="input-container">
							<input name="password" class="uk-input input-personal" type="password" required>
						</div>
						<div class="uk-margin-top">
							<button class="uk-button uk-button-primary uk-width-1-1">'.$entrar.'</button>
						</div>
					</form>
				</div>
				<div class="uk-text-center margen-v-20">
					<fb:login-button 
						scope="public_profile,email" 
						onlogin="checkLoginState();"
						class="fb-login-button"
						data-size="large"
						data-button-type="continue_with"
						data-show-faces="false"
						>
					</fb:login-button>
					<div class="fbstatus">
					</div>
				</div>
				<div uk-grid class="uk-text-center padding-top-50">
					<div class="uk-width-1-2">
						<div class="text-11">
							'.$nuevo.'
						</div>
						<div class="uk-width-1-1">
							<div class="uk-margin-top">
								<a href="Registro" class="uk-button uk-button-default">'.$registar.'</a>
							</div>
						</div>
					</div>
					<div class="uk-width-1-2">
						<div class="text-11">
							'.$recuperarPass.'
						</div>
						<div class="uk-width-1-1">
							<div class="uk-margin-top">
								<a href="password-recovery" class="uk-button uk-button-default">'.$recuperar.'</a>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-1-1">
					<br>
				</div>
			</div>
		</div>
	</div>';


	// Obtener usuario
	$unombre='&nbsp;';
	if (isset($_SESSION['uid'])) {
		$uid  = $_SESSION['uid'];
		$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE id = '$uid'");
		$row_USER = $USER -> fetch_assoc();
		$unombre  = $row_USER['nombre'];
		$uemail   = $row_USER['email'];
		$ulevel   = $row_USER['nivel'];
		$nombreCortoEspacio=strpos($unombre, ' ');
		$nombreCorto=($nombreCortoEspacio==0)?$unombre:substr($unombre,0,(strpos($unombre, ' ')));
		$loginModal = '';
	}else{
		if(isset($_POST['login']) and $_POST['login']!='') { $login = $_POST['login']; }
		if(isset($_POST['loginemail']) and $_POST['loginemail']!='') { $email = htmlentities($_POST['loginemail']); }else{ $fallo=1; }
		if(isset($_POST['password']) and $_POST['password']!='') { $password = md5($_POST['password']); }else{ $fallo=1; }
		if(isset($_POST['pass1']) and $_POST['pass1']!='') { $pass1 = md5($_POST['pass1']); }else{ $pass1=''; }
		if(isset($_POST['pass1']) and $_POST['pass1']!='') { $passLen = strlen($_POST['pass1']); }else{ $passLen=0; }

		if ($fallo==0) {
			// Comprobar si el usuario existe
			$USER = $CONEXION -> query("SELECT * FROM usuarios WHERE email = '$email'");
			$numUser=$USER->num_rows;

			// Si no existe, verificamos que no esté registrando
			if ($numUser>0) {
				$row_USER = $USER -> fetch_assoc();
				if ($row_USER['pass']===$password OR $row_USER['pass']=='') {
					$_SESSION['uid'] = $row_USER['id'];
					$uid=$_SESSION['uid'];
					$unombre=$row_USER['nombre'];
					$uemail=$row_USER['email'];
					$ulevel=$row_USER['nivel'];
					$nombreCortoEspacio=strpos($unombre, ' ');
					$nombreCorto=($nombreCortoEspacio==0)?$unombre:substr($unombre,0,(strpos($unombre, ' ')));
					$loginModal='';
					$mensajeClase='success';
					$mensaje='Bienvenido '.$unombre;
				}else{
					$mensajeClase='danger';
					$mensaje='Contraseña incorrecta';
				}
			}else{
				$sql = "INSERT INTO usuarios (email,pass,alta)".
				"VALUES ('$email','$password','$hoy')";
				if ($insertar = $CONEXION->query($sql)) {
					$uid = $CONEXION->insert_id;
					$_SESSION['uid'] = $uid;
					
					$unombre="usuario";
					$uemail=$email;
					$ulevel="0";
					$nombreCortoEspacio="usuario";
					$nombreCorto=($nombreCortoEspacio==0)?$unombre:substr($unombre,0,(strpos($unombre, ' ')));
					$loginModal='';
					$mensajeClase='success';
					$mensaje='Bienvenido '.$unombre;
				}else{
					$mensajeClase='danger';
					$mensaje='No se pudo guardar';
				}
			}
		}
	}


	// Existe el usuraio
	if (isset($uid)) {
		$loginButton='
			<a href="'.$rutaMiCta.'" class="uk-link-reset uk-text-center">
				<i class="fa fa-user"></i> &nbsp; '.$nombreCorto.'
			</a>
			<a href="logout" class="uk-link-reset uk-text-center">
				<i class="fa fa-unlock"></i> &nbsp; '.$salir.'
			</a>';
		$loginButtonWhite='
			<a href="'.$rutaMiCta.'" class="uk-link-reset uk-text-center padding-h-20" style="color:white!important;font-size:12px">
				<i class="fa fa-user color-blanco"></i> '.$nombreCorto.'&nbsp; 
			</a>';
		// Ventana modal de logueo
		$loginModal='';
	}
