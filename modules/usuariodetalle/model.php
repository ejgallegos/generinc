<?php
require_once "modules/centrocosto/model.php";
require_once "modules/unicom/model.php";


class UsuarioDetalle extends StandardObject {
	function __construct(CentroCosto $centrocosto=NULL, Unicom $unicom=NULL) {
		$this->usuariodetalle_id = 0;
		$this->apellido = '';
		$this->nombre = '';
		$this->correoelectronico = '';
		$this->token = '';
		$this->centrocosto = $centrocosto;
		$this->unicom = $unicom;
	}
}
?>