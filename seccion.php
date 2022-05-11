<?php

class seccion {
	
	public $id;
	public $datos;
	private $tabla = "seccion";
	
	private $titulo, $subtitulo;
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	

	
	

	
	function editar() {
		 
		global $mysqli;
		if (!$this->id) {
			return acceso_restringido();
		}
		
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'titulo' => array 	('string',0),
					'activo' => array 	('boolean',0)
			);
			
			$post->comprobar();
			
			if ($post->error) {
				
				$o .= error("ERROR: ");
				
				$primero = 1;
				foreach($post->errores as $key => $value) {
					if ($primero) {
						$primero = 0;
					} else {
						$error .= ", ";
					}
					$error .= $key;
				}
				$o .= error($error);
				
				if ($post->valores) {
					foreach ($post->valores as $key => $value) {
						$this->datos[$key] = $value;
					}
				}
				
			} else {
			
				
				$q = $post->consulta($this->id,'seccion','', $extra, 'id');
				$mysqli->query($q);
				
				if (!$this->id) {
					$this->id = $mysqli->insert_id;
					$this->recuperar();
					loggear("seccion - alta - $this->id - " . $this->datos["titulo"]);
				} else {
					loggear("secci�n - edici�n - $this->id - " . $this->datos["titulo"]);
				}
				
				$o .= "Secci&oacute;n grabada correctamente.";
				
				return $o;
			}	
		}
		

		$o .= "
			<input type='button' value='Grabar' onclick=\"formulario(['seccion', 'editar&id_seccion=$this->id&grabar=1', 'form_seccion', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>";
	
		$o .= "
			<form id='form_seccion'  onsubmit=\"formulario(['seccion', 'editar&id_seccion=$this->id&grabar=1', 'form_seccion', 'bloque2_trabajo', 0, 1]);\" >
			";

		if ($this->datos["activo"]) {
			$activo = "checked";
		} else {
			$activo = "";
		}
			
		$o .= "
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Secci&oacute;n:</strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' class='todo' id='titulo' name='titulo' value='" . texto_form($this->datos["titulo"]) . "'/>
			 	 </div>
			 	 <div style='clear: both;'></div>
				</div>
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Activa:</strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='checkbox' id='activo' name='activo' value='1' $activo/>
			 	 </div>
			 	 <div style='clear: both;'></div>
				</div>
				</form>
			<input type='button' value='Grabar' onclick=\"formulario(['seccion', 'editar&id_seccion=$this->id&grabar=1', 'form_seccion', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>
			";
		
		return $o;
	
	}
	
		
	
	
	
	
	
	
	
	function recuperar() {
		global $mysqli;
		 
		if ($this->id) {
			$q = "SELECT * FROM $this->tabla WHERE id = $this->id";
			$r = $mysqli->query($q);
			
			if ($r->num_rows){
				$this->datos = $r->fetch_assoc();	
			}
		}
		
	}
	

	
	
	
	function seccion($nombre) {
		global $mysqli;
		 
		$q = "SELECT id FROM seccion WHERE nombre like '$nombre'";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$this->id = mysqli_result($r, 0,0);
			$this->recuperar();
		}
		return $this->id;
	}
	
	
	
	
	
	
	
	function select() {
		global $mysqli;
		 

		$args = func_get_args();
		$name = $args[0];
		$extra = $args[1];
		
		if (!$name) {
			$name = 'id_seccion';
		}

		$consulta = "SELECT *	
						FROM seccion
						ORDER BY id";
		$resultado = $mysqli->query($consulta);
		
		if (mysqli_num_rows($resultado)) {
			$select = "<select name='$name' id='$name' $extra><option value='0'></option>";
			while ($fila = $resultado->fetch_array()) {
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

	
	
	
	

	function tabla() {
		global $mysqli;
		 

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
		
		
		$q = "SELECT * 
				FROM seccion 
				WHERE id_padre = 0
				ORDER BY orden";
		$r = $mysqli->query($q);
		
		$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
		";
		
		if ($r->num_rows) {
			$i = 0;
			
			$o .= "
			
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 35%;'>
					SECCI&Oacute;N
				</div>
				<div class='tabla_th' style='width: 35%;'>
					SUBSECCI&Oacute;N
				</div>
				<div class='tabla_th' style='width: 10%;'>
					ACTIVA
				</div>
				<div class='tabla_th' style='width: 20%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($fila = $r->fetch_array()) {
				if (($i % 2) == 0) {
					$clase = "tabla_par";
				} else {
					$clase = "tabla_impar";
				}
				
				$this->id = $fila[0];
				$this->recuperar();
				$this->titulo = $this->datos["titulo"];
				$this->subtitulo = "&nbsp;";
				$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
				
				$q2 = "SELECT * FROM seccion WHERE id_padre = " . $fila["id"] . " ORDER BY orden";
				$r2 = $mysqli->query($q2);
				
				if (mysqli_num_rows($r2)) {
					while ($this->datos = $r2->fetch_array()) {
						$this->id = $this->datos["id"];
						$this->subtitulo = $this->datos["titulo"];
						$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
						
					}
				}
				
				$i += 1;
			}
			
		} else {
			$o .= error("No hay secciones.");
		}
		
		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		global $mysqli;
		if ($this->datos["activo"]) {
			$activo = "&nbsp;";
		} else {
			$activo = "NO";
		}
		
		$o .= "
			<div class='tabla_td' style='width: 33%;'>
				" . $this->titulo . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 33%;'>
				" . $this->subtitulo . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 8%;'>
				$activo
			</div>
			<div class='tabla_td' style='width: 18%; text-align: right;'>
				<span class='a' onclick=\"modulo(['seccion', 'editar', '&id_seccion=$this->id', 'bloque2_trabajo', 0, 0]);\">editar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
		
	
		
}

?>