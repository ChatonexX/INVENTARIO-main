<?php
	/*== Almacenando datos ==*/
    $departure_del=limpiar_cadena($_GET['departure_id_del']);

    /*== Verificando usuario ==*/
    $check_salida=conexion();
    $check_salida=$check_salida->query("SELECT * FROM salidas WHERE id_salidas='$departure_del'");
    
    if($check_salida->rowCount()==1){

        

            $eliminar_salida=conexion();
            $eliminar_salida=$eliminar_salida->prepare("DELETE FROM salidas WHERE id_salidas=:id");
            $eliminar_salida->execute([":id"=>$departure_del]);


    	    if($eliminar_salida->rowCount()==1){

		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡salida ELIMINADO!</strong><br>
		                La salida se eliminó con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la salida, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_salida=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                    La salida no existe
	            </div>
	        ';
    	}

    $check_salida=null;