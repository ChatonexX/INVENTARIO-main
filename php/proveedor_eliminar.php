<?php
	/*== Almacenando datos ==*/
    $supplier_id_del=limpiar_cadena($_GET['supplier_id_del']);

    /*== Verificando usuario ==*/
    $check_proveedor=conexion();
    $check_proveedor=$check_proveedor->query("SELECT id_prov FROM proveedor WHERE id_prov='$supplier_id_del'");
    
    if($check_proveedor->rowCount()==1){

    	$check_productos=conexion();
    	$check_productos=$check_productos->query("SELECT id_prov FROM producto WHERE id_prov='$supplier_id_del' LIMIT 1");

    	if($check_productos->rowCount()<=0){

    		$eliminar_proveedor=conexion();
	    	$eliminar_proveedor=$eliminar_proveedor->prepare("DELETE FROM proveedor WHERE id_prov =:id");

	    	$eliminar_proveedor->execute([":id"=>$supplier_id_del]);

	    	if($eliminar_proveedor->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡PROVEEDOR ELIMINADO!</strong><br>
		                Los datos del proveedor se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el proveedor, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_proveedor=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar el proveedor ya que tiene productos asociados
	            </div>
	        ';
    	}
    	$check_productos=null;
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PROVEEDOR que intenta eliminar no existe
            </div>
        ';
    }
    $check_proveedor=null;