<div class="uk-width-1-1 uk-grid-small uk-flex uk-flex-center" uk-grid>
	<div class="uk-container uk-container-small">
		<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">
			<input type="hidden" name="nuevo" value="1">
			<input type="hidden" name="seccion" value="<?=$seccion?>">
			<input type="hidden" name="frame" value="faqdetalle">
		
			<div class=" uk-margin">
				<label for="pregunta">Pregunta</label>
				<input type="text" class="uk-input" name="pregunta" autofocus>
			</div>
			<div class=" uk-margin">
				<label for="respuesta">Respuesta</label>
				<textarea class="editor uk-width-1-1" name="respuesta"></textarea>
			</div>
			<div class="uk-width-1-1 uk-text-center uk-margin">
				<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
			</div>
		</form>
	</div>
</div>


