<?php
require_once "modules/nivel/model.php";
require_once "modules/nivel/view.php";


class NivelController {

	function __construct() {
		$this->model = new Nivel();
		$this->view = new NivelView();
	}

	function panel() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
    	$nivel_collection = Collector()->get('Nivel');
		$this->view->panel($nivel_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$mensaje = ($_POST["nivel_id"] != 0) ? "Modificación: NIVEL." : "Alta: NIVEL.";
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
        $this->model->save();
        saveLog()->save($mensaje);
		header("Location: " . URL_APP . "/nivel/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$this->model->nivel_id = $arg;
		$this->model->get();
		$nivel_collection = Collector()->get('Nivel');
		$this->view->editar($nivel_collection, $this->model);
	}
}
?>