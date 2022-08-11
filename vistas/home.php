<div class="container is-fluid">
	<h1 class="title">Hola</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>

<div class="notification is-danger is-light">

	<?php 
		
		require_once "./php/main.php";
		
		#Comparacion stock#
		function stock_bajo(){

			
			
			$consulta_nombre= "SELECT producto_nombre FROM producto WHERE producto_stock < 10";

			
			$consultaStock= "SELECT producto_stock FROM producto";
			$consultaStockm = "SELECT stock_minimo FROM producto";
			$conexion = conexion();
			$consultaNombre = $conexion->query($consulta_nombre);
			$fila = $consultaNombre->fetchAll();
			//stock
			$data = $conexion->query($consultaStock);
			$data = $data->fetchAll();
			//stock minimo
			$data2 = $conexion->query($consultaStockm);
			$data2 = $data2->fetchAll();
			

			if ($data = $data2) {}


				echo '
				<div class="table-container">
					<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
						<thead>
							<tr class="has-text-centered">
								<th>#</th>
								<th>Producto de Bajo stock</th>
								<th colspan="2">Opciones</th>
							</tr>
						</thead>
						<tbody>
				';

		
			
			
		}
		return stock_bajo();

	?>	

</div>