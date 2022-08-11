<div class="container is-fluid mb-6">
    <h1 class="title">Bajo Stock</h1>
    <h2 class="subtitle">Lista de bajo stock</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./controlador/main.php";

        # Eliminar categoria #
        if(isset($_GET['category_id_del'])){
            require_once "./controlador/categoria_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=stock_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador categoria #
        require_once "./controlador/bajo_stock_lista.php";
    ?>
</div>