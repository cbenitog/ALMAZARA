<?php

class actividad {
	
	public $id;
	public $datos;
	private $tabla = "actividad";
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	

	function borrar() {
		global $mysqli;
		if ($_REQUEST["id_actividad"] && is_numeric($_REQUEST["id_actividad"])) {
			$this->id = $_REQUEST["id_actividad"];
			$this->recuperar();
		} else {
			return "0;" . acceso_restringido();
		}
		
		$q = "UPDATE actividad 
				SET orden = orden - 1
				WHERE id_carta = " . $this->datos["id_carta"] . "
					AND orden > " . $this->datos["orden"];
		$mysqli->query($q);
		
		$q = "DELETE FROM actividad WHERE id = $this->id";
		$mysqli->query($q);
		
		loggear("actividad - borrar - " . $this->datos["nombre"]);
		
		return "1;" . $this->tabla();
	}
	
	
	
	
	

	function desplazar() {
		global $mysqli;
		if (!$this->id) {
			return acceso_restringido();
		}
		
		
		$this->id_carta = $this->datos["id_carta"];
		
		if ($_REQUEST["desp"] == 1) {
			
			$orden_nuevo = $this->datos["orden"] + 1;
			
			if ($this->datos["orden"] < ($this->orden_max() -1)) {
				$q = "UPDATE actividad
						SET orden = orden - 1
						WHERE orden = $orden_nuevo";
				$mysqli->query($q);
				
				$q = "UPDATE actividad 
						SET orden = $orden_nuevo
						WHERE id = $this->id";
				$mysqli->query($q);
				
			}
			
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $this->datos["orden"] - 1;
			
			if ($this->datos["orden"] > 1) {
				$q = "UPDATE actividad
						SET orden = orden + 1
						WHERE orden = $orden_nuevo ";
				$mysqli->query($q);
 				
				$q = "UPDATE actividad
						SET orden = $orden_nuevo
						WHERE id = $this->id";
				$mysqli->query($q);
				
			}
			
		}
		
		
		return $this->tabla();
		
	}
	
	
	
	
	
	
	function editar() {
		global $mysqli;
		if ($_REQUEST["id_actividad"]) {
			if (is_numeric($_REQUEST["id_actividad"])) {
				$this->id = $_REQUEST["id_actividad"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		} else {
			
		}
		
		$o .= "
			<input type='button' class='$clase_general' value='DATOS' onclick=\"modulo(['actividad', 'editar', '&id_carta=$this->id_carta&id_actividad=$this->id&modo=general', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			<input type='button' class='$clase_imagenes' value='IMAGEN' onclick=\"modulo(['actividad', 'editar', '&id_carta=$this->id_carta&id_actividad=$this->id&modo=imagenes', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			";
		
		$o .= "
			<input type='button' value='GRABAR' onclick=\"formulario(['actividad', 'editar&id_carta=$this->id_carta&id_actividad=$this->id&grabar=1', 'form_actividad', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>";
		
		if ($_REQUEST["modo"] == "imagenes") {
			$o .= $this->editar_imagenes();
			return $o; 
		}
		
		
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'texto' => array 	('string',1),
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
			
				
				$q = $post->consulta($this->id,'actividad','', $extra, 'id');
				$mysqli->query($q);
				
				if (!$this->id) {
					$this->id = $mysqli->insert_id;
					$this->recuperar();
					
					$q = "UPDATE actividad
							SET orden = " . $this->orden_max() . " 
							WHERE id = $this->id";
					$mysqli->query($q);
					
					
					loggear("actividad - alta - $this->id - " . $this->datos["titulo"]);
				} else {
					loggear("actividad - edici�n - $this->id - " . $this->datos["titulo"]);
				}
				
				$o .= "Elemento grabado correctamente.";
				
				return $o;
			}	
		}
		
		if ($this->datos["activo"]) {
			$activo = "checked";
		} else {
			$activo = "";
		}
		
		
		
		$o .= "
			<form id='form_actividad'  onsubmit=\"return false;\">
			";
			
			
		$o .= "
		
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Activo:</strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='checkbox' id='activo' name='activo' value='1' $activo/>
				 </div>
				 <div style='clear: both;'></div>
				</div>
		
		
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
			 	<strong>Texto:</strong>
			 </div>
			 <div style='clear:both;'></div>
			 
			 <div class='tabla_td' style='width: 98%;'>
				<textarea class='ckeditor' id='texto' name='texto'>" . texto_form($this->datos["texto"]) . "</textarea>
			 </div>
			 <div style='clear: both;'></div>
			</div>
			
			</form>
			<input type='button' value='GRABAR' onclick=\"formulario(['actividad', 'editar&id_carta=$this->id_carta&id_actividad=$this->id&grabar=1', 'form_actividad', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			
			<div style='clear:both;'></div>
			<script>
					ckeditor_destruir();
					CKEDITOR.replace('texto');
			</script>
			";
		
		return $o;
	
	}
	
	
	
	
	
	
	
	function editar_imagenes() {
		global $mysqli;
		if (!$this->id) {
			$o .= "<br/>Para editar las im&aacute;genes es necesario primero guardar la carta.";
			return $o;
		}

		$uid = uniqid();
		
		$o .= "
			
		<div style='clear: both; height: 10px;'></div>
		
			<form action='ajax.php' method='post' id='uploadform' enctype='multipart/form-data' onsubmit='beginUpload(\"$uid\", \"imagen_bar\");'>
				<div style='float: left;'>
					<!--<input type='button' id='boton_elegir' value='Elegir imagen' style='margin-left: 3px;'/>-->
					<input type='button' id='boton_imagen' value='Subir nueva imagen' style='margin-left: 3px;'/>
					<input type='hidden' name='UPLOAD_IDENTIFIER' id='progress_key' value='$uid' />
					<span class='progressbar' id='imagen_bar'>0%</span><br/>
				</div>
				<div style='float: left; margin-left: 10px;'>
				</div>
				<div style='clear: both;'></div>
			</form>
			<br/>
			
			<script type= \"text/javascript\">
				upload_configurar('$uid', 
					'boton_imagen', 
					'imagen_bar', 
					'ajax.php?objeto=imagen&funcion=subir&id=$this->id&id_imagen_tipo=2&id_relacionada=$this->id&nuevo=1&nombre=imagen', 
					'ajax.php?objeto=actividad&funcion=editar_imagenes_bloque&id=" . $this->id . "&nuevo=1', 
					'tabla_imagen', 
					1);
			</script>
		
		";
		
	$o .= "<div id='tabla_imagen'>";
	$o .= $this->editar_imagenes_bloque(1);
	$o .= "</div>";
		
		return $o;		
		
	}
	
	
	
	
	
	
	
		

	
	function editar_imagenes_bloque() {
		global $mysqli;
		$args = func_get_args();
		
		if (!$this->id) {
			if ($_REQUEST["id"] && is_numeric($_REQUEST["id"])) {
				$this->id = $_REQUEST["id"];
			} else {
				return acceso_restringido();
			}
		}
		
		
		
		$q = "SELECT imagen.*  
				FROM imagen 
					INNER JOIN actividad ON actividad.id_imagen = imagen.id 
				WHERE actividad.id = " . $this->id;
		$r = $mysqli->query($q);

		if ($r->num_rows) {
		
			include_once("imagen.php");
			$imagen = new imagen();
			
			while ($imagen->datos = $r->fetch_array()) {
				$imagen->id = $imagen->datos["id"];
				
				if ($imagen->id == $this->datos["id_imagen"]) {
					$principal = "checked";
				} else {
					$principal = "";
				}
				$o .= "<div style='float:left;'><div class='thumb_visor'>" . $imagen->thumb(0,0) . "</div>";
				$o .= "<div style='text-align:center;'>";
				$o .= "Principal: <input type='radio' name='principal' id='principal' value='$imagen->id' $principal onclick=\"modulo(['carta','imagen_principal','&id_carta=$this->id&id_imagen=$imagen->id', 'temp',0,0]);\"/><br/>";
				$o .= " <span class='a' onclick=\"confirmacion(['Borrar imagen', 'imagen','borrar', '&id_imagen=$imagen->id&id_imagen_tipo=2&id_relacionada=$this->id', 'tabla_imagen',0,0]);\">borrar</span>";
				$o .= "</div>";
				$o .= "</div>";
				
			}
			
			 
			
		}
		
		return $o;
		
	}
	
	
	
	
		
	
	
	
	
	
	
	
	
	
	
	function orden_max() {
		global $mysqli;
		$q = "SELECT orden FROM actividad ORDER BY orden DESC LIMIT 1";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$orden = $rmysqli_result($r,0,0)  + 1;
		} else {
			$orden = 1;
		}
		
		return $orden;
	}
	
	
	
	
	
	
	
		
	
	function plantilla() {
		global $mysqli;
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar();
		
		$o .= "
		<div class='actividad'>
			<div class='actividad_inner'>
				<div class='actividad_foto'>" . $imagen->thumb(84,48) . "</div>
				<div class='actividad_texto'>" . $this->datos["texto"] . "</div>			
			</div>
		</div>";
		
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
		} else {
			$this->datos = "";
		}
		
	}
	
	
	
	

	function tabla() {
		global $mysqli;
		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		if (isset($_REQUEST["activo"]) && ($_REQUEST["activo"] == 0)) {
			$activo = 0;
			$boton_activo = "<input type='button' value='VER ACTIVAS' onclick=\"modulo(['actividad', 'tabla', '&activo=1', 'tabla_actividad', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_actividad = "INACTIVAS";
		} else {
			$activo = 1;
			$boton_activo = "<input type='button' value='VER INACTIVOS' onclick=\"modulo(['actividad', 'tabla', '&activo=0', 'tabla_actividad', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_actividad = "ACTIVAS";
		}
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
		
		
		$q = "SELECT * 
				FROM actividad 
				WHERE activo = $activo
				ORDER BY orden ";
		$r = $mysqli->query($q);
		
		$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='button' value='NUEVO ELEMENTO' onclick=\"modulo(['actividad', 'editar', '', 'bloque2_trabajo', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
				$boton_activo
			";
		
		$o .= "<h3>ELEMENTOS $activo_actividad</h3><br/>";
		
		if ($r->num_rows) {
			$i = 0;
			
			$o .= "
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 50%;'>
					ACTIVIDAD
				</div>
				<div class='tabla_th' style='width: 50%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($this->datos = $r->fetch_array()) {
				if (($i % 2) == 0) {
					$clase = "tabla_par";
				} else {
					$clase = "tabla_impar";
				}
				
				$this->id = $this->datos["id"];
				
				$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
				$i += 1;
			}
			
		} else {
			$o .= error("No hay elementos en la secci�n.");
		}
		
		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		global $mysqli;
		$o .= "
			<div class='tabla_td' style='width: 48%;'>
				" . $this->datos["texto"] . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 48%; text-align: right;'>
				<span class='a' onclick=\"modulo(['actividad', 'editar', '&id_actividad=$this->id', 'bloque2_trabajo', 0,0]);\">editar</span>
				<span class='a' onclick=\"modulo(['actividad', 'desplazar', '&desp=-1&id_actividad=$this->id', 'tabla_actividad', 0,0]);\">subir</span>
				<span class='a' onclick=\"modulo(['actividad', 'desplazar', '&desp=1&id_actividad=$this->id', 'tabla_actividad', 0,0]);\">bajar</span>
				<span class='a' onclick=\"confirmacion(['Borrar elemento','actividad', 'borrar', '&id_actividad=$this->id', 'tabla_actividad', 0, 0]);\">borrar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
	
	
	
	
	
	
	
	
	
		
}

?>