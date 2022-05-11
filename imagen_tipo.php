<?php

class imagen_tipo {
	
	public $id;
	public $datos;
	private $tabla = "imagen_tipo";
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	
	function orden_max() {
		
		if (!$this->id) {
			return 0;
		}
		
		$q = "SELECT orden FROM imagen WHERE id_imagen_tipo = $this->id ORDER BY orden DESC LIMIT 1";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$orden = mysql_result($r,0,0) + 1;
		} else {
			$orden = 0;
		}
		
		return $orden;
	}
	
	
	
	
	
	function recuperar() {
		if ($this->id) {
			$q = "SELECT * FROM $this->tabla WHERE id = $this->id";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)){
				$this->datos = mysql_fetch_assoc($r);	
			}
		}
		
	}
	
	
	
	function select() {
		
		$args = func_get_args();
		$name = $args[0];
		$extra = $args[1];
		
		if (!$name) {
			$name = 'id_imagen_tipo';
		}

		$consulta = "SELECT *	
						FROM imagen_tipo
						ORDER BY id";
		$resultado = mysql_query($consulta);
		
		if (mysql_num_rows($resultado)) {
			$select = "<select name='$name' id='$name' $extra><option value='0'></option>";
			while ($fila = mysql_fetch_array($resultado)) {
				$select .= "
						<option value='$fila[0]'>" . stripslashes($fila['nombre']) . "</option>";
			}
			$select .= '</select>';
		}
		
		if (isset($this->id)) {
	        $select = str_replace("value='$this->id'>", "value='$this->id' selected>", $select);
	    }
	    
		return $select;		
		
	}	

	
	
	
		
}

?>