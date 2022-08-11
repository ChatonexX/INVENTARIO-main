<?php
			$consultaStock= "SELECT producto_stock FROM producto";
			$consultaStockm = "SELECT stock_minimo FROM producto";
			$conexion = conexion();
			$data = $conexion->query($consultaStock);
			$data = (int)$data->fetchAll();
			//stock minimo
			$data2 = $conexion->query($consultaStockm);
			$data2 = (int)$data2->fetchAll();


	
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	

        $consulta_datos= "SELECT producto_nombre, producto_stock FROM producto WHERE producto_stock < 10 ORDER BY nombre_proveedor ASC LIMIT $inicio,$registros";

			
			/*$consultaStock= "SELECT producto_stock FROM producto";
			$consultaStockm = "SELECT stock_minimo FROM producto";
			$conexion = conexion();
			$consultaNombre = $conexion->query($consulta_nombre);
			$fila = $consultaNombre->fetchAll();
			//stock
			$data = $conexion->query($consultaStock);
			$data = $data->fetchAll();
			//stock minimo
			$data2 = $conexion->query($consultaStockm);
			$data2 = $data2->fetchAll();*/

		

		$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE producto_nombre LIKE '%$busqueda%'";

	

		$consulta_datos="SELECT producto_nombre, producto_stock FROM producto ORDER BY producto_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(producto_id) FROM producto";
		
	

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn() ;

	$Npaginas =ceil($total/$registros);

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Producto</th>
                    <th>Stock (actual)</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

    if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){

			if (['producto_stock'] <= ['stock_minimo']){

				$tabla.='
				<tr class="has-text-centered" >
				<td>'.$contador.'</td>
				<td>'.$rows['producto_nombre'].'</td>
				<td>'.substr($rows['producto_stock'],0,25).'</td>
				<td>
				<a href="#" class="button is-success is-rounded is-small">Realizar Pedido</a>
				</td>
				
                </tr>
				';
				$contador++;
			}
		}
        $pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando proveedores <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
