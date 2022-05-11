<?php

class oferta {
	
	public $id;
	public $datos;
	private $tabla = "oferta";
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	
	
	function borrar() {

		if ($_REQUEST["id_oferta"] && is_numeric($_REQUEST["id_oferta"])) {
			$this->id = $_REQUEST["id_oferta"];
			$this->recuperar();
		} else {
			return "0;" . acceso_restringido();
		}
		
		$q = "DELETE FROM oferta WHERE id = $this->id";
		mysql_query($q);
		
		loggear("oferta - borrar - " . $this->datos["nombre"]);
		
		return "1;" . $this->tabla();
	}
	
	
	
	
	
	
	
	
	function caracteristicas() {
		
		if (!$this->id) {
			return;
		}
		
		$q = "SELECT * FROM oferta_caracteristica WHERE id_oferta = $this->id ORDER BY orden";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$o .= "<ul class='sq'>";
			while ($fila = mysql_fetch_array($r)) {
				$o .= "<li class='sq'>" . $fila["texto"] . " 
					<span class='a' onclick=\"modulo(['oferta','caracteristica_editar','&id_oferta=$this->id&id_caracteristica=" . $fila["id"] . "', 'caracteristica_editar',0,0]);\">editar</span>
					<span class='a' onclick=\"modulo(['oferta','caracteristica_desplazar','&desp=-1&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">subir</span>
					<span class='a' onclick=\"modulo(['oferta','caracteristica_desplazar','&desp=1&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">bajar</span>
					<span class='a' onclick=\"confirmacion(['Borrar caracteristica " . $fila["texto"] . "', 'oferta','caracteristica_borrar','&id_caracteristica=" . $fila["id"] . "', 'caracteristicas',0,0]);\">borrar</span>
					</li>
				";
			}
			$o .= "</ul>";
		}
		return $o;
	}
	
	
	
	
	function caracteristica_borrar() {
		
		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "SELECT orden, id_oferta FROM oferta_caracteristica WHERE id = $id";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$orden = mysql_result($r,0,0);
			$this->id = mysql_result($r,0,1);
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "DELETE FROM oferta_caracteristica WHERE id = $id";
		mysql_query($q);
		
		$q = "UPDATE oferta_caracteristica SET orden = orden -1 WHERE orden > $orden AND id_oferta = $this->id";
		mysql_query($q);
		
		return "1;" . $this->caracteristicas();
		
	}
	
	
	
	
	function caracteristica_desplazar() {

		
		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
		} else {
			return acceso_restringido();
		}
		
		$q = "SELECT * FROM oferta_caracteristica WHERE id = $id";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$fila = mysql_fetch_array($r);
		} else {
			return acceso_restringido();
		}
		
		
		$this->id = $fila["id_oferta"];
		
		if ($_REQUEST["desp"] == 1) {
			
			$orden_nuevo = $fila["orden"] + 1;
			
			$q = "SELECT * FROM oferta_caracteristica WHERE orden = $orden_nuevo AND id_oferta = $this->id";
			$r2 = mysql_query($q);
			
			if (mysql_num_rows($r2)) {
				$q = "UPDATE oferta_caracteristica
						SET orden = orden - 1
						WHERE orden = $orden_nuevo AND id_oferta = " . $this->id;
				mysql_query($q);
				
				$q = "UPDATE oferta_caracteristica
						SET orden = $orden_nuevo
						WHERE id = $id";
				mysql_query($q);
				
			}
			
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $fila["orden"] - 1;
			
			if ($fila["orden"] > 1) {
				$q = "UPDATE oferta_caracteristica
						SET orden = orden + 1
						WHERE orden = $orden_nuevo AND id_oferta = $this->id";
				mysql_query($q);
 				
				$q = "UPDATE oferta_caracteristica
						SET orden = $orden_nuevo
						WHERE id = $id";
				mysql_query($q);

			}
			
		}
		
		return $this->caracteristicas();
	}
	
	
	
	
	function caracteristica_editar() {
		
		if (!$this->id) {
			return acceso_restringido();
		}

		if ($_REQUEST["id_caracteristica"] && is_numeric($_REQUEST["id_caracteristica"])) {
			$id = $_REQUEST["id_caracteristica"];
			
			$q = "SELECT * FROM oferta_caracteristica WHERE id = $id";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)) {
				$fila = mysql_fetch_array($r);
			}
		} 
		
		if ($_REQUEST["grabar"]) {
			if ($id) {
				$q = "UPDATE oferta_caracteristica 
						SET texto = '" . utf8_decode($_REQUEST["caracteristica_texto"]) . "
						WHERE id = $id";
			} else {
				$q = "SELECT orden FROM oferta_caracteristica WHERE id_oferta = $this->id ORDER BY orden DESC LIMIT 1";
				$r = mysql_query($q);
				
				if (mysql_num_rows($r)) {
					$orden = mysql_result($r,0,0) + 1;
				} else {
					$orden = 1;
				}
				
				$q = "INSERT INTO oferta_caracteristica 
						(id_oferta, texto, orden)
						VALUES ($this->id, '" . utf8_decode($_REQUEST["caracteristica_texto"]) . "', $orden)";
				
			}
			
			mysql_query($q);
				
			return $this->caracteristicas();
							
		}
		
		$o .= "<input type='text' name='caracteristica_texto' id='caracteristica_texto' value='" . $fila["texto"] . "'/>
			<input type='button' value='GRABAR' onclick=\"formulario2(['oferta','caracteristica_editar&id_oferta=$this->id&id_caracteristica=$id',['caracteristica_texto'],'caracteristicas',0,0]);\"/>";

		return $o;
	
		
	}
	

	
	
	

	
	
	
	function desplazar() {
		
		if (!$this->id) {
			return acceso_restringido();
		}
		
		
		//activo = $activo AND (fecha_fin >= '$fecha' OR fecha_fin is null)
		$fecha = fecha_hoy();
		if ($this->datos["activo"] && (($this->datos["fecha_fin"] >= '$fecha') || (!$this->datos["fecha_fin"]))) {
			$activo = 1;
			$where = "activo = 1 AND (fecha_fin >= '$fecha' OR fecha_fin is null)";
		} else {
			$activo = 0;
			$where = "activo = 0 AND fecha_fin < '$fecha'";
		}
		
		
		$this->id_carta = $this->datos["id_carta"];
		
		if ($_REQUEST["desp"] == 1) {
			
			$orden_nuevo = $this->datos["orden"] + 1;
			
			$q = "SELECT id, orden FROM oferta WHERE orden > " . $this->datos["orden"] . " AND $where ORDER BY orden DESC LIMIT 1";
			$r = mysql_query($q);
				
			if (mysql_num_rows($r)) {
				$fila = mysql_fetch_array($r);
				
				$q = "UPDATE oferta
						SET orden = " . $this->datos["orden"] . "
						WHERE " . $fila["id"];
				mysql_query($q);
				
				$q = "UPDATE oferta 
						SET orden = " . $fila["orden"] . "
						WHERE id = $this->id";
				mysql_query($q);
					
			}
				
				
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $this->datos["orden"] - 1;
			
			if ($this->datos["orden"] > 1) {
				
				$q = "SELECT id, orden FROM oferta WHERE orden < " . $this->datos["orden"] . " AND $where ORDER BY orden DESC LIMIT 1";
				$r = mysql_query($q);
					
				if (mysql_num_rows($r)) {
					
					$fila = mysql_fetch_array($r);
					
					$q = "UPDATE oferta
						SET orden = " . $this->datos["orden"] . "
						WHERE id = " . $fila["id"];
					mysql_query($q);
 				
					$q = "UPDATE oferta
							SET orden = " . $fila["orden"] . "
							WHERE id = $this->id";
					mysql_query($q);
					
				}
				
			}
			
		}
		
		
		return $this->tabla();
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function detalle() {
		
		if (!$this->id) {
			return;
		}
		
		$q = "SELECT * FROM oferta_detalle WHERE id_oferta = $this->id ORDER BY orden";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$o .= "<ul class='sq'>";
			while ($fila = mysql_fetch_array($r)) {
				if ($fila["precio"]) {
					$precio = ": " . $fila["precio"];
				}
				$o .= "<li class='sq'>" . $fila["texto"] . " $precio
					<span class='a' onclick=\"modulo(['oferta','detalle_editar','&id_oferta=$this->id&id_detalle=" . $fila["id"] . "', 'detalle_editar',0,0]);\">editar</span>
					<span class='a' onclick=\"modulo(['oferta','detalle_desplazar','&desp=-1&id_detalle=" . $fila["id"] . "', 'detalle',0,0]);\">subir</span>
					<span class='a' onclick=\"modulo(['oferta','detalle_desplazar','&desp=1&id_detalle=" . $fila["id"] . "', 'detalle',0,0]);\">bajar</span>
					<span class='a' onclick=\"confirmacion(['Borrar detalle " . $fila["texto"] . "', 'oferta','detalle_borrar','&id_detalle=" . $fila["id"] . "', 'detalle',0,0]);\">borrar</span>
					</li>
				";
			}
		}
		return $o;
	}
	
	
	
	
	function detalle_borrar() {
		
		if ($_REQUEST["id_detalle"] && is_numeric($_REQUEST["id_detalle"])) {
			$id = $_REQUEST["id_detalle"];
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "SELECT orden, id_oferta FROM oferta_detalle WHERE id = $id";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$orden = mysql_result($r,0,0);
			$this->id = mysql_result($r,0,1);
		} else {
			return "0;Acceso restringido";
		}
		
		$q = "DELETE FROM oferta_detalle WHERE id = $id";
		mysql_query($q);
		
		$q = "UPDATE oferta_detalle SET orden = orden -1 WHERE orden > $orden AND id_oferta = $this->id";
		mysql_query($q);
		
		return "1;" . $this->detalle();
		
	}
	
	
	
	
	
	
	function detalle_desplazar() {

		
		if ($_REQUEST["id_detalle"] && is_numeric($_REQUEST["id_detalle"])) {
			$id = $_REQUEST["id_detalle"];
		} else {
			return acceso_restringido();
		}
		
		$q = "SELECT * FROM oferta_detalle WHERE id = $id";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$fila = mysql_fetch_array($r);
		} else {
			return acceso_restringido();
		}
		
		
		$this->id = $fila["id_oferta"];
		
		if ($_REQUEST["desp"] == 1) {
			
			$orden_nuevo = $fila["orden"] + 1;
			
			$q = "SELECT * FROM oferta_detalle WHERE orden = $orden_nuevo AND id_oferta = $this->id";
			$r2 = mysql_query($q);
			
			if (mysql_num_rows($r2)) {
				$q = "UPDATE oferta_detalle
						SET orden = orden - 1
						WHERE orden = $orden_nuevo AND id_oferta = " . $this->id;
				mysql_query($q);
				
				$q = "UPDATE oferta_detalle
						SET orden = $orden_nuevo
						WHERE id = $id";
				mysql_query($q);
				
			}
			
			
		} else if ($_REQUEST["desp"] == -1) {
			
			$orden_nuevo = $fila["orden"] - 1;
			
			if ($fila["orden"] > 1) {
				$q = "UPDATE oferta_detalle
						SET orden = orden + 1
						WHERE orden = $orden_nuevo AND id_oferta = $this->id";
				mysql_query($q);
 				
				$q = "UPDATE oferta_detalle
						SET orden = $orden_nuevo
						WHERE id = $id";
				mysql_query($q);

			}
			
		}
		
		return $this->detalle();
	}
	
		
	
	
	
	
	
	function detalle_editar() {
		
		if (!$this->id) {
			return acceso_restringido();
		}

		if ($_REQUEST["id_detalle"] && is_numeric($_REQUEST["id_detalle"])) {
			$id = $_REQUEST["id_detalle"];
			
			$q = "SELECT * FROM oferta_detalle WHERE id = $id";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)) {
				$fila = mysql_fetch_array($r);
			}
		} 
		
		if ($_REQUEST["grabar"]) {
			
			if (!$_REQUEST["precio"] && !is_numeric($_REQUEST["precio"])) {
				$_REQUEST["precio"] = 0;
			}
			
			if ($id) {
				$q = "UPDATE oferta_detalle 
						SET texto = '" . utf8_decode($_REQUEST["detalle_texto"]) . "',
							precio = '" . $_REQUEST["precio"] . "'
						WHERE id = $id";
			} else {
				$q = "SELECT orden FROM oferta_detalle WHERE id_oferta = $this->id ORDER BY orden DESC LIMIT 1";
				$r = mysql_query($q);
				
				if (mysql_num_rows($r)) {
					$orden = mysql_result($r,0,0) + 1;
				} else {
					$orden = 1;
				}
				
				$q = "INSERT INTO oferta_detalle 
						(id_oferta, texto, orden, 
							precio)
						VALUES ($this->id, '" . utf8_decode($_REQUEST["detalle_texto"]) . "', $orden, 
							'" . $_REQUEST["precio"] . "')";
				
			}
			
			mysql_query($q);
				
			return $this->detalle();
							
		}
		
		$o .= "Texto: <input type='text' name='detalle_texto' id='detalle_texto' value='" . $fila["texto"] . "'/><br/>
			   Precio: <input type='text' name='precio' id='precio' value='" . $fila["precio"] . "'/><br/>
			<input type='button' value='GRABAR' onclick=\"formulario2(['oferta','detalle_editar&id_oferta=$this->id&id_detalle=$id',['detalle_texto','precio'],'detalle',0,0]);\"/>";

		return $o;
	
		
	}
	

	
	
	

	
	
	
	
	
	
	function editar() {

		if ($_REQUEST["id_oferta"]) {
			if (is_numeric($_REQUEST["id_oferta"])) {
				$this->id = $_REQUEST["id_oferta"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		} else {
			
		}
		
		$o .= "
			<input type='button' class='$clase_general' value='DATOS' onclick=\"modulo(['oferta', 'editar', '&id_carta=$this->id_carta&id_oferta=$this->id&modo=general', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			<input type='button' class='$clase_imagenes' value='IMAGEN' onclick=\"modulo(['oferta', 'editar', '&id_carta=$this->id_carta&id_oferta=$this->id&modo=imagenes', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			";
		
		$o .= "
			<input type='button' value='GRABAR' onclick=\"formulario(['oferta', 'editar&id_carta=$this->id_carta&id_oferta=$this->id&grabar=1', 'form_oferta', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
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
					'nombre' => array 	('string',1),
					'texto' => array 	('string',0),
					'fecha_fin' => array ('date',0),
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
			
				$post->valores["fecha"] = fecha_hoy();
				
				$q = $post->consulta($this->id,'oferta','', $extra, 'id');
				mysql_query($q);
				
				if (!$this->id) {
					$this->id = mysql_insert_id();
					$this->recuperar();
					
					$q = "UPDATE oferta SET orden = orden + 1 WHERE orden > 0";
					mysql_query($q);
					
					$q = "UPDATE oferta SET orden = 1 WHERE id = " . $this->id;
					mysql_query($q);
					
					loggear("oferta - alta - $this->id - " . $this->datos["titulo"]);
				} else {
					loggear("oferta - edición - $this->id - " . $this->datos["titulo"]);
				}
				
				$o .= "Oferta grabada correctamente.";
				
				return $o;
			}	
		}
		
		if ($this->datos["activo"]) {
			$activo = "checked";
		} else {
			if ($this->id) {
				$activo = "";
			} else {
				$activo = "checked";
			}
		}
		
		
		
		$o .= "
			<form id='form_oferta'  onsubmit=\"return false;\">
			";
			
			
		$o .= "
		
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Activa:</strong>
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
				 	<strong>Fecha final: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' class='fecha' id='fecha_fin' name='fecha_fin' value='" . fecha($this->datos["fecha_fin"]) . "'/>
				 </div>
				 <div style='clear: both;'></div>
				</div>
				
				
				";
		
		if ($this->id) {
			$o .= "
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Detalle: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<div id='detalle'>" . $this->detalle() . "</div>
					<span class='a' onclick=\"modulo(['oferta','detalle_editar','&id_oferta=$this->id','detalle_editar',0,0]);\">añadir detalle</span>
					<div id='detalle_editar'></div>
				 </div>
				 <div style='clear: both;'></div>
				</div>
			
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Características: </strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<div id='caracteristicas'>" . $this->caracteristicas() . "</div>
					<span class='a' onclick=\"modulo(['oferta','caracteristica_editar','&id_oferta=$this->id','caracteristica_editar',0,0]);\">añadir característica</span>
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
			<input type='button' value='GRABAR' onclick=\"formulario(['oferta', 'editar&id_carta=$this->id_carta&id_oferta=$this->id&grabar=1', 'form_oferta', 'bloque2_trabajo', 0, $this->id_carta]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			
			<div style='clear:both;'></div>
			<script>
				ckeditor_destruir();
				CKEDITOR.replace('texto');
				$.datepicker.setDefaults( $.datepicker.regional[ 'es' ] );
				$('input.fecha').datepicker({ dateFormat: 'dd/mm/yy', firstDay: 1 });
			</script>
			";
		
		return $o;
	
	}
	
	
	
	
	
	
	
	function editar_imagenes() {
	
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
					'ajax.php?objeto=imagen&funcion=subir&id=$this->id&id_imagen_tipo=5&id_relacionada=$this->id&nuevo=1&nombre=imagen', 
					'ajax.php?objeto=oferta&funcion=editar_imagenes_bloque&id=" . $this->id . "&nuevo=1', 
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
				WHERE id_imagen_tipo = 5 AND id_relacionada = " . $this->id;
		$r = mysql_query($q);

		if (mysql_num_rows($r)) {
		
			include_once("imagen.php");
			$imagen = new imagen();
			
			while ($imagen->datos = mysql_fetch_array($r)) {
				$imagen->id = $imagen->datos["id"];
				
				if ($imagen->id == $this->datos["id_imagen"]) {
					$principal = "checked";
				} else {
					$principal = "";
				}
				$o .= "<div style='float:left;'><div class='thumb_visor'>" . $imagen->thumb(0,0) . "</div>";
				$o .= "<div style='text-align:center;'>";
				$o .= " <span class='a' onclick=\"confirmacion(['Borrar imagen', 'imagen','borrar', '&id_imagen=$imagen->id&id_imagen_tipo=5&id_relacionada=$this->id', 'tabla_imagen',0,0]);\">borrar</span>";
				$o .= "</div>";
				$o .= "</div>";
				
			}
			
			 
			
		}
		
		return $o;
		
	}
	
	
	
	
	
	function imagen_principal() {
		$q = "UPDATE oferta SET id_imagen = " . $_REQUEST["id_imagen"] . " WHERE id = $this->id";
		mysql_query($q);
	}
	
	
	
	
	
	
	function plantilla() {

		if (!$this->id) {
			return;
		}
		
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar();
		
		$o .= "
			<div class='cursor flecha_volver' onclick=\"ofertas_boton(0,'');\"></div>
				<div class='oferta_foto'>
					" . $imagen->ver(209, 397) . "
				</div>
				
				<div class='oferta_bloque_der'>
					<div class='fondo2 oferta_descripcion'>
						<div class='oferta_descripcion_inner'>
							<h2>" . $this->datos["nombre"] . "</h2>
							<div style='height: 23px;'></div>
							" . $this->datos["texto"] . "
							<div style='height: 23px;'></div>
							" . $this->plantilla_detalle() . "
						</div>
					</div>
					<div class='fondo3 oferta_caracteristicas'>
						<div class='oferta_caracteristicas_inner'>
							" . $this->plantilla_caracteristicas() . "
						</div>
						<div class='oferta_caracteristicas_texto'>
							Oferta v&aacute;lida hasta el " . fecha($this->datos["fecha_fin"]) . ". M&aacute;s informaci&oacute;n: info@almazaradevaldeverdeja.com
						</div>
					</div>
				</div>
				";
		
		
				
		return $o;	
		
		
	}
	
	
	
	function plantilla_caracteristicas() {

		$q = "SELECT * FROM oferta_caracteristica WHERE id_oferta = $this->id ORDER BY orden";
		$r = mysql_query($q);
		
		if ($num = mysql_num_rows($r)) {
			$num = ceil($num / 2);
			
			$o .= "<div class='oferta_caracteristica'><ul class='caracteristicas'>";
			$i = 0;
			while ($fila = mysql_fetch_array($r)) {
				if ($i == $num) {
					$o .= "</ul></div><div class='oferta_caracteristica'><ul class='caracteristicas'>";
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
	
	
	
	function plantilla_detalle() {

		$q = "SELECT * FROM oferta_detalle WHERE id_oferta = $this->id ORDER BY orden";
		$r = mysql_query($q);
		
		if ($num = mysql_num_rows($r)) {
			
			$o .= "<div class='oferta_detalle'><ul>";
			while ($fila = mysql_fetch_array($r)) {
				
				if ($fila["precio"]) {
					$precios .= $fila["precio"] . "&euro;<div style='height: 6px;'></div>";
					$puntos = ":";
				}
				$o .= "<li class='detalle'>" . $fila["texto"] . "$precio</li>";
			}
			$o .= "</ul></div>
				<div class='oferta_precios'>$precios</div>
				
				<div class='clear'></div>";
		}
	
		return $o;
		
	}	
	
	
	
	function plantilla_resumen() {
		
		if (!$this->id) {
			return;
		} 
		
		include_once("imagen.php");
		$imagen = new imagen();
		$imagen->id = $this->datos["id_imagen"];
		$imagen->recuperar();
		
		$o .= "
		<div class='oferta_resumen fondo1'>
			<div class='oferta_resumen_foto'>" . $imagen->thumb(110,72) . "</div>
			<div class='oferta_resumen_descripcion'>
				" . $this->datos["nombre"] . "
				<div style='height: 16px;'></div>
				<div class='oferta_resumen_texto'>" . $this->datos["texto"] . "</div>
			</div>
		</div>
		<div class='cursor oferta_resumen_flecha' onclick=\"ofertas_boton(1,$this->id);\"></div>
		";
		
		return $o;
		
	}
	
	
	
	
	function recuperar() {
		if ($this->id) {
			$q = "SELECT * FROM $this->tabla WHERE id = $this->id";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)){
				$this->datos = mysql_fetch_assoc($r);	
			}
		} else {
			$this->datos = "";
		}
		
	}
	
	
	
	
	
	
	
	

	function tabla() {

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}

		if (isset($_REQUEST["activo"]) && ($_REQUEST["activo"] == 0)) {
			$activo = 0;
			$boton_activo = "<input type='button' value='VER ACTIVAS' onclick=\"modulo(['oferta', 'tabla', '&activo=1', 'tabla_oferta', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_oferta = "INACTIVAS";
		} else {
			$activo = 1;
			$boton_activo = "<input type='button' value='VER INACTIVOS' onclick=\"modulo(['oferta', 'tabla', '&activo=0', 'tabla_oferta', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$activo_oferta = "ACTIVAS";
		}
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
		
		$fecha = fecha_hoy();
		
		if ($activo) {
			$q = "SELECT * 
				FROM oferta 
				WHERE activo = $activo AND (fecha_fin >= '$fecha' OR fecha_fin is null)
				ORDER BY orden ";
		} else {
			$q = "SELECT * 
				FROM oferta 
				WHERE activo = $activo OR fecha_fin < '$fecha'
				ORDER BY orden ";
			
		}
		$r = mysql_query($q);
		
		$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='button' value='NUEVA OFERTA' onclick=\"modulo(['oferta', 'editar', '', 'bloque2_trabajo', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
				$boton_activo
			";
		
		$o .= "<h3>OFERTAS $activo_oferta</h3><br/>";
		
		if (mysql_num_rows($r)) {
			$i = 0;
			
			$o .= "
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 50%;'>
					OFERTA
				</div>
				<div class='tabla_th' style='width: 20%;'>
					F.FIN
				</div>
				<div class='tabla_th' style='width: 30%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($this->datos = mysql_fetch_array($r)) {
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
			$o .= error("No hay elementos en la sección.");
		}
		
		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		
		$o .= "
			<div class='tabla_td' style='width: 48%;'>
				" . $this->datos["nombre"] . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 18%;'>
				" . fecha($this->datos["fecha_fin"]) . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 28%; text-align: right;'>
				<span class='a' onclick=\"modulo(['oferta', 'editar', '&id_oferta=$this->id', 'bloque2_trabajo', 0,0]);\">editar</span>
				<span class='a' onclick=\"modulo(['oferta','desplazar','&id_oferta=$this->id&desp=-1', 'tabla_oferta',0,0]);\">subir</span>
				<span class='a' onclick=\"modulo(['oferta','desplazar','&id_oferta=$this->id&desp=1', 'tabla_oferta',0,0]);\">bajar</span>
				<span class='a' onclick=\"confirmacion(['Borrar oferta','oferta', 'borrar', '&id_oferta=$this->id', 'tabla_oferta', 0, 0]);\">borrar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
		
}

?>