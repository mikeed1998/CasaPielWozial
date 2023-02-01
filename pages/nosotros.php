<!DOCTYPE html>
<?=$headGNRL?>
<body>
  
<?=$header?>

<?php  

	if ( $languaje == 'es') {
		$titleNosotros = "Nosotros";
		$titleVariedad = "Variedad";
		$titleTrabajo = "Trabajo";
		$nosotros = $about;
		$varie = $variedad;
		$trab = $trabajo;

	}elseif ( $languaje == 'en') {
		$titleNosotros = "About us";
		$titleVariedad= "Variety";
		$titleTrabajo = "Our work";
		$nosotros = $aboutEn;
		$varie = $variedadEn;
		$trab = $trabajoEn;
	}
?>

<div class="uk-container uk-container-large margin-top-10" style="min-height: 80vh;">
	<div class="uk-child-width-expand@s" uk-grid style="margin-left:0;">
		<div class="uk-width-auto zero">
		   <div> 
	        	<img data-src="../img/contenido/varios/<?= $nosotrosImg  ?>"   alt="" uk-img>
			</div>
		</div>
		<div class="uk-width-expand">
				
			<div class="margin-left-0" uk-grid>
				<!--div class="uk-width-1-1 uk-flex uk-flex-center">
					<div class="uk-cover-container">
					    <img data-src="../img/design/logo.png" width="450" height="180" alt="" uk-img>
					</div>
				</div-->
				<div class="uk-width-1-4 uk-padding-remove-left margin-top-80">
					<h2 class="uk-text-uppercase text-xxl color-primary negritas-medio">
						<?= $titleNosotros  ?>
					</h2>		
				</div>
				
				</div>
				<div class="uk-width-1-1 uk-text-justify uk-padding-remove-left text-11 margin-top-50" style="padding-right: 50px;">
					<?= $nosotros?>
				</div>
					
				<div class="larger-line-black margin-top-80"></div>
				
			</div>
			
		</div>
	</div>
</div>
<div class="uk-container uk-container-large bg-secondary" style="margin-bottom: 100px;">
	<div  uk-grid style="border: solid black;margin-left: 0">
		<div class="uk-width-1-3@m uk-padding-small" style="background:white; border: 15px solid black">
			<h2 class="uk-text-uppercase text-xxl color-primary negritas-medio uk-text-uppercase">
					<?= $titleVariedad  ?>
			</h2>
			<div class="uk-text-justify text-11">
				<div class="larger-line-black uk-margin-remove-top"></div>
				<?= $varie ?>
				<div class="larger-line-black"></div>
			</div>	
			
		</div>
		<div class="uk-width-1-3@m uk-padding-small" style="background:white; border: 15px solid black">
			<h2 class="uk-text-uppercase text-xxl color-primary negritas-medio  uk-text-uppercase">
				<?= $titleTrabajo  ?>
			</h2>
			<div class="uk-text-justify text-11">
				<div class="larger-line-black uk-margin-remove-top"></div>
				<?= $trab ?>
				<div class="larger-line-black	"></div>
			</div>	
		</div>
		<div class="uk-width-1-3@m remove-padding" style="margin-top:-40px;margin-bottom: -40px;">
			<div>
			    <img data-src="../img/contenido/varios/<?= $nosotrosImg2  ?>" style="min-height: 600px" alt="" uk-img>
			</div>
		</div>
	</div>
</div>	
<?=$footer?>

<?=$scriptGNRL?>

</body>
</html>