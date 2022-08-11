<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$nombre=limpiar_cadena($_POST['producto_nombre']);
    $descripcion=limpiar_cadena($_POST['producto_descripcion']);
	$precio=limpiar_cadena($_POST['producto_precio']);
	$stock=limpiar_cadena($_POST['producto_stock']);
    $stockm=limpiar_cadena($_POST['stock_minimo']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);
    $proveedor=limpiar_cadena($_POST['proveedor']);


	/*== Verificando campos obligatorios ==*/
    if($nombre=="" || $descripcion=="" || $precio=="" || $stock=="" || $stockm=="" || $categoria=="" ||$proveedor==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$descripcion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DESCRIPCION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9]{1,25}",$stock)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El STOCK no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*stock minimo*/
    if(verificar_datos("[0-9]{1,25}",$stockm)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El STOCK MINIMO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando descripcion ==*/
    $check_descripcion=conexion();
    $check_descripcion=$check_descripcion->query("SELECT producto_descripcion FROM producto WHERE producto_descripcion='$descripcion'");
    if($check_descripcion->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La descripcion ingresada ya se encuentra registrada, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_descripcion=null;


    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if($check_categoria->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria=null;


    /*== Verificando proveedor ==*/
    $check_proveedor=conexion();
    $check_proveedor=$check_proveedor->query("SELECT id_prov FROM proveedor WHERE id_prov='$proveedor'");
    if($check_proveedor->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El proveedor seleccionado no existe
            </div>
        ';
        exit();
    }
    $check_proveedor=null;


    /* Directorios de imagenes */
	$img_dir='../img/producto/';


	/*== Comprobando si se ha seleccionado una imagen ==*/
    //Files es una variable de subida de ficheros HTTP//
	if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){

        /* Creando directorio de imagenes */
        if(!file_exists($img_dir)){
            /* mkdir creara una carpeta */
            if(!mkdir($img_dir,0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Error al crear el directorio de imagenes
                    </div>
                ';
                exit();
            }
        }

		/* Comprobando formato de las imagenes */
		if(mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name'])!="image/png"){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado es de un formato que no está permitido
	            </div>
	        ';
	        exit();
		}


		/* Comprobando que la imagen no supere el peso permitido */
		if(($_FILES['producto_foto']['size']/1024)>3072){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
			exit();
		}


		/* extencion de las imagenes */
        //Verifica si un archivo tiene formano png,jpg,etc//
		switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
			case 'image/jpeg':
			  $img_ext=".jpg";
			break;
			case 'image/png':
			  $img_ext=".png";
			break;
		}

		/* Cambiando permisos al directorio y usuarios */
		chmod($img_dir, 0777);

		/* Nombre de la imagen */
		$img_nombre=renombrar_fotos($nombre);

		/* Nombre final de la imagen */
		$foto=$img_nombre.$img_ext;

		/* Moviendo imagen al directorio */
		if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir.$foto)){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
			exit();
		}

	}else{
		$foto="";
	}


	/*== Guardando datos ==*/
    $guardar_producto=conexion();
    $guardar_producto=$guardar_producto->prepare
    ("INSERT INTO producto(producto_nombre,producto_descripcion,producto_precio,
    producto_stock,stock_minimo,producto_foto,categoria_id,usuario_id,id_prov) 

    VALUES(:nombre,:descripcion,:precio,:stock,:stockm,:foto,:categoria,:usuario, :proveedor)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":descripcion"=>$descripcion,
        ":precio"=>$precio,
        ":stock"=>$stock,
        ":stockm"=>$stockm,
        ":foto"=>$foto,
        ":categoria"=>$categoria,
        ":proveedor"=>$proveedor,
        ":usuario"=>$_SESSION['id']
    ];

    $guardar_producto->execute($marcadores);

    if($guardar_producto->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO REGISTRADO!</strong><br>
                El producto se registro con exito
            </div>
        ';
    }else{

    	if(is_file($img_dir.$foto)){
			chmod($img_dir.$foto, 0777);
			unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_producto=null;