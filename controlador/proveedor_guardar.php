<?php
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
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre_proveedor)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


   /* if(verificar_datos(" [0-9]{1,10}",$celular)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CELULAR no coincide con el formato solicitado
            </div>
        ';
        exit();
    }*/

    /*== Verificando n_proveedor ==*/
    $check_nombre_proveedor=conexion();
    $check_nombre_proveedor=$check_nombre_proveedor->query("SELECT nombre_proveedor FROM proveedor WHERE nombre_proveedor='$nombre_proveedor'");

    if($check_nombre_proveedor->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PROVEEDOR ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre_proveedor=null;


    /*== Verificando celular ==*/
    $check_celular=conexion();
    $check_celular=$check_celular->query("SELECT celular FROM proveedor WHERE celular='$celular'");
    if($check_celular->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CELULAR ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_celular=null;


	/*== Guardando datos ==*/
    $guardar_proveedor=conexion();
    $guardar_proveedor=$guardar_proveedor->prepare("INSERT INTO proveedor(nombre_proveedor, celular) VALUES(:nombre_proveedor, :celular)");

    $marcadores=[
        ":nombre_proveedor"=>$nombre_proveedor,
        ":celular"=>$celular

    ];

    $guardar_proveedor->execute($marcadores);

    if($guardar_proveedor->rowCount()==1){
        echo '
            <div class="notification is-success is-light">
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
    $guardar_proveedor=null;