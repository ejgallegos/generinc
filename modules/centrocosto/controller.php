<?php
require_once "modules/centrocosto/model.php";
require_once "modules/centrocosto/view.php";
require_once "modules/gerencia/model.php";


class CentroCostoController {

	function __construct() {
		$this->model = new CentroCosto();
		$this->view = new CentroCostoView();
	}

	function panel() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$centrocosto_collection = Collector()->get('CentroCosto');
		$gerencia_collection = Collector()->get('Gerencia');
		$this->view->panel($centrocosto_collection, $gerencia_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$mensaje = ($_POST["centrocosto_id"] != 0) ? "Modificación: Centro de Costo." : "Alta: Centro de Costo.";
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
        $this->model->save();
        saveLog()->save($mensaje);
		header("Location: " . URL_APP . "/centrocosto/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$this->model->centrocosto_id = $arg;
		$this->model->get();
		$centrocosto_collection = Collector()->get('CentroCosto');
		$gerencia_collection = Collector()->get('Gerencia');
		$this->view->editar($centrocosto_collection, $gerencia_collection, $this->model);
	}
}
?>