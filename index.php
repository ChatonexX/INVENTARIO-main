<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "./inc/head.php"; ?>
    </head>
    <body>
        <?php
        class paginaPrincipal 
        {

            public function vistas () 
            {

                //si la variable $_GET no esta definida o esta vacia  la variable nos va a mantener en el login

                if(!isset($_GET['vista']) || $_GET['vista']==""){
                    $_GET['vista']="login";
                   /* $_GET['vista']="user_new";*/
                }
                    /***
                     * Preguntar si la variable GET coincide con una vista
                     * isfile va a comprobar si existe un archivo en una carpeta
                     */

                if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!="login" && $_GET['vista']!="404"){
        
                    /*== Cerrar sesion ==*/
                   if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                        include "./vistas/logout.php";
                        exit();
                    }
        
                    include "./inc/navbar.php";
        
                    include "./vistas/".$_GET['vista'].".php";
        
                    include "./inc/script.php";
                    
        
                }else{
                    if($_GET['vista']=="login" ||$_GET['vista']=="user_new" ){
                        include "./vistas/login.php";
                        
                        include "./vistas/user_new.php";
                    }else{
                        include "./vistas/404.php";
                    }
                }
            }
        }

            $pagina_principal= new paginaPrincipal();
            $pagina_principal->vistas(); 
        ?>

    
    </body>
</html>