
<div class="uk-width-1-1">
	<div class="uk-container">
		<div uk-grid class="uk-flex-center" style="margin-top: 100px;">
		<?php
		foreach ($navegacion as $key => $value) {
			echo '
			<div class="uk-width-auto">
				<a href="index.php?rand='.rand(1,1000).'&seccion='.$value['seccion'].'">
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
		?>

		</div>
	</div>
</div>

