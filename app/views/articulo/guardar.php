<?

$id_imagen = $this->request->getPost("codigo_articulo");
        $rutas = 'files/'.$id_imagen.'/';
        mkdir($rutas);

$id_imagen = $this->request->getPost("codigo_articulo");
if($_FILES["archivo"]["error"]>0){
		echo "Error al cargar archivo";	
		} else {
		
		$permitidos = array("image/gif","image/png","application/pdf");
		$limite_kb = 200;
		
		if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){
			
			$ruta = 'files/'.$id_insert.'/';
			$archivo = $ruta.$_FILES["archivo"]["name"];
			
			if(!file_exists($ruta)){
				mkdir($ruta);
			}
			
			if(!file_exists($archivo)){
				
				$resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
				
				if($resultado){
					echo "Archivo Guardado";
					} else {
					echo "Error al guardar archivo";
				}
				
				} else {
					echo "Archivo ya existe";
					}
			
			} else {
			echo "Archivo no permitido o excede el tamaño";
		}
		
	}
	
?>