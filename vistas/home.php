<div class="container is-fluid">
	<h1 class="title">Hola</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>

<div class="notification is-danger is-light">

	<?php 
		
		require_once "./php/main.php";
		#Comparacion stock#
		function stock_bajo(){
			$comparacionStock="producto.producto_stock, producto.producto_stockm" ;
			$consulta_nombre= "SELECT producto_nombre FROM producto WHERE producto_stock < 10" ;
			$consultaStock= "SELECT producto_stock FROM producto";
			$consultaStockm = "SELECT stock_minimo FROM producto";
			$conexion = conexion();
			$consultaNombre = $conexion->query($consulta_nombre);
			$consultaNombre = $consultaNombre->fetchAll();
			$data = $conexion->query($consultaStock);
			$data = $data->fetchAll();
			$data2 = $conexion->query($consultaStockm);
			$data2 = $data2->fetchAll();

			if ($data = $data2) {
				print $consultaNombre . "El stock de tu producto es bajo, realiza un pedido." ;
			}
		}
		return stock_bajo();

	?>	

</div>