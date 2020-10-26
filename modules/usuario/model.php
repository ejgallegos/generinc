<?php
require_once "modules/usuariodetalle/model.php";
require_once "modules/configuracionmenu/model.php";
require_once "modules/nivel/model.php";


class Usuario extends StandardObject {
	
	function __construct(UsuarioDetalle $detalle=NULL, ConfiguracionMenu $configuracionmenu=NULL, Nivel $nivel=NULL) {
		$this->usuario_id = 0;
		$this->denominacion = '';
		$this->nivel = $nivel;
		$this->usuariodetalle = $detalle;
		$this->configuracionmenu = $configuracionmenu;
	}
}
?>