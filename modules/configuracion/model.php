<?php


class Configuracion extends StandardObject {
	
	function __construct() {
		$this->configuracion_id = 0;
		$this->importe_aprobacion = 0.0;
		$this->aprobador_mayor_importe = 0;
		$this->aprobador_menor_importe = 0;
	}
}
?>