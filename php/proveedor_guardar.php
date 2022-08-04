<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$nombre_proveedor=limpiar_cadena($_POST['nombre_proveedor']);
	$celular=limpiar_cadena($_POST['celular']);

	/*== Verificando campos obligatorios ==*/
    if($nombre_proveedor=="" || $celular==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$nombre_proveedor)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CODIGO de BARRAS no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$celular)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando n_proveedor ==*/
    $check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT nombre_proveedor FROM proveedor WHERE nombre_proveedor='$nombre_proveedor'");
    if($check_codigo->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PROVEEDOR ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_codigo=null;


    /*== Verificando celular ==*/
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT celular FROM proveedor WHERE celular='$celular'");
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


	/*== Guardando datos ==*/
    $guardar_nombre_p=conexion();
    $guardar_nombre_p=$guardar_nombre_p->prepare("INSERT INTO proveedor VALUES(:nombre_proveedor, :celular)");

    $marcadores=[
        ":nombre_proveedor"=>$nombre_proveedor,
        ":celular"=>$celular,

    ];

    $guardar_nombre_p->execute($marcadores);

    if($guardar_nombre_p->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PROVEEDOR REGISTRADO!</strong><br>
                El proveeedor se registro con exito
            </div>
        ';
    }else{

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el proveedor, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_nombre_p=null;