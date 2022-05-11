<?php


	function objeto_valido($objeto,$funcion) {

		$objetos["actividad"]["borrar"] = 1;
		$objetos["actividad"]["desplazar"] = 1;
		$objetos["actividad"]["editar"] = 1;
		$objetos["actividad"]["editar_imagenes_bloque"] = 1;
		$objetos["actividad"]["tabla"] = 1;
		
		$objetos["contacto"]["borrar"] = 1;
		$objetos["contacto"]["respondido"] = 1;
		$objetos["contacto"]["tabla"] = 1;
		$objetos["contacto"]["ver"] = 1;

		
		$objetos["habitacion"]["borrar"] = 1;
		$objetos["habitacion"]["desplazar"] = 1;
		$objetos["habitacion"]["caracteristica_borrar"] = 1;
		$objetos["habitacion"]["caracteristica_desplazar"] = 1;
		$objetos["habitacion"]["caracteristica_editar"] = 1;
		$objetos["habitacion"]["editar"] = 1;
		$objetos["habitacion"]["editar_imagenes_bloque"] = 1;
		$objetos["habitacion"]["imagen_principal"] = 1;
		$objetos["habitacion"]["tabla"] = 1;
				
		$objetos["imagen"]["borrar"] = 1;
		$objetos["imagen"]["borrar_circuito"] = 1;
		$objetos["imagen"]["borrar_destino"] = 1;
		$objetos["imagen"]["buscar"] = 1;
		$objetos["imagen"]["descripcion_grabar"] = 1;
		$objetos["imagen"]["desplazar"] = 1;
		$objetos["imagen"]["editor"] = 1;
		$objetos["imagen"]["editor_grabar"] = 1;
		$objetos["imagen"]["editor_imagen_restablecer"] = 1;
		$objetos["imagen"]["editor_recorte"] = 1;
		$objetos["imagen"]["enlace_grabar"] = 1;
		$objetos["imagen"]["seleccionar"] = 1;
		$objetos["imagen"]["subir"] = 1;
		$objetos["imagen"]["subir_cke"] = 1;
		
		$objetos["imagen"]["editar"] = 1;
		$objetos["imagen"]["tabla"] = 1;
		
		$objetos["oferta"]["borrar"] = 1;
		$objetos["oferta"]["caracteristica_borrar"] = 1;
		$objetos["oferta"]["caracteristica_desplazar"] = 1;
		$objetos["oferta"]["caracteristica_editar"] = 1;
		$objetos["oferta"]["desplazar"] = 1;
		$objetos["oferta"]["detalle_borrar"] = 1;
		$objetos["oferta"]["detalle_desplazar"] = 1;
		$objetos["oferta"]["detalle_editar"] = 1;
		$objetos["oferta"]["editar"] = 1;
		$objetos["oferta"]["editar_imagenes_bloque"] = 1;
		$objetos["oferta"]["imagen_principal"] = 1;
		$objetos["oferta"]["tabla"] = 1;
		
		$objetos["plantilla"]["actividad"] = 1;
		$objetos["plantilla"]["contacto"] = 1;
		$objetos["plantilla"]["habitacion"] = 1;
		$objetos["plantilla"]["login"] = 1;
		$objetos["plantilla"]["oferta"] = 1;
		$objetos["plantilla"]["presentacion"] = 1;
		$objetos["plantilla"]["seccion"] = 1;
		$objetos["plantilla"]["texto"] = 1;
		$objetos["plantilla"]["usuario"] = 1;
		
		$objetos["seccion"]["editar"] = 1;
		$objetos["seccion"]["tabla"] = 1;
		
		$objetos["texto"]["editar"] = 1;
		$objetos["texto"]["editar_imagenes_bloque"] = 1;
		$objetos["texto"]["plantilla"] = 1;
		
		$objetos["usuario"]["borrar"] = 1;
		$objetos["usuario"]["editar"] = 1;

		if ($objetos[$objeto][$funcion]) {
			return 1;
		} else {
			return 0;
		}
		
		
	}



?>