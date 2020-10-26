<?php
require_once "modules/usuario/model.php";
require_once "modules/usuario/view.php";
require_once "modules/usuariodetalle/controller.php";
require_once "modules/centrocosto/model.php";
require_once "modules/unicom/model.php";
require_once "modules/configuracionmenu/model.php";
require_once 'core/helpers/user.php';


class UsuarioController {

	function __construct() {
		$this->model = new Usuario();
		$this->view = new UsuarioView();
	}

	function login($arg=0) {
		if($_SESSION['login' . APP_ABREV] !== true) {
				$this->view->login($arg);
		}else {
			header("Location: " . URL_APP . "/usuario/panel");
		}
	}

	function checkin() {
        SessionHandler()->checkin();
    }

	function checkout() {
        SessionHandler()->checkout();
    }

    function agregar() {
    	SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$usuario_collection = Collector()->get('Usuario');
		$centrocosto_collection = Collector()->get('CentroCosto');
		$unicom_collection = Collector()->get('Unicom');
		$configuracionmenu_collection = Collector()->get('ConfiguracionMenu');
		$this->view->agregar($usuario_collection, $centrocosto_collection, $unicom_collection, $configuracionmenu_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$detalle = new UsuarioDetalleController();
        $detalle->guardar();
        $this->model->denominacion = filter_input(INPUT_POST, "denominacion");
        $this->model->nivel = filter_input(INPUT_POST, "nivel");
        $this->model->configuracionmenu = filter_input(INPUT_POST, "configuracionmenu");
        $this->model->usuariodetalle = $detalle->model->usuariodetalle_id;
        $this->model->save();
		header("Location: " . URL_APP . "/usuario/agregar");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$this->model->usuario_id = $arg;
		$this->model->get();
		$usuario_collection = Collector()->get('Usuario');
		$centrocosto_collection = Collector()->get('CentroCosto');
		$unicom_collection = Collector()->get('Unicom');
		$configuracionmenu_collection = Collector()->get('ConfiguracionMenu');
		$this->view->editar($usuario_collection, $centrocosto_collection, $unicom_collection, $configuracionmenu_collection, $this->model);
	}

	function actualizar() {
		SessionHandler()->check_session();
		//SessionHandler()->check_admin_level();
		$detalle = new UsuarioDetalleController();
        $detalle->actualizar();
        $this->model->usuario_id = filter_input(INPUT_POST, "usuario_id");
        $this->model->get();
        $this->model->nivel = filter_input(INPUT_POST, "nivel");
        $this->model->configuracionmenu = filter_input(INPUT_POST, "configuracionmenu");
		$this->model->save();
		header("Location: " . URL_APP . "/usuario/agregar");
	}

	function actualizar_token() {
		SessionHandler()->check_session();
		$this->model->usuario_id = $_POST["usuario_id"];
		$this->model->get();
		$usuariodetalle_id = $this->model->usuariodetalle->usuariodetalle_id;
		$udc = new UsuarioDetalleController();
        $udc->actualizar_token($usuariodetalle_id);
		header("Location: " . URL_APP . "/usuario/perfil");
	}

	function eliminar($arg) {
		$this->model->usuario_id = $arg;
		$this->model->get();

		$usuariodetalle_id = $this->model->usuariodetalle->usuariodetalle_id;
		$udc = new UsuarioDetalleController();
		$udc->eliminar($usuariodetalle_id);
		$this->model->delete();
		header("Location: " . URL_APP . "/usuario/agregar");
	}

	function regenerar_token($arg) {
		SessionHandler()->check_session();
		$this->model->usuario_id = $arg;
		$this->model->get();
		$detalle = new UsuarioDetalleController();
        $detalle->regenerar_token($this->model->usuariodetalle->usuariodetalle_id,
        						  $this->model->denominacion);
		header("location:" . URL_APP . "/usuario/agregar");
	}

	function perfil() {
		SessionHandler()->check_session();
		$this->view->perfil();
	}

	function informar_clave() {
		SessionHandler()->check_session();
		$usuario_collection = Collector()->get("Usuario");
		$usuario_temp = array();
		foreach ($usuario_collection as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array("{usuario-nombre}"=>$valor->usuariodetalle->nombre,
								"{usuario-usuario}"=>$valor->denominacion,
								"{usuario-contraseña}"=>$valor->denominacion . "$1",
								"usuario_correo"=>$valor->usuariodetalle->correoelectronico);
			$usuario_temp[] = $array_temp;

		}

		$emailHelper = new EmailUsuario();
		$emailHelper->envia_email_usuario($usuario_temp);
	}

	function panel() {
		SessionHandler()->check_session();
		$usr_nivel = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"];
		$panel = SessionHandler()->check_panel($usr_nivel);
		$this->$panel();
	}

	function administrador() {
		SessionHandler()->check_session();
		$perfil_id = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"];
		$gerencia_id = $_SESSION["data-login-" . APP_ABREV]["usuariodetalle-gerencia_id"];
		//$this->view->administrador();
		$this->perfil();
	}

	function operador() {
		$this->perfil();
	}

	function desarrollador() {
		$this->perfil();
	}

	function recuperar_contrasena() {
		$usuario = filter_input(INPUT_POST, "usuario");
		$usuario_id = User::get_id_from_usuario($usuario);

		if ($usuario_id == 0) {
			header("Location: " . URL_APP . "/usuario/login/ePass");
		} else {
			$this->model->usuario_id = $usuario_id;
			$this->model->get();
			unset($this->model->configuracionmenu);
			$new_password = substr(md5(rand()),0,8);

			$denominacion = hash(ALGORITMO_USER, $usuario);
			$password = hash(ALGORITMO_PASS, $new_password);
			$token = hash(ALGORITMO_FINAL, $denominacion . $password);

			$usuariodetalle_id = $this->model->usuariodetalle->usuariodetalle_id;
			$udm = new UsuarioDetalle();
			$udm->usuariodetalle_id = $usuariodetalle_id;
			$udm->get();
			$udm->token = $token;
			$udm->save();

			$toolRePass = new RePass();
			$toolRePass->actualizaContrasena($this->model, $new_password);
			header("Location: " . URL_APP . "/usuario/login/okPass");
		}
	}
}
?>
