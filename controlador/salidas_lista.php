<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	$campos="salidas.id_prod,salidas.fecha_salida,salidas.cantidad,producto.producto_nombre,producto.producto_stock";

	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT $campos FROM salidas INNER JOIN producto ON salidas.id_prod=producto.producto_id ORDER BY fecha_salida DESC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(id_salidas) FROM salidas ";

	}else{

		$consulta_datos="SELECT $campos FROM salidas INNER JOIN producto ON salidas.id_prod=producto.producto_id ORDER BY fecha_salida DESC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(id_salidas) FROM salidas";
		
	}

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
                    <th>Fecha</th>
                    <th>Cantidad Vendida</th>
					
                </tr>
            </thead>
            <tbody>
	';

	

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['producto_nombre'].'</td>
                    <td>'.$rows['fecha_salida'].'</td>
                    <td>'.$rows['cantidad'].'</td> 
					
                    </td>
                </tr>
            ';
            $contador++;
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
		$tabla.='<p class="has-text-right">Mostrando productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}