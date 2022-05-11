<?php

class texto {
	
	public $id;
	public $id_web;
	public $datos;
	
	private $tabla = "texto";
	
	
	
	function __construct() {
		
		$this->id_web = $GLOBALS["id_web"];
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
		
	}
	
	
	
	
	
	
	
	
	

	
	function editar() {

		if ($_REQUEST["id_texto"]) {
			if (is_numeric($_REQUEST["id_texto"])) {
				$this->id = $_REQUEST["id_texto"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		} else {
			
		}
		
		
		
		$o .= "
			<input type='button' value='Grabar' onclick=\"formulario(['texto', 'editar&id_texto=$this->id&grabar=1', 'form_texto', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			
			<input type='button' class='$clase_general' value='DATOS' onclick=\"modulo(['texto', 'editar', '&id_texto=$this->id&modo=general', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			<input type='button' class='$clase_imagenes' value='IM&Aacute;GENES' onclick=\"formulario(['texto', 'editar&id_texto=$this->id&grabar=1', 'form_texto', 'temp', 0, 0]);modulo(['texto', 'editar', '&id_texto=$this->id&modo=imagenes', 'bloque2_trabajo', 0, 0]);\" style='float: left; margin: 5px 2px 0px 2px;'/>
			
			<div style='clear:both;'></div>";
			
			
		if ($_REQUEST["modo"]) {
			$modo = $_REQUEST["modo"];
		} else {
			$modo = "general";
		}
		
		$clase = "clase_$modo";
		$$clase = "activo";			
		
		
		$editar = "editar_$modo";
		$o .= $this->$editar(); 
		
		
			
		
		
		return $o;
	}
	
	
	
	
	
	
	
	
	function editar_general() {
	
	
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'id_seccion' => array ('int',0),
					'nombre' => array 	('string',0),
					'titulo' => array 	('string',0),
					'texto' => array 	('string',0)
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
			
				if ($post->valores["id_seccion"]) {
					$q = $post->consulta($this->id,'texto','', $extra, 'id');
					mysql_query($q);
					
					if (!$this->id) {
						$this->id = mysql_insert_id();
						$this->recuperar();
						loggear("texto - alta - $this->id - " . $this->datos["titulo"]);
					} else {
						loggear("texto - edición - $this->id - " . $this->datos["titulo"]);
					}
				}
				
				$o .= "Texto grabado correctamente.";
				
				return $o;
			}	
		}
		
		
		include_once("seccion.php");
		$seccion = new seccion();
		$seccion->id = $this->datos["id_seccion"];
		
		$o .= "
			<form id='form_texto'  onsubmit=\"formulario(['texto', 'editar&id_texto=$this->id&grabar=1', 'form_texto', 'bloque2_trabajo', 0, 1]);\" >
			";
			
			
		$o .= "
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Secci&oacute;n:</strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					" . $seccion->select() . "
				 </div>
				 <div style='clear: both;'></div>
				</div>
				
				<div class='tabla_tr'>
				 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
				 	<strong>Nombre:</strong>
				 </div>
				 <div class='tabla_td' style='width: 73%;'>
					<input type='text' class='todo' id='nombre' name='nombre' value='" . texto_form($this->datos["nombre"]) . "'/>
					";
		if($this->id) {
			$o .= "	<i>en general no se debe cambiar, pues es para uso interno de la web</i>";
		}
		
		$o .= "
				 </div>
				 <div style='clear: both;'></div>
				</div>
			";
			
		$o .= "
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
			 	<strong>T&iacute;tulo:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='text' class='todo' id='titulo' name='titulo' value='" . texto_form($this->datos["titulo"]) . "'/>
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
			<input type='button' value='Grabar' onclick=\"formulario(['texto', 'editar&id_texto=$this->id&grabar=1', 'form_texto', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>
			<script>
					if (editor[0]) {
						CKEDITOR.remove(editor[0]);
					}
					editor[0] = CKEDITOR.replace( 'texto');
			</script>
			";
		
		return $o;
	
	}
	
	
	
	
	
	
	
	
	
	
	

	
	

	
	function editar_imagenes() {
	
		if (!$this->id) {
			$o .= "<br/>Para editar la imagen principal es necesario primero guardar el texto.";
			return $o;
		}

		$uid = uniqid();
		
		$o .= "
			
		<div style='clear: both; height: 10px;'></div>
		
			<form action='ajax.php' method='post' id='uploadform' enctype='multipart/form-data' onsubmit='beginUpload(\"$uid\", \"imagen_bar\");'>
				<div style='float: left;'>
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
					'ajax.php?objeto=imagen&funcion=subir&id=$this->id&id_imagen_tipo=3&id_relacionada=$this->id&nuevo=1&nombre=imagen', 
					'ajax.php?objeto=texto&funcion=editar_imagenes_bloque&id_texto=" . $this->id . "&nuevo=1', 
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
			if ($_REQUEST["id_texto"] && is_numeric($_REQUEST["id_texto"])) {
				$this->id = $_REQUEST["id_texto"];
			} else {
				return acceso_restringido();
			}
		}
		
		
		
		$q = "SELECT *  
				FROM imagen  
				WHERE id_imagen_tipo = 3 
					AND id_relacionada = " . $this->id . "
				ORDER BY orden";
		$r = mysql_query($q);

		if (mysql_num_rows($r)) {
		
			include_once("imagen.php");
			$imagen = new imagen();
			$o .= "Im&aacute;genes: <br/><br/> ";
			
			while ($imagen->datos = mysql_fetch_array($r)) {
				$imagen->id = $imagen->datos["id"];
				$o .= "<div style='float: left;'><div class='thumb_visor'>" . $imagen->thumb() . "</div><br/>";
				$o .= "<div style='text-align:center;'>";
				$o .= " <span class='a' onclick=\"modulo(['imagen','desplazar', '&id_imagen_tipo=3&id_relacionada=$this->id&id_imagen=$imagen->id&desp=-1', 'tabla_imagen',0,0]);\">subir</span>";
				$o .= " <span class='a' onclick=\"modulo(['imagen','desplazar', '&id_imagen_tipo=3&id_relacionada=$this->id&id_imagen=$imagen->id&desp=1', 'tabla_imagen',0,0]);\">bajar</span>";
				$o .= " <span class='a' onclick=\"confirmacion(['Borrar imagen', 'imagen','borrar', '&id_imagen=$imagen->id', 'tabla_imagen',0,0]);\">borrar</span>";
				$o .= "</div>";
				$o .= "</div>";
			} 
			
		}
		
		return $o;
		
	}
	
	
	
	
		
	
	
	
	function imagen($width, $height) {
		
		if (!$this->id) {
			return;
		}
		
		include_once("imagen.php");
		$imagen = new imagen();
		
		$args = func_get_args();
		$extra = $args[2];
		$no_slide = $args[3];
		
		$q = "SELECT *
			 FROM imagen
			 WHERE id_imagen_tipo = 3 AND id_relacionada = $this->id 
			 ORDER BY orden";
		$r = mysql_query($q);
		
		
		if (mysql_num_rows($r)) {
			$i = 0;
			while ($imagen->datos = mysql_fetch_array($r)) {
				$imagen->id = $imagen->datos["id"];
				$o .= $imagen->thumb($width,$height);
				$i += 1;
			}
		}
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
		
	
	function permiso() {
		
		if ($GLOBALS["usuario"]->id_usuario) {
			return 1;
		}
		
	}
	
	
	
	
	
	
		
	
	
	function plantilla() {
		
		$o .= "<strong>" . $this->datos["nombre"] . "</strong> <br/>
			<br/>
			<strong>T&iacute;tulo: </strong>
			" . $this->datos["titulo"] . " <br/><br/>
			
			<strong>Texto: </strong><br/>
			" . $this->datos["texto"] . " <br/><br/>";
		
		return $o;
		
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
	
	
	
	
	
	
	
	

	
	
	function tabla() {

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		include_once 'seccion.php';
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
		
		
		$q = "SELECT texto.id 
				FROM texto 
					LEFT JOIN seccion ON seccion.id = texto.id_seccion 
				ORDER BY seccion.nombre, texto.nombre";
		$r = mysql_query($q);
		
		$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='button' value='NUEVO' onclick=\"modulo(['texto', 'editar', '', 'bloque2_trabajo', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
		";
		
		if (mysql_num_rows($r)) {
			$i = 0;
			
			$o .= "
			
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 35%;'>
					SECCI&Oacute;N
				</div>
				<div class='tabla_th' style='width: 35%;'>
					NOMBRE
				</div>
				<div class='tabla_th' style='width: 30%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($fila = mysql_fetch_array($r)) {
				if (($i % 2) == 0) {
					$clase = "tabla_par";
				} else {
					$clase = "tabla_impar";
				}
				
				$this->id = $fila[0];
				$this->recuperar();
				$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
				$i += 1;
			}
			
		} else {
			$o .= error("No hay textos.");
		}
		
		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		
		if ($this->datos["id_seccion"]) {
			$seccion = new seccion();
			$seccion->id = $this->datos["id_seccion"];
			$seccion->recuperar();
			$seccion_nombre = $seccion->datos["nombre"];
		} else {
			$seccion_nombre = "general";
		}
		
		
		

		$o .= "
			<div class='tabla_td' style='width: 33%;'>
				" . $seccion_nombre . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 33%;'>
				" . $this->datos["nombre"] . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 28%; text-align: right;'>
				<span class='a' onclick=\"modulo(['texto', 'plantilla', '&id_texto=$this->id', 'bloque2_trabajo', 0,0]);\">ver</span>
				<span class='a' onclick=\"modulo(['texto', 'editar', '&id_texto=$this->id', 'bloque2_trabajo', 0]);\">editar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
	

	
	
	
	
	function texto($sec, $nombre) {
		
		include_once("seccion.php");
		$seccion = new seccion();
		$seccion->seccion($sec);
		
		if (!$seccion->id) {
			return;
		}
		
		$q = "SELECT * FROM texto WHERE id_seccion = $seccion->id AND nombre = '$nombre'";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$this->datos = mysql_fetch_array($r);
			$this->id = $this->datos["id"];
		}
		
		return $this->datos["texto"];
		
	}
	

	
	
	function titulo($sec, $nombre) {
		
		include_once("seccion.php");
		$seccion = new seccion();
		$seccion->seccion($sec);
		
		if (!$seccion->id) {
			return;
		}
		
		$q = "SELECT * FROM texto WHERE id_seccion = $seccion->id AND nombre = '$nombre'";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$this->datos = mysql_fetch_array($r);
			$this->id = $this->datos["id"];
		}
		
		return $this->datos["titulo"];
		
	}
	
	
	
	
		
}

?>