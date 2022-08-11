<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['id_prov']);


    /*== Verificando proveedor ==*/
	$check_proveedor=conexion();
	$check_proveedor=$check_proveedor->query("SELECT * FROM proveedor WHERE id_prov='$id'");

    if($check_proveedor->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El proveedor no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_proveedor->fetch();
    }
    $check_proveedor=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['nombre_proveedor']);
    $celular=limpiar_cadena($_POST['celular']);


    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if($celular!=""){
    	if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$celular)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El CELULAR no coincide con el formato solicitado
	            </div>
	        ';
	        exit();
	    }
    }


    /*== Verificando nombre ==*/
    if($nombre!=$datos['nombre_proveedor']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT nombre_proveedor FROM proveedor WHERE nombre_proveedor='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }


    /*== Actualizar datos ==*/
    $actualizar_proveedor=conexion();
    $actualizar_proveedor=$actualizar_proveedor->prepare("UPDATE proveedor SET nombre_proveedor=:nombre,celular=:celular WHERE id_prov=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":celular"=>$celular,
        ":id"=>$id
    ];

    if($actualizar_proveedor->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PROVEEDOR ACTUALIZADO!</strong><br>
                El proveedor se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar proveedor, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_proveedor=null;