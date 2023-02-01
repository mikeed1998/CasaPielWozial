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
  <meta property="og:image" content="<?=$ruta.$logoOg?>">
  <meta property="fb:app_id" content="<?=$appID?>">

  <?=$headGNRL?>

</head>

<body>
<?=$header?>
<?php 
	
	if($languaje == 'es'){
		$tituloText = "El registro es para dar seguimiento a tu pedido";
		$buttonLogin = "Entrar";
		$passRecoveryText="¿Olvidaste tu contraseña?";
		$recuperarText = "Recuperar";
		$textNew = "El registro es para dar seguimiento a tu pedido";
		$textNombre ="*Nombre";
		$textEmail ="*Email";
		$textPass="*Constraseña";
		$textTelefono="*Telefono";
		$textEmpresa="Empresa";
		$textCalle="*Calle";
		$textInt="*No Interior";
		$textExt="No Exterior";
		$textEntreCalles="*Entre calles";
		$textColonia="*Colonia";
		$textMunicipio="Municipio";
		$textPais="*Pais";
		$textEstado="*Estado";
		$textCp="*Codigo postal";
		$textObligatorio="* Campos obligatorios";
		$textButton="CONTINUAR";

	}
	elseif($languaje == 'en') {
		$tituloText = "Have you bought before?";
		$buttonLogin = "Log in";
		$passRecoveryText="Forgot password?";
		$recuperarText="Recover";
		$textNew = "Are you new in the page?";
		$textNombre ="*Name";
		$textEmail ="*Email";
		$textPass="*Password";
		$textTelefono="*Telphone";
		$textEmpresa="Company";
		$textCalle="*Street";
		$textInt="*Interior number";
		$textExt="exterior number";
		$textEntreCalles="*Between streets";
		$textColonia="*Suburb";
		$textMunicipio="Municipality";
		$textPais="*Country";
		$textEstado="*Estate";
		$textCp="*Postal Code";
		$textObligatorio="* Required fields";
		$textButton="NEXT";
	} 

?>

<div class="uk-container">
	<div class="uk-width-1-1  margin-v-50 bg-primary">
		<div class="padding-v-10 border-white-left">
			<div class="uk-flex uk-flex-middle">
				<div class="uk-container color-blanco text-xl">
					<span style="font-weight: 200;"><?=$tituloText ?></span> 
				</div>
			</div>
		</div>
	</div>
	<div class="uk-container">
		<div class="uk-width-1-1">
			<form action="" method="post" onsubmit="return checkForm(this);">
				<input type="hidden" name="login" value="1">
				<div uk-grid class="uk-grid-small">
					<div class="uk-width-1-3@s">
						<label for="loginemail" class="uk-form-label">Email</label>
						<input name="loginemail" class="uk-input uk-input-grey" id="loginemail" type="email" tabindex="5" value="" required autofocus>
					</div>
					<div class="uk-width-1-3@s">
						<label for="pass" class="uk-form-label">*Contraseña &nbsp<i class="fas fa-eye-slash uk-float-right pointer" data-estatus="0"></i></label>
						<input name="password" class="uk-input uk-input-grey" id="login-pass1" type="password" tabindex="5" value="" required>
					</div>
					<div class="uk-width-1-3@s uk-margin uk-text-center">
						<button class="uk-button uk-button-default border-orange" value="Entrar" id="" name="enviar" tabindex="5"><?= $buttonLogin  ?> </button>
					</div>
					<div class="uk-width-1-1@s uk-text-center uk-text-left@m">
						<div>
							<?= $passRecoveryText ?>
						</div>
						<div class="uk-width-1-1">
							<div class="uk-margin-top">
								<a href="password-recovery" class="uk-button uk-button-default"> <?= $recuperarText  ?></a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="uk-width-1-1 uk-text-center uk-margin-top">
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
		</div>
	</div>
	
	
</div>

<div class="padding-v-50">
</div>

<?=$footer?>
 
<?=$scriptGNRL?>

<script>
	
	$("#password").keyup(function() {
		var pass  = $("#password").val();
		var len   = (pass).length;

		if(len>6){
			$('#password').removeClass("uk-form-danger");
			$('#password').addClass("uk-form-success");
		}else{
			$('#password').removeClass("uk-form-success");
			$('#password').addClass("uk-form-danger");
		}
	});

	$(".fa-eye-slash").click(function(){
		var estatus = $(this).attr("data-estatus");
		if (estatus==0) {
			$("#login-pass1").prop("type","text");
			$(this).attr("data-estatus",1);
		}else{
			$("#login-pass1").prop("type","password");
			$(this).attr("data-estatus",0);
		};
	})

</script>

</body>
</html>