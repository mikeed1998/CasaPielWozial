<?php 
echo '
<div class="uk-width-1-1 margen-v-20 uk-text-left">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?seccion='.$seccion.'">'.$seccion.'</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=nuevo" class="color-red">Nuevo</a></li>
	</ul>
</div>
';		
?>

<div class="uk-width-1-1">
	<div class="uk-container uk-container-small">
		<form action="index.php" method="post" name="editar">
			<input type="hidden" name="nuevo" value="1">
			<input type="hidden" name="seccion" value="<?=$seccion?>">

			<div class="uk-margin">
				<label class="uk-text-capitalize" for="titulo">Titulo</label>
				<input type="text" class="uk-input" name="titulo" id="titulo" autofocus>
			</div>	
			<div class="uk-margin">
				<div class="margen-top-20">
					<label for="txt">Descripción</label>
					<textarea class="editor" name="txt" id="txt"></textarea>
					</div>
				</div>
			<div class="uk-margin uk-text-center">
				<a href="index.php?rand=<?=rand(1,1000)?>&seccion=<?=$seccion?>" class="uk-button uk-button-default uk-button-large" tabindex="10">Cancelar</a>					
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>

<div>
	<div id="buttons">
		<a href="#menu-movil" class="uk-icon-button uk-button-primary uk-box-shadow-large uk-hidden@l" uk-icon="icon:menu;ratio:1.4;" uk-toggle></a>
	</div>
</div>
