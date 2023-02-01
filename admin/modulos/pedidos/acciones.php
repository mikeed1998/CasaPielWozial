<?php 
//%%%%%%%%%%%%%%%%%%%%%%%%%%    Borrar pedido 
	if(isset($_REQUEST['borrarPedido'])){
		$CONSULTA = $CONEXION -> query("SELECT * FROM pedidosdetalle WHERE pedido = $id");
		while($row_CONSULTA = $CONSULTA -> fetch_assoc()){
			if ($_GET['incorporar']==1) {
				$item=$row_CONSULTA['item'];
				$existenciasAgregar=$row_CONSULTA['cantidad'];
				$CONSULTA1 = $CONEXION -> query("SELECT * FROM productosexistencias WHERE id = $item");
				while($row_CONSULTA1 = $CONSULTA1 -> fetch_assoc()){
					$existenciasNuevas=$row_CONSULTA1['existencias']+$existenciasAgregar;
					$actualizar = $CONEXION->query("UPDATE productosexistencias SET existencias = $existenciasNuevas WHERE id = $item");
				}
			}
		}

		if($borrar = $CONEXION->query("DELETE FROM pedidos WHERE id = $id")){
			$borrar = $CONEXION->query("DELETE FROM pedidosdetalle WHERE pedido = $id");
			$borrar = $CONEXION->query("DELETE FROM ipn WHERE pedido = $id");
			$exito='success';
			$legendSuccess.="<br>Pedido eliminado";
		}else{
			$fallo='danger';  
			$legendFail.="<br>No se pudo eliminar";
		}
	} 

 

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Estatus 
	if (isset($_POST['estatuschange'])) {
		include '../../../includes/connection.php';

		$id = $_POST['id'];
		$estatus = $_POST['estatus'];

		if($actualizar = $CONEXION->query("UPDATE pedidos SET estatus = $estatus WHERE id = $id")){
			$mensajeClase='success';
			$mensajeIcon='check';
			$mensaje='Guardado';
		}else{
			$mensajeClase='danger';
			$mensajeIcon='ban';
			$mensaje='No se pudo guardar';
		}
		echo '<div class="uk-text-center color-white bg-'.$mensajeClase.' padding-10 text-lg"><i class="fa fa-'.$mensajeIcon.'"></i> &nbsp; '.$mensaje.'</div>';		
	}

	if (file_exists('error_log')) {
		unlink('error_log');
	}
