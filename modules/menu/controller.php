<?php
require_once "modules/menu/model.php";
require_once "modules/menu/view.php";
require_once "modules/submenu/model.php";
require_once "modules/item/model.php";
require_once "modules/configuracionmenu/model.php";
require_once "modules/gerencia/model.php";


class MenuController {

	function __construct() {
		$this->model = new Menu();
		$this->view = new MenuView();
	}

	function panel() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$gerencia_collection = Collector()->get('Gerencia');	
		$configuracionmenu_collection = Collector()->get('ConfiguracionMenu');	
		$this->view->panel($configuracionmenu_collection, $gerencia_collection);
	}

	function agregar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$menu_collection = Collector()->get('Menu');
		$submenu_collection = Collector()->get('SubMenu');
		$item_collection = Collector()->get('Item');
		$this->view->agregar($menu_collection, $submenu_collection, $item_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$this->model->menu_id = $arg;
		$this->model->get();
		$menu_collection = Collector()->get('Menu');
		$submenu_collection = Collector()->get('SubMenu');
		$item_collection = Collector()->get('Item');
		$this->view->editar($this->model, $menu_collection, $submenu_collection, $item_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		foreach ($_POST as $clave=>$valor) $this->model->$clave = $valor;
		$this->model->save();
		header("Location: " . URL_APP . "/menu/agregar");
	}

	function eliminar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();

		$this->model->menu_id = $arg;
		$this->model->delete();
		header("Location: " . URL_APP . "/menu/agregar");
	}

}
?>