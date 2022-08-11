<div class="container is-fluid mb-6">
	<h1 class="title">Salidas</h1>
	<h2 class="subtitle">Registrar salida del producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./controlador/main.php";

		$id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;

		/*== Verificando producto ==*/
    	$check_producto=conexion();
    	$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

        if($check_producto->rowCount()>0){
        	$datos=$check_producto->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>
	
	<h2 class="title has-text-centered"><?php echo $datos['producto_nombre']; ?></h2>

	<form action="./controlador/salidas_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="producto_id" value="<?php echo $datos['producto_id']; ?>" required >
		<input type="hidden" name="producto_stock" value="<?php echo $datos['producto_stock']; ?>" required >

		<div class="columns">

		  	<div class="column">
		    	<div class="control">
					<label>Cantidad</label>
				  	<input class="input" type="text" name="cantidad" pattern="[0-9]{1,25}" maxlength="25" required value="<?php echo $datos['producto_stock']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Fecha</label>
				  	<input class="input" type="date" name="fecha_salida" pattern="" maxlength="25" required value="" >
				</div>
		  	</div>
		  	
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_producto=null;
	?>
</div>