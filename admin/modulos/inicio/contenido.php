<?php
$subsecciones[] = array(
	  'title' => 'Sección Hombres',
 'subseccion' => 'bg-superior',
	   'icon' => 'images');

$subsecciones[] = array(
	  'title' => 'Sección Mujer',
 'subseccion' => 'bg-inferior',
	   'icon' => 'images');

$subsecciones[] = array(
	  'title' => 'Sección Cuidados',
 'subseccion' => 'bg-cuidados',
	   'icon' => 'medkit');

$subsecciones[] = array(
	  'title' => 'Sección Productos',
 'subseccion' => 'bg-productos',
	   'icon' => 'shopping-cart');

echo '
<div class="uk-width-auto@m margin-top-20">
	<ul class="uk-breadcrumb uk-text-capitalize">
		<li><a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'" class="color-red">'.$seccion.'</a></li>
	</ul>
</div>


<div class="uk-width-1-1">
	<div class="uk-container">
		<div uk-grid class="uk-flex-center" style="margin-top: 100px;">';


		foreach ($subsecciones as $key => $value) {

			echo '
			<div class="uk-width-auto">
				<a href="index.php?rand='.rand(1,1000).'&seccion='.$seccion.'&subseccion='.$value['subseccion'].'">
					<div class="uk-card uk-card-default uk-flex uk-flex-center uk-flex-middle uk-text-center uk-text-capitalize" style="width: 250px;height: 250px;">
						<div>
							<i class="fa fa-3x fa-'.$value['icon'].'"></i>
							<br><br>
							'.$value['title'].'
						</div>
					</div>
				</a>
			</div>';

		}	

echo '
		</div>
	</div>
</div>';



