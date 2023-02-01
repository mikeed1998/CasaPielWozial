<?php
echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'">Configuración</a></li>
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$subseccion.'" class="color-red">'.$subseccion.'</a></li>
	</ul>
</div>
';
?>

<div class="uk-width-1-1">
	<div class="uk-container">
		<div class="padding-v-20 uk-text-right">
			<a href="index.php?rand=<?=rand(1,99999)?>&seccion=<?=$seccion?>&subseccion=faqnuevo" id="add-button" class="uk-button uk-button-primary"><i uk-icon="icon: plus;ratio:1.4"></i> &nbsp; Nuevo</a>
		</div>
		<table class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-middle">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th width="100px"></th>
				</tr>
			</thead>
			<tbody class="sortable" data-tabla="faq">
			<?php
			$faq = $CONEXION -> query("SELECT * FROM faq ORDER BY orden");
			while ($row_faq = $faq -> fetch_assoc()) {

				$prodID=$row_faq['id'];

				$link='index.php?seccion='.$seccion.'&subseccion=faqdetalle&id='.$row_faq['id'];

				echo '
				<tr id="'.$row_faq['id'].'">
					<td>
						<a href="'.$link.'">'.$row_faq['pregunta'].'</a>
					</td>
					<td class="uk-text-right">
						<a href="'.$link.'" class="uk-icon-button uk-button-primary" uk-icon="icon:pencil"></i></a>
						<a href="javascript:eliminaProd(id='.$row_faq['id'].')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash"></i></a> 
					</td>
				</tr>';
			$picROW='';
			}
			?>

			</tbody>
		</table>
	</div>
</div>


<?php

$scripts='
	// Eliminar producto
	function eliminaProd () { 
		var statusConfirm = confirm("Realmente desea eliminar esta Pregunta?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&borrarFaq&id="+id);
		} 
	};'
?>