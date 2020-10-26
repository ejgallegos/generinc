<?php
require_once "modules/gerencia/model.php";
require_once "modules/gerencia/view.php";


class GerenciaController {

	function __construct() {
		$this->model = new Gerencia();
		$this->view = new GerenciaView();
	}

	function panel() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$gerencia_collection = Collector()->get('Gerencia');
		$this->view->panel($gerencia_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
        $mensaje = ($_POST["gerencia_id"] != 0) ? "Modificación: Gerencia." : "Alta: Gerencia.";
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
        $this->model->save();
        saveLog()->save($mensaje);
		header("Location: " . URL_APP . "/gerencia/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$this->model->gerencia_id = $arg;
		$this->model->get();
		$gerencia_collection = Collector()->get('Gerencia');
		$this->view->editar($gerencia_collection, $this->model);
	}
}
?>