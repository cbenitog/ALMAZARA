<?php

class habitacion {
	
	public $id;
	public $datos;
	private $tabla = "habitacion";
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	function borrar() {
		global $mysqli;
		if ($_REQUEST["id_habitacion"] && is_numeric($_REQUEST["id_habitacion"])) {
			$this->id = $_REQUEST["id_habitacion"];
			$this->recuperar();
		} else {
			return "0;" . acceso_restringido();
		}
		
		$q = "UPDATE habitacion 
				SET orden = orden - 1
				WHERE id_tipo = " . $this->datos["id_tipo"] . "
					AND orden > " . $this->datos["orden"];
		$mysqli->query($q);
		
		$q = "DELETE FROM habitacion WHERE id = $this->id";
		$mysqli->query($q);
		
		loggear("habitacion - borrar - " . $this->datos["nombre"]);
		
		return "1;" . $this->tabla();
	}
	
	
	
	
	function boton() {
		global $mysqli;
		if (!$this->id) {
			return;
		}
		
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar(); 
		
		$o .= "	<div class='habitaciones_boton2 cursor' onclick=\"habitaciones_boton(2,$this->id);\">
					<div class='habitaciones_boton2_imagen'>" . $imagen->thumb(44, 26) . "</div>
					<div class='habitaciones_boton2_texto'>" . $this->datos["nombre"] . "</div>
					<a class='todo' href='?s=habitaciones&paso=2&id_habitacion=$this->id&externo=1&habitacion=" . htmlentities($this->datos["nombre"]) . "' onclick='return no();'></a>
				</div>
				";
		
		return $o;
	}
	
	
	
	
	function caracteristicas() {
		global $mysqli;
		if (!$this->id) {
			return;
		}
		
		$q = "SELECT * FROM habitacion_caracteristica WHERE id_habitacion = $this->id ORDER BY orden";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$o .= "<ul class='sq'>";
			while ($fila = $r->fetch_array()) {
				$o .= "<li class='sq'>" . $fila["texto"] . " 
					<span class='a' onclick=\"modulo(['habitacion','caracteristica_editar','&id_habitacion=$this->id&id_caracteristica=" . $fila["id"] . "', 'caracteristica_editar',0,0]);\">editar</span>
					<span class='a' onclick=\"modulo(['habitacion','caracteristica_desplazar','&desp=-1&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">subir</span>
					<span class='a' onclick=\"modulo(['habitacion','caracteristica_desplazar','&desp=1&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">bajar</span>
					<span class='a' onclick=\"confirmacion(['Borrar caracteristica " . $fila["texto"] . "', 'habitacion','caracteristica_borrar','&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">borrar</span>
					</li>
				";
			}
		}
		return $o;
	}
	
	
	
	
	function caracteristica_borrar() {
		global $mysqli;
		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "SELECT orden, id_habitacion FROM habitacion_caracteristica WHERE id = $id";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$orden = $rmysqli_result($r,0,0);
			$this->id = $rmysqli_result($r,0,1);
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "DELETE FROM habitacion_caracteristica WHERE id = $id";
		$mysqli->query($q);
		
		$q = "UPDATE habitacion_caracteristica SET orden = orden -1 WHERE orden > $orden AND id_habitacion = $this->id";
		$mysqli->query($q);
		
		return "1;" . $this->caracteristicas();
		
	}
	
	
	
	function caracteristica_desplazar() {
		global $mysqli;
		
		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
		} else {
			return acceso_restringido();
		}
		
		$q = "SELECT * FROM habitacion_caracteristica WHERE id = $id";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$fila = $r->fetch_array();
		} else {
			return acceso_restringido();
		}
		
		
		$this->id = $fila["id_habitacion"];
		
		if ($_REQUEST["desp"] == 1) {
			
			$orden_nuevo = $fila["orden"] + 1;
			
			$q = "SELECT * FROM habitacion_caracteristica WHERE orden = $orden_nuevo AND id_habitacion = $this->id";
			$r2 = $mysqli->query($q);
			
			if (mysqli_num_rows($r2)) {
				$q = "UPDATE habitacion_caracteristica
						SET orden = orden - 1
						WHERE orden = $orden_nuevo AND id_habitacion = " . $this->id;
				$mysqli->query($q);
				
				$q = "UPDATE habitacion_caracteristica
						SET orden = $orden_nuevo
						WHERE id = $id";
				$mysqli->query($q);
				
			}
			
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $fila["orden"] - 1;
			
			if ($fila["orden"] > 1) {
				$q = "UPDATE habitacion_caracteristica
						SET orden = orden + 1
						WHERE orden = $orden_nuevo AND id_habitacion = $this->id";
				$mysqli->query($q);
 				
				$q = "UPDATE habitacion_caracteristica
						SET orden = $orden_nuevo
						WHERE id = $id";
				$mysqli->query($q);

			}
			
		}
		
		return $this->caracteristicas();
	}
	
		
	
	
	
	function caracteristica_editar() {
		global $mysqli;
		if (!$this->id) {
			return acceso_restringido();
		}

		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
			
			$q = "SELECT * FROM habitacion_caracteristica WHERE id = $id";
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$fila = $r->fetch_array();
			}
		} 
		
		if ($_REQUEST["grabar"]) {
			if ($id) {
				$q = "UPDATE habitacion_caracteristica 
						SET texto = '" . utf8_decode($_REQUEST["caracteristica_texto"]) . "
						WHERE id = $id";
			} else {
				$q = "SELECT orden FROM habitacion_caracteristica WHERE id_habitacion = $this->id ORDER BY orden DESC LIMIT 1";
				$r = $mysqli->query($q);
				
				if ($r->num_rows) {
					$orden = $rmysqli_result($r,0,0) + 1;
				} else {
					$orden = 1;
				}
				
				$q = "INSERT INTO habitacion_caracteristica 
						(id_habitacion, texto, orden)
						VALUES ($this->id, '" . utf8_decode($_REQUEST["caracteristica_texto"]) . "', $orden)";
				
			}
			
			$mysqli->query($q);
				
			return $this->caracteristicas();
							
		}
		
		$o .= "<input type='text' name='caracteristica_texto' id='caracteristica_texto' value='" . $fila["texto"] . "'/>
			<input type='button' value='GRABAR' onclick=\"formulario2(['habitacion','caracteristica_editar&id_habitacion=$this->id&id_caracteristica=$id',['caracteristica_texto'],'caracteristicas',0,0]);\"/>";

		return $o;
	
		
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
				$q = "UPDATE habitacion
						SET orden = orden - 1
						WHERE orden = $orden_nuevo AND id_tipo = " . $this->datos["id_tipo"];
				$mysqli->query($q);
				
				$q = "UPDATE habitacion 
						SET orden = $orden_nuevo
						WHERE id = $this->id";
				$mysqli->query($q);
				
			}
			
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $this->datos["orden"] - 1;
			
			if ($this->datos["orden"] > 1) {
				$q = "UPDATE habitacion
						SET orden = orden + 1
						WHERE orden = $orden_nuevo AND id_tipo = " . $this->datos["id_tipo"];
				$mysqli->query($q);
 				
				$q = "UPDATE habitacion
						SET orden = $orden_nuevo
						WHERE id = $this->id";
				$mysqli->query($q);
				
			}
			
		}
		
		
		return $this->tabla();
		
	}
	
	
	
	
	
	
	
	
	
	
	function editar() {
		global $mysqli;
		if ($_REQUEST["id_habitacion"]) {
			if (is_numeric($_REQUEST["id_habitacion"])) {
				$this->id = $_REQUEST["id_habitacion"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		} else {
			
		}
		
		$o .= "
			<input type='button' class='$clase_general' value='DATOS' onclick=\"modulo(['habitacion', 'editar', '&id_carta=$this->id_carta&id_habitacion=$this->id&modo=general', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			<input type='button' class='$clase_imagenes' value='IMAGEN' onclick=\"formulario(['habitacion', 'editar&id_carta=$this->id_carta&id_habitacion=$this->id&grabar=1', 'form_habitacion', 'temp', 0, $this->id_carta]);modulo(['habitacion', 'editar', '&id_carta=$this->id_carta&id_habitacion=$this->id&modo=imagenes', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			";
		
		
		if ($_REQUEST["modo"] == "imagenes") {
			$o .= $this->editar_imagenes();
			return $o; 
		}
		
		$o .= "
		<input type='button' value='GRABAR' onclick=\"formulario(['habitacion', 'editar&id_carta=$this->id_carta&id_habitacion=$this->id&grabar=1', 'form_habitacion', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
		<div style='clear:both;'></div>";
		
		
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'nombre' => array 	('string',1),
					'precio' => array 	('int',0),
					'precio_texto' => array 	('string',0),
					'texto' => array 	('string',0),
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
			
				
				$q = $post->consulta($this->id,'habitacion','', $extra, 'id');
				$mysqli->query($q);
				
				if (!$this->id) {
					$this->id = $mysqli->insert_id;
					$this->recuperar();
					
					$q = "UPDATE habitacion
							SET orden = " . $this->orden_max() . " 
							WHERE id = $this->id";
					$mysqli->query($q);
					
					
					loggear("habitacion - alta - $this->id - " . $this->datos["titulo"]);
				} else {
					loggear("habitacion - edici�n - $this->id - " . $this->datos["titulo"]);
				}
				
				$o .= "Habitaci�n grabada correctamente.";
				
				return $o;
			}	
		}
		
		if ($this->datos["activo"]) {
			$activo = "checked";
		} else {
			$activo = "";
		}
		
		
		
		$o .= "
			<form id='form_habitacion'  onsubmit=\"return false;\">
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
				 	<strong>Nombre: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' id='nombre' name='nombre' value='" . $this->datos["nombre"] . "'/>
				 </div>
				 <div style='clear: both;'></div>
				</div>
				
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Precio: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' id='precio' name='precio' value='" . $this->datos["precio"] . "'/>
				 </div>
				 <div style='clear: both;'></div>
				</div>
				
				
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Precio desc.: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' class='todo' id='precio_texto' name='precio_texto' value='" . $this->datos["precio_texto"] . "'/>
				 </div>
				 <div style='clear: both;'></div>
				</div>
				";
		
		if ($this->id) {
			$o .= "
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Caracter�sticas: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<div id='caracteristicas'>" . $this->caracteristicas() . "</div>
					<span class='a' onclick=\"modulo(['habitacion','caracteristica_editar','&id_habitacion=$this->id','caracteristica_editar',0,0]);\">a�adir caracter�stica</span>
					<div id='caracteristica_editar'></div>
				 </div>
				 <div style='clear: both;'></div>
				</div>
			";
		}		
				
		$o .= "		
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
			<input type='button' value='GRABAR' onclick=\"formulario(['habitacion', 'editar&id_carta=$this->id_carta&id_habitacion=$this->id&grabar=1', 'form_habitacion', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			
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
					'ajax.php?objeto=imagen&funcion=subir&id=$this->id&id_imagen_tipo=4&id_relacionada=$this->id&nuevo=1&nombre=imagen', 
					'ajax.php?objeto=habitacion&funcion=editar_imagenes_bloque&id=" . $this->id . "&nuevo=1', 
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
		
		
		
		$q = "SELECT * 
				FROM imagen 
				WHERE id_imagen_tipo = 4 AND id_relacionada = " . $this->id;
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
				$o .= "<div style='float:left;'><div class='thumb_visor' >" . $imagen->thumb(0,0) . "</div>";
				$o .= "<div style='text-align:center;'>";
				$o .= "Principal: <input type='radio' name='principal' id='principal' value='$imagen->id' $principal onclick=\"modulo(['habitacion','imagen_principal','&id_habitacion=$this->id&id_imagen=$imagen->id', 'temp',0,0]);\"/><br/>";
				$o .= " <span class='a' onclick=\"confirmacion(['Borrar imagen', 'imagen','borrar', '&id_imagen=$imagen->id&id_imagen_tipo=2&id_relacionada=$this->id', 'tabla_imagen',0,0]);\">borrar</span>";
				$o .= "</div>";
				$o .= "</div>";
				
			}
			
			 
			
		}
		
		return $o;
		
	}

	
	
	function foto() {
		global $mysqli;
		if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
			include_once("imagen.php");
			$imagen = new imagen();
			$imagen->id = $_REQUEST["id_imagen"];
			$imagen->recuperar();
		} else {
			return acceso_restringido();
		}
		
		$o .= "<div class='foto_lupa cursor'><a class='colorbox todo' href='" . $imagen->enlace() . "'></a></div>
				" . $imagen->ver(169, 199) . "</div>
				<script>
					$('a.colorbox').colorbox({rel: 'gal', maxWidth: '90%', maxHeight: '90%;'});
				</script>";
				
		return $o;
		
	}
	
	
	
	
	function imagen_principal() {
		global $mysqli;
		$q = "UPDATE habitacion SET id_imagen = " . $_REQUEST["id_imagen"] . " WHERE id = $this->id";
		$mysqli->query($q);
	}
	
	
		
		
	
	function orden_max() {
		global $mysqli;
		if ($this->datos["id_tipo"]) {
			$id_tipo = $this->datos["id_tipo"];
		} else {
			$id_tipo = $_REQUEST["id_tipo"];
		}
		
		$q = "SELECT orden FROM actividad WHERE id_tipo = " . $id_tipo . " ORDER BY orden DESC LIMIT 1";
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
		if (!$this->id) {
			return;
		}
		
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar();
		
		if ($_REQUEST["interno"]) {
			$o .= "<div class='cursor flecha_volver' onclick=\"return menu_abrir('tarifas');\"></div>";
		} else {
			if (($this->id == 11) || ($this->id == 12)) {
				$o .= "<div class='cursor flecha_volver' onclick=\"habitaciones_boton(0,'');\"></div>";				
			} else {
				$o .= "<div class='cursor flecha_volver' onclick=\"habitaciones_boton(1," . $this->datos["id_tipo"] . ");\"></div>";
			}
		}
		
		$o .= "
				<div class='fondo1 habitacion_galeria'>
					<div class='habitacion_galeria_inner'>
						<div id='habitacion_foto'>
							<div class='foto_lupa cursor'><a class='colorbox todo' rel='gal' href='" . $imagen->enlace() . "'></a></div>
							" . $imagen->ver(169, 199) . "
						</div>
						";
		
		$q = "SELECT * FROM imagen WHERE id_imagen_tipo = 4 AND id_relacionada = $this->id ORDER BY orden";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$o .= "<div class='habitacion_thumbs'>";
			while ($imagen->datos = $r->fetch_array()) {
				$imagen->id = $imagen->datos["id"];
				
				$o .= "<div class='cursor habitacion_thumb'><a class='colorbox' rel='gal' href='" . $imagen->enlace() . "' onmouseover=\"modulo(['habitacion','foto','&id_imagen=$imagen->id','habitacion_foto',0,0]);return false;\">" . $imagen->thumb(51,51) . "</a></div>";
			}
			$o .= "</div>";
		}
		
		$o .= "
					</div>
				</div>

				<script>
					$('a.colorbox').colorbox({rel: 'gal', maxWidth: '90%', maxHeight: '90%;'});
				</script>
											
				<div class='habitacion_bloque_der'>
					<div class='fondo2 habitacion_descripcion'>
						<div class='habitacion_descripcion_inner'>
							<h2>" . $this->datos["nombre"] . "</h2>
							<div style='height: 23px;'></div>
							" . $this->datos["texto"] . "
							<div style='height: 25px;'></div>
							" . $this->plantilla_caracteristicas() . "
						</div>
					</div>
					<div class='fondo3 habitacion_precio'>
						<div class='habitacion_precio_inner'>
							<span class='habitacion_precio'><strong>PRECIO: " . $this->datos["precio"] . "&euro;</span></strong><br/>
							" . $this->datos["precio_texto"] . "
						</div>
						<div class='habitacion_precio_boton'>
							<input type='button' class='cursor' onclick=\"habitaciones_boton(3,$this->id);\" value='RESERVAR'/>
						</div>
						
					</div>
				</div>
				";
		
		
				
		return $o;	
		
	}
	
	
	
	
	function plantilla_caracteristicas() {
		global $mysqli;
		$q = "SELECT * FROM habitacion_caracteristica WHERE id_habitacion = $this->id ORDER BY orden";
		$r = $mysqli->query($q);
		
		if ($num = $r->num_rows) {
			$num = ceil($num / 2);
			
			$o .= "<div class='habitacion_caracteristica'><ul>";
			$i = 0;
			while ($fila = $r->fetch_array()) {
				if ($i == $num) {
					$o .= "</ul></div><div class='habitacion_caracteristica'><ul>";
					$i = 0;
				}
				
				$o .= "<li>" . $fila["texto"] . "</li>";
				$i += 1;
			}
			$o .= "</ul></div>
				<div class='clear'></div>";
		}
	
		return $o;
	}
	
	
	
	
	
	
	
	function plantilla_resumen() {
		global $mysqli;
		include_once("imagen.php");
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar();
		
		if ($this->datos["precio"]) {
			$precio = $this->datos["precio"] . "&euro;";
		}
		
		$o .= "
			<div class='habitacion_resumen'>
				<div class='habitacion_resumen_foto'>" . $imagen->thumb(55,34) . "</div>
				<div class='habitacion_resumen_texto'>" . $this->datos["nombre"]. ":</div>
				<div class='habitacion_resumen_precio'>
					<div class='habitacion_resumen_precio_inner'>
						" . $precio . "
					</div>
				</div>
				<a class='todo' href='?s=habitaciones&paso=2&id_habitacion=$this->id&externo=1&habitacion=" . htmlentities($this->datos["nombre"]) . "' onclick=\"modulo(['plantilla','seccion','&s=habitaciones&id_habitacion=$this->id&interno=1','pagina_nueva',1,'habitacion']);return no();\"></a>
			</div>
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
		} else {
			$this->datos = "";
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	

	function tabla() {
		global $mysqli;
		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}

		$select = "<select name='id_tipo' id='id_tipo' onchange=\"formulario2(['habitacion','tabla',['id_tipo'],'tabla_habitacion',0,0]);\">
				<option value=''></option>
				<option value='1'>Habitaciones dobles</option>
				<option value='2'>Suite Azul</option>
				<option value='3'>Villas</option>
			</select>";
		
		if ($_REQUEST["id_tipo"] && is_numeric($_REQUEST["id_tipo"])) { 
			$id_tipo = $_REQUEST["id_tipo"];
			$select = str_replace("'$id_tipo'", "'$id_tipo' selected", $select);
		}
		
		$o .= "
			TIPO DE HABITACI&Oacute;N:
			$select<br/><br/>
		";
		
		if (!$id_tipo) {
			return $o;
		}
		 
		if (isset($_REQUEST["activo"]) && ($_REQUEST["activo"] == 0)) {
			$activo = 0;
			$boton_activo = "<input type='button' value='VER ACTIVAS' onclick=\"modulo(['habitacion', 'tabla', '&id_tipo=$id_tipo&activo=1', 'tabla_habitacion', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_habitacion = "INACTIVAS";
		} else {
			$activo = 1;
			$boton_activo = "<input type='button' value='VER INACTIVOS' onclick=\"modulo(['habitacion', 'tabla', '&id_tipo=$id_tipo&activo=0', 'tabla_habitacion', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_habitacion = "ACTIVAS";
		}
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
		
		
		$q = "SELECT * 
				FROM habitacion 
				WHERE id_tipo= $id_tipo AND activo = $activo
				ORDER BY orden ";
		$r = $mysqli->query($q);
		
		$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='button' value='NUEVA HABITACI�N' onclick=\"modulo(['habitacion', 'editar', '', 'bloque2_trabajo', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
				$boton_activo
			";
		
		$o .= "<h3>HABITACIONES $activo_habitacion</h3><br/>";
		
		if ($r->num_rows) {
			$i = 0;
			
			$o .= "
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 50%;'>
					HABITACI�N
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
		
		$o .= "
			<div class='tabla_td' style='width: 48%;'>
				" . $this->datos["nombre"] . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 48%; text-align: right;'>
				<span class='a' onclick=\"modulo(['habitacion', 'editar', '&id_habitacion=$this->id', 'bloque2_trabajo', 0,0]);\">editar</span>
				<span class='a' onclick=\"modulo(['habitacion', 'desplazar', '&desp=-1&id_habitacion=$this->id', 'tabla_habitacion', 0,0]);\">subir</span>
				<span class='a' onclick=\"modulo(['habitacion', 'desplazar', '&desp=1&id_habitacion=$this->id', 'tabla_habitacion', 0,0]);\">bajar</span>
				<span class='a' onclick=\"confirmacion(['Borrar habitaci�n','habitacion', 'borrar', '&id_habitacion=$this->id', 'tabla_habitacion', 0, 0]);\">borrar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
	
	
	
	
	
	
	
		
}

?>