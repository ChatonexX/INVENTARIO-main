<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Nuevo producto</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		require_once "./controlador/main.php";
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./controlador/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
		<div class="columns">
			<div class="column">
			  <div class="control">
				  <label>Nombre</label>
					<input class="input is-info input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
			  </div>

		  	<div class="colums">
		    	<div class="control">
					<label>Descripcion</label>
				  	<input class="input is-info input" type="text" name="producto_descripcion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input is-info input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Stock</label>
				  	<input class="input is-info input" type="text" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required >
				</div>
		  	</div>
			  <div class="column">
		    	<div class="control">
					<label>Stock Mínimo</label>
				  	<input class="input is-info input" type="text" name="stock_minimo" pattern="[0-9]{1,25}" maxlength="25" required >
				</div>
		  	</div>
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class=" select is-info select is-rounded">
				  	<select name="producto_categoria" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$categorias=conexion();
    						$categorias=$categorias->query("SELECT * FROM categoria");
    						if($categorias->rowCount()>0){
    							$categorias=$categorias->fetchAll();
    							foreach($categorias as $row){
    								echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
				    			}
				   			}
				   			$categorias=null;
				    	?>
				  	</select>
				</div>
		  	</div>


		<div class="column">
				<label>Proveedor</label><br>
		    	<div class="select is-info select is-rounded">
				  	<select name="proveedor" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$proveedores=conexion();
    						$proveedores=$proveedores->query("SELECT * FROM proveedor");
    						if($proveedores->rowCount()>0){
    							$proveedores=$proveedores->fetchAll();
    							foreach($proveedores as $row){
    								echo '<option value="'.$row['id_prov'].'" >'.$row['nombre_proveedor'].'</option>';
				    			}
				   			}
				   			$proveedores=null;
				    	?>
				  	</select>
				</div>
		  	</div>

			
		</div>
		<div class="columns">
			<div class="column">
				<label>Foto o imagen del producto</label><br>
				<div class="file is-small has-name">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-outlined is-focused">Guardar</button>
		</p>
	</form>
</div>