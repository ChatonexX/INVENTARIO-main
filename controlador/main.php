<?php
	
	# Conexion a la base de datos #
	
		 function conexion()
		{	/* La clase PDO representa una conexión entre PHP y un servidor de bases de datos. */
			$pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', '');

			return $pdo;
		}



		function verificar_datos($filtro,$cadena)
		{
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
			}else{
				return true;
			}
		}

	# Verificar datos #


	# Limpiar cadenas de texto #
	function limpiar_cadena($cadena){
		/* Elimina espacios en blanco */
		$cadena=trim($cadena);
		/* Reemplaza por una diagonal / cualquier clase de comillas< */
		$cadena=stripslashes($cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;
	}


	# Funcion renombrar fotos #
	function renombrar_fotos($nombre){
		/* Si hay un espacio o los simbolos especificados los reemplaza con _ */
		$nombre=str_ireplace(" ", "_", $nombre);
		$nombre=str_ireplace("/", "_", $nombre);
		$nombre=str_ireplace("#", "_", $nombre);
		$nombre=str_ireplace("-", "_", $nombre);
		$nombre=str_ireplace("$", "_", $nombre);
		$nombre=str_ireplace(".", "_", $nombre);
		$nombre=str_ireplace(",", "_", $nombre);
		$nombre=$nombre."_".rand(0,100);
		return $nombre;
	}


	# Funcion paginador de tablas #
	function paginador_tablas($pagina,$Npaginas,$url,$botones){
		$tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		/*no se puede regresar si estas en la pagina 1*/
		if($pagina<=1){
			$tabla.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a> 
			<ul class="pagination-list">';
		/*si estas en una pagina se restara 1 y volveras una pagina*/
		}else{
			$tabla.='
			<a class="pagination-previous" href="'.$url.($pagina-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$pagina; $i<=$Npaginas; $i++){
			if($ci>=$botones){
				break;
			}
			if($pagina==$i){
				$tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}
		#pagina final#
		if($pagina==$Npaginas){
			$tabla.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		#Siguiente pagina +1#
		}else{/*url y npaginas nos llevara a la pagina final*/
			$tabla.=' 
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a>
			';
		}

		$tabla.='</nav>';
		return $tabla;
	}