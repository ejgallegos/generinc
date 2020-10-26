<?php
require_once "modules/unicom/model.php";
require_once "modules/unicom/view.php";


class UnicomController {

	function __construct() {
		$this->model = new Unicom();
		$this->view = new UnicomView();
	}

	function panel() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
    	$unicom_collection = Collector()->get('Unicom');
		$this->view->panel($unicom_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$mensaje = ($_POST["unicom_id"] != 0) ? "Modificación: UNICOM." : "Alta: UNICOM.";
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
        $this->model->save();
        saveLog()->save($mensaje);
		header("Location: " . URL_APP . "/unicom/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$this->model->unicom_id = $arg;
		$this->model->get();
		$unicom_collection = Collector()->get('Unicom');
		$this->view->editar($unicom_collection, $this->model);
	}
}
?>