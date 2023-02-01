<?php
// BREADCRUMB
	if (isset($_GET['cat'])) {
		$CATEGORIAS = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $cat");
		$row_CATEGORIAS = $CATEGORIAS -> fetch_assoc();
		$catNAME=$row_CATEGORIAS['txt'];
		$parent=$row_CATEGORIAS['parent'];
		$CATPARENT = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $parent");
		$row_CATPARENT = $CATPARENT -> fetch_assoc();
		$parentName=$row_CATPARENT['txt'];
		echo '
		<div class="uk-width-1-1 margin-v-20 uk-text-left">
			<ul class="uk-breadcrumb uk-text-capitalize">
				<li><a href="index.php?seccion='.$seccion.'">Productos</a></li>
				<li><a href="index.php?seccion='.$seccion.'&subseccion=categorias">Líneas</a></li>
				<li><a href="index.php?seccion='.$seccion.'&subseccion=catdetalle&cat='.$parent.'">'.$parentName.'</a></li>
				<li><a href="index.php?seccion='.$seccion.'&subseccion=items&cat='.$cat.'">'.$catNAME.'</a></li>
				<li><a href="index.php?seccion='.$seccion.'&subseccion=nuevo&cat='.$cat.'" class="color-red">Nuevo</a></li>
			</ul>
		</div>';
	}else{
		echo '
		<div class="uk-width-1-1 margin-v-20 uk-text-left">
			<ul class="uk-breadcrumb uk-text-capitalize">
				<li><a href="index.php?seccion='.$seccion.'">Productos</a></li>
				<li><a href="index.php?seccion='.$seccion.'&subseccion=nuevo" class="color-red">Nuevo</a></li>
			</ul>
		</div>';
	}

// DATOS
	echo '
	<div class="uk-width-1-1 margin-top-20 uk-form">
		<div class="uk-container">
			<form action="index.php" method="post" enctype="multipart/form-data" name="datos" onsubmit="return checkForm(this);">
				<input type="hidden" name="nuevo" value="1">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="subseccion" value="'.$subseccion.'">
				<div uk-grid class="uk-grid-small uk-child-width-1-3@s">
					<div>
						<label for="sku">SKU</label>
						<input type="text" class="uk-input" name="sku" autofocus required>
					</div>
					<div>
						<label for="titulo">Modelo</label>
						<input type="text" class="uk-input" name="titulo" required>
					</div>
					<div>
						<label for="material">Tipo de piel</label>
						<input type="text" class="uk-input" name="material" >
					</div>
				</div>

				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="forro">Forro</label>
						<input type="text" class="uk-input" name="forro" >
					</div>
					<div>
						<label for="herraje">Herraje</label>
						<input type="text" class="uk-input" name="herraje" >
					</div>
				</div>

				<div uk-grid class="uk-grid-small uk-child-width-1-3@s">
					<div>
						<label for="categoria">Línea y sublínea</label>
						<div>
							<select name="categoria" data-placeholder="Seleccione una" class="chosen-select uk-select" required>
								<option value=""></option>';
									$CONSULTA = $CONEXION -> query("SELECT * FROM productoscat WHERE parent = 0 ORDER BY txt");
									while ($row_CONSULTA = $CONSULTA -> fetch_assoc()) {
										$parentId=$row_CONSULTA['id'];
										$parentTxt=$row_CONSULTA['txt'];
										echo '
											<optgroup label="'.$parentTxt.'">';
										$CONSULTA1 = $CONEXION -> query("SELECT * FROM productoscat WHERE parent = $parentId ORDER BY txt");
										while ($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
											if (isset($cat) AND $cat==$row_CONSULTA1['id']) {
												$estatus='selected';
											}else{
												$estatus='';
											}
											echo '
											<option value="'.$row_CONSULTA1['id'].'" '.$estatus.'>'.$row_CONSULTA1['txt'].'</option>';
										}
										echo '
											</optgroup>';
									}
									echo '
							</select>
						</div>
					</div>

					<div>
						<label for="clasif">Clasificación</label>
						<div>
							<select name="clasif" data-placeholder="Seleccione una" class="chosen-select uk-select" required>
								<option value=""></option>';
								$CONSULTA1 = $CONEXION -> query("SELECT * FROM productosclasif ORDER BY txt");
								while ($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()) {
									echo '
									<option value="'.$row_CONSULTA1['id'].'" '.$estatus.'>'.$row_CONSULTA1['txt'].'</option>';
								}
								echo '
							</select>
						</div>
					</div>
					<div>
						<label for="tipo">Tipo</label>
						<div>
							<select name="tipo" data-placeholder="Seleccione una" class="chosen-select uk-select" required>
								<option value=""></option>';
								$CONSULTATIPO = $CONEXION -> query("SHOW COLUMNS FROM productos WHERE field = 'tipo'");
								$row_CONSULTATIPO = $CONSULTATIPO -> fetch_assoc();
								
								foreach(explode("','",substr($row_CONSULTATIPO['Type'],6,-2)) as $option) {
									echo '
									<option value="'.$option.'">'.$option.'</option>';
								}
								echo '
							</select>
						</div>
					</div>
				</div>
					
				<div class="uk-margin">
					<label for="txt">Descripción</label>
					<textarea class="editor" name="txt" id="txt"></textarea>
				</div>
				<h2>Textos en Ingles</h2>
				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="titulo_en">Modelo</label>
						<input type="text" class="uk-input" name="titulo_en" required>
					</div>
					<div>
						<label for="material_en">Tipo de piel</label>
						<input type="text" class="uk-input" name="material_en" >
					</div>
				</div>

				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="forro_en">Forro</label>
						<input type="text" class="uk-input" name="forro_en" >
					</div>
					<div>
						<label for="herraje_en">Herraje</label>
						<input type="text" class="uk-input" name="herraje_en" >
					</div>
				</div>
				<div class="uk-margin">
					<label for="txt_en">Descripción</label>
					<textarea class="editor" name="txt_eng" id="txt"></textarea>
				</div>
			

				<div class="uk-margin">
					<label for="title">Título google</label>
					<input type="text" class="uk-input" name="title">
				</div>
				<div class="uk-margin">
					<label for="metadescription">Descripción google</label>
					<textarea class="uk-textarea" name="metadescription"></textarea>
				</div>
				<div class="uk-margin uk-text-center">
					<a href="index.php?seccion='.$seccion.'" class="uk-button uk-button-default uk-button-large" tabindex="10">Cancelar</a>
					<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>

			</form>
		</div>
	</div>
	';