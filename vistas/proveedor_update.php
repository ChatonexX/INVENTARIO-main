<div class="container is-fluid mb-6">
	<h1 class="title">Proveedores</h1>
	<h2 class="subtitle">Actualizar proveedor</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./controlador/main.php";

		$id = (isset($_GET['supplier_id_up'])) ? $_GET['supplier_id_up'] : 0;

		/*== Verificando proveedor ==*/
    	$check_proveedor=conexion();
    	$check_proveedor=$check_proveedor->query("SELECT * FROM proveedor WHERE id_prov='$id'");

        if($check_proveedor->rowCount()>0){
        	$datos=$check_proveedor->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./controlador/proveedor_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="id_prov" value="<?php echo $datos['id_prov']; ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="nombre_proveedor" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['nombre_proveedor']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Celular</label>
				  	<input class="input" type="text" name="celular" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" value="<?php echo $datos['celular']; ?>" >
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
		$check_categoria=null;
	?>
</div>