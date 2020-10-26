<?php
require_once "modules/configuracion/model.php";
require_once "modules/configuracion/view.php";


class ConfiguracionController {

	function __construct() {
		$this->model = new Configuracion();
		$this->view = new ConfiguracionView();
	}

	function panel() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
    	$configuracion_collection = Collector()->get('Configuracion');
		$this->view->panel($configuracion_collection);
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
		$this->model->configuracion_id = $arg;
		$this->model->get();
		$configuracion_collection = Collector()->get('Configuracion');
		$this->view->editar($configuracion_collection, $this->model);
	}
}
?>