<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$cantidad=limpiar_cadena($_POST['cantidad']);
    $fecha=limpiar_cadena($_POST['fecha_salida']);
    $producto=limpiar_cadena($_POST['producto_id']);
    $producto_stock=limpiar_cadena($_POST['producto_stock']);
	
	/*== Verificando campos obligatorios ==*/
    if($cantidad=="" || $fecha=="" ){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    
    if(verificar_datos("[0-9]{1,25}",$cantidad)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CANTIDAD no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

	/*== Guardando datos ==*/
    $guardar_salida=conexion();
    $guardar_salida=$guardar_salida->prepare
    ("INSERT INTO salidas( id_prod, fecha_salida, cantidad) 

    VALUES(:id_prod,:fecha,:cantidad)");

    $marcadores=[
        ":id_prod"=>$producto,
        ":fecha"=>$fecha,
        ":cantidad"=>$cantidad
    ];

    $guardar_salida->execute($marcadores);

    if($guardar_salida->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO REGISTRADO!</strong><br>
                Se ha registrado la salida del producto con exito!
            </div>
        ';
    }else{

    
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la salida del producto, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_stock=conexion();
    $actualizar_stock=$actualizar_stock->prepare
    ("UPDATE producto SET  producto_stock =($producto_stock - $cantidad) WHERE producto_id = $producto");

    $marcadores=[
        ":id_prod"=>$producto,
        ":fecha"=>$fecha,
        ":cantidad"=>$cantidad
    ];

    $actualizar_stock->execute($marcadores);

    $guardar_salida=null;