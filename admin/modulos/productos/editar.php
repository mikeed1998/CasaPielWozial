<?php
	$consulta = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
	$row_catalogo = $consulta -> fetch_assoc();
	$cat=$row_catalogo['categoria'];
	$marca=$row_catalogo['marca'];

	$CATEGORY = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $cat");
	$row_CATEGORY = $CATEGORY -> fetch_assoc();
	$catNAME=$row_CATEGORY['txt'];
	$catParentID=$row_CATEGORY['parent'];

	$CATEGORY = $CONEXION -> query("SELECT * FROM $seccioncat WHERE id = $catParentID");
	$row_CATEGORY = $CATEGORY -> fetch_assoc();
	$catParent=$row_CATEGORY['txt'];

// BREADCRUMB
	echo '
	<div class="uk-width-1-1 margin-v-20">
		<ul class="uk-breadcrumb uk-text-center">
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Productos</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=categorias">Líneas</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=catdetalle&cat='.$catParentID.'">'.$catParent.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=items&cat='.$cat.'">'.$catNAME.'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=detalle&id='.$id.'">'.$row_catalogo['titulo'].'</a></li>
			<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion=editar&id='.$id.'" class="color-red">Editar</a></li>
		</ul>
	</div>';
	

// CONTENIDO
	echo '
	<div class="uk-width-1-1 margin-top-20 uk-form">
		<div class="uk-container">
			<form action="index.php" method="post" enctype="multipart/form-data" name="datos" onsubmit="return checkForm(this);">
				<input type="hidden" name="editar" value="1">
				<input type="hidden" name="seccion" value="'.$seccion.'">
				<input type="hidden" name="subseccion" value="detalle">
				<input type="hidden" name="id" value="'.$id.'">
				<div uk-grid class="uk-grid-small uk-child-width-1-3@s">
					<div>
						<label for="sku">SKU</label>
						<input type="text" class="uk-input" name="sku" value="'.$row_catalogo['sku'].'" autofocus required>
					</div>
					<div>
						<label for="titulo">Modelo</label>
						<input type="text" class="uk-input" name="titulo" value="'.$row_catalogo['titulo'].'" required>
					</div>
					<div>
						<label for="material">Tipo de piel</label>
						<input type="text" class="uk-input" name="material" value="'.$row_catalogo['material'].'" >
					</div>
				</div>
				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="forro">Forro</label>
						<input type="text" class="uk-input" name="forro"value="'.$row_catalogo['forro'].'" >
					</div>
					<div>
						<label for="herraje">Herraje</label>
						<input type="text" class="uk-input" name="herraje" value="'.$row_catalogo['herraje'].'">
					</div>
				</div>

				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
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
											$estatus=(isset($cat) AND $cat==$row_CONSULTA1['id'])?'selected':'';
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
									$estatus=($row_catalogo['clasif']==$row_CONSULTA1['id'])?'selected':'';
									echo '
									<option value="'.$row_CONSULTA1['id'].'" '.$estatus.'>'.$row_CONSULTA1['txt'].'</option>';
								}
								echo '
							</select>
						</div>
					</div>
					<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="tipo">Tipo</label>
						<div>
							<select name="tipo" data-placeholder="Seleccione una" class="chosen-select uk-select" required>
								<option value=""></option>';
								$CONSULTATIPO = $CONEXION -> query("SHOW COLUMNS FROM productos WHERE field = 'tipo'");
								$row_CONSULTATIPO = $CONSULTATIPO -> fetch_assoc();
								
								foreach(explode("','",substr($row_CONSULTATIPO['Type'],6,-2)) as $option) {
									$estatus=($row_catalogo['tipo'] == $option)?'selected':'';
									echo '
									<option value="'.$option.'" '.$estatus.'>'.$option.'</option>';
								}
								echo '
							</select>
						</div>
					</div>
				</div>
				</div>

				<div class="uk-margin">
					<label for="txt">Descripción</label>
					<textarea class="editor" name="txt" id="txt">'.$row_catalogo['txt'].'</textarea>
				</div>

				<h2>Textos en Ingles</h2>
				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="material_en">Tipo de piel</label>
						<input type="text" class="uk-input" name="material_en" value="'.$row_catalogo['material_en'].'">
					</div>
				</div>

				<div uk-grid class="uk-grid-small uk-child-width-1-2@s">
					<div>
						<label for="forro_en">Forro</label>
						<input type="text" class="uk-input" name="forro_en" value="'.$row_catalogo['forro_en'].'">
					</div>
					<div>
						<label for="herraje_en">Herraje</label>
						<input type="text" class="uk-input" name="herraje_en" value="'.$row_catalogo['herraje_en'].'">
					</div>
				</div>
				<div class="uk-margin">
					<label for="txt_en">Descripción</label>
					<textarea class="editor" name="txt_en" id="txt">'.$row_catalogo['txt_en'].'</textarea>
				</div>
			

				<div class="uk-margin">
					<label for="title">Título google</label>
					<input type="text" class="uk-input" name="title" value="'.$row_catalogo['title'].'">
				</div>
				<div class="uk-margin">
					<label for="metadescription">Descripción google</label>
					<textarea class="uk-textarea" name="metadescription">'.$row_catalogo['metadescription'].'</textarea>
				</div>
				<div class="uk-margin uk-text-center">
					<a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="uk-button uk-button-default uk-button-large" tabindex="10">Cancelar</a>					
					<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>

			</form>
		</div>
	</div>
	';

