<div class="container is-fluid mb-6">
    <h1 class="title">Salidas</h1>
    <h2 class="subtitle">Lista de productos vendidos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./controlador/main.php";

        # Eliminar producto #
        if(isset($_GET['departure_id_del'])){
            require_once "./controlador/salidas_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $id_salidas = (isset($_GET['id_salidas'])) ? $_GET['id_salidas'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=departures_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador producto #
        require_once "./controlador/salidas_lista.php";
    ?>
</div>