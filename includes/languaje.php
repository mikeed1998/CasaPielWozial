<?php
if (isset($_GET['languaje'])) {
  $languaje=$_GET['languaje'];
}else{
	$languaje='es';
}

// $SITELANGUAJE = $CONEXION -> query("SELECT seccion,$languaje,variable FROM traduccion");
// while($rowSITELANGUAJE = $SITELANGUAJE -> fetch_assoc()){
// ${$rowSITELANGUAJE['seccion'].'_'.$rowSITELANGUAJE['variable']}=$rowSITELANGUAJE[$languaje];
// }
//mysqli_free_result($SITELANGUAJE);
?>