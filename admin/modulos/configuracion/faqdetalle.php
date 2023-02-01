<?php
$faq = $CONEXION -> query("SELECT * FROM faq WHERE id = $id");
$row_catalogo = $faq -> fetch_assoc();

echo '
<div class="uk-width-1-1 uk-grid-small uk-flex uk-flex-center" uk-grid>
	<div class="uk-container uk-container-small">
		<div class="padding-v-20 uk-text-right">
			<a href="index.php?rand='.rand(1,99999).'&seccion='.$seccion.'&subseccion=faqnuevo" id="add-button" class="uk-button uk-button-primary"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
		</div>
		<form action="index.php" method="post" name="datos" onsubmit="return checkForm(this);">
			<input type="hidden" name="editar" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">
			<input type="hidden" name="subseccion" value="'.$subseccion.'">
			<input type="hidden" name="id" value="'.$id.'">
			<div class="uk-margin">
				<label for="pregunta">Pregunta</label>
				<input type="text" class="uk-input" name="pregunta" value="'.$row_catalogo['pregunta'].'" autofocus>
			</div>
			<div class="uk-margin">
				<label for="respuesta">Respuesta</label>
				<textarea class="editor" name="respuesta">'.$row_catalogo['respuesta'].'</textarea>
			</div>
			<div class="uk-margin uk-text-center">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>

';
