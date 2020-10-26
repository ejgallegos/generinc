<?php
require_once "modules/nivelpropiedad/model.php";


class NivelPropiedadController {

	function __construct() {
		$this->model = new NivelPropiedad();
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$mensaje = ($_POST["nivelpropiedad_id"] != 0) ? "Modificación: NIVELPROPIEDAD." : "Alta: NIVELPROPIEDAD.";
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
        $this->model->save();
        saveLog()->save($mensaje);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$this->model->nivelpropiedad_id = $arg;
		$this->model->get();
		$nivelpropiedad_collection = Collector()->get('NivelPropiedad');
		$this->view->editar($nivelpropiedad_collection, $this->model);
	}
}
?>