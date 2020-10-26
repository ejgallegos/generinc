<?php


class UsuarioView extends View {

	function login($arg) {
		$template = $this->render_login();
		switch ($arg) {
			case 'mError':
				$gui_mError = file_get_contents("static/modules/usuario/mError.html");
				$mensaje = "Los datos ingresados no son correctos! Por favor intente nuevamente!";
				$template = str_replace("{mensaje}", $mensaje, $template);
				$template = str_replace("{gui_mError}", $gui_mError, $template);
				break;
			case 'ePass':
				$gui_mError = file_get_contents("static/modules/usuario/mError.html");
				$mensaje = "El usuario ingresado no existe en nuestro sistema! Por favor intente nuevamente!";
				$template = str_replace("{mensaje}", $mensaje, $template);
				$template = str_replace("{gui_mError}", $gui_mError, $template);
				break;
			case 'okPass':
				$gui_mError = file_get_contents("static/modules/usuario/mError.html");
				$mensaje = "Su contraseña ha sido generada correctamente y ya fue enviada a su correo electrónico!";
				$template = str_replace("{mensaje}", $mensaje, $template);
				$template = str_replace("{gui_mError}", $gui_mError, $template);
				break;
			default:
				$template = str_replace("{gui_mError}", "", $template);
				break;
		}
		print $template;
	}

	function agregar($usuario_collection, $centrocosto_collection, $unicom_collection, $configuracionmenu_collection) {
		$gui = file_get_contents("static/modules/usuario/agregar.html");
		$gui_slt_unicom = file_get_contents("static/common/slt_unicom.html");
		$gui_slt_centrocosto = file_get_contents("static/common/slt_gerencia_centrocosto.html");
		$gui_slt_configuracionmenu = file_get_contents("static/common/menu/slt_configuracionmenu.html");
		foreach ($usuario_collection as $clave=>$valor) unset($usuario_collection[$clave]->configuracionmenu->submenu_collection,
				  											  $usuario_collection[$clave]->configuracionmenu->item_collection,
				  											  $usuario_collection[$clave]->configuracionmenu->gerencia);

		foreach ($configuracionmenu_collection as $clave=>$valor) unset($valor->item_collection, $valor->submenu_collection);
		$gui_slt_centrocosto = $this->render_regex('SLT_GERENCIA_CENTROCOSTO', $gui_slt_centrocosto, $centrocosto_collection);
		$gui_slt_unicom = $this->render_regex('SLT_UNICOM', $gui_slt_unicom, $unicom_collection);
		$gui_slt_configuracionmenu = $this->render_regex('SLT_CONFIGURACIONMENU', $gui_slt_configuracionmenu, $configuracionmenu_collection);
		$render = $this->render_regex('TABLA_USUARIO', $gui, $usuario_collection);
		$render = str_replace("{slt_centrocosto}", $gui_slt_centrocosto, $render);
		$render = str_replace("{slt_unicom}", $gui_slt_unicom, $render);
		$render = str_replace("{slt_configuracionmenu}", $gui_slt_configuracionmenu, $render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($usuario_collection, $centrocosto_collection, $unicom_collection, $configuracionmenu_collection, $usuario) {
		$gui = file_get_contents("static/modules/usuario/editar.html");
		$gui_slt_unicom = file_get_contents("static/common/slt_unicom.html");
		$gui_slt_centrocosto = file_get_contents("static/common/slt_centrocosto.html");
		$gui_slt_configuracionmenu = file_get_contents("static/common/menu/slt_configuracionmenu.html");
		foreach ($usuario_collection as $clave=>$valor) unset($usuario_collection[$clave]->configuracionmenu->submenu_collection,
				  											  $usuario_collection[$clave]->configuracionmenu->item_collection,
				  											  $usuario_collection[$clave]->configuracionmenu->gerencia);

		foreach ($configuracionmenu_collection as $clave=>$valor) unset($valor->item_collection, $valor->submenu_collection);
		$usuario_nivel = $usuario->nivel;
		unset($usuario->configuracionmenu->submenu_collection, $usuario->configuracionmenu->item_collection);
		$usuario = $this->set_dict($usuario);
		switch ($usuario["{usuario-nivel}"]) {
			case 1:
				$usuario["{nivel-denominacion}"] = "Operador";
				break;
			case 2:
				$usuario["{nivel-denominacion}"] = "Analista";
				break;
			case 3:
				$usuario["{nivel-denominacion}"] = "Administrador";
				break;
			case 9:
				$usuario["{nivel-denominacion}"] = "Desarrollador";
				break;
		}

		$gui_slt_centrocosto = $this->render_regex('SLT_CENTROCOSTO', $gui_slt_centrocosto, $centrocosto_collection);
		$gui_slt_unicom = $this->render_regex('SLT_UNICOM', $gui_slt_unicom, $unicom_collection);
		$gui_slt_configuracionmenu = $this->render_regex('SLT_CONFIGURACIONMENU', $gui_slt_configuracionmenu, $configuracionmenu_collection);
		$render = $this->render_regex('TABLA_USUARIO', $gui, $usuario_collection);
		$render = str_replace("{slt_centrocosto}", $gui_slt_centrocosto, $render);
		$render = str_replace("{slt_unicom}", $gui_slt_unicom, $render);
		$render = str_replace("{slt_configuracionmenu}", $gui_slt_configuracionmenu, $render);
		$render = $this->render($usuario, $render);
		$template = $this->render_template($render);
		print $template;
	}

	function perfil() {
		$gui = file_get_contents("static/modules/usuario/perfil.html");
		$dict_perfil = array(
			"{usuario-usuario_id}"=>$_SESSION["data-login-" . APP_ABREV]["usuario-usuario_id"],
			"{usuario-denominacion}"=>$_SESSION["data-login-" . APP_ABREV]["usuario-denominacion"],
			"{usuario-nombre}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-nombre"],
			"{usuario-apellido}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-apellido"],
			"{usuario-nivel}"=>$_SESSION["data-login-" . APP_ABREV]["nivel-denominacion"],
			"{sector-denominacion}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-sector"],
			"{departamento-denominacion}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-distrito"],
			"{usuariodetalle-correoelectronico}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-correoelectronico"]);
		$render = $this->render($dict_perfil, $gui);
		$template = $this->render_template($render);
		print $template;
	}

	function administrador() {
		$gui = file_get_contents("static/modules/usuario/administrador.html");
		$template = $this->render_template($gui);
		print $template;
	}

	function panel_autorizador() {
		$gui = file_get_contents("static/modules/usuario/panel_autorizador.html");

		$gui_novedades = file_get_contents("static/modules/usuario/tbl_novedades.html");
		$gui_novedades = $this->render_regex_dict("TBL_NOVEDADES", $gui_novedades, $novenades_collection);

		$gui_autorizador = file_get_contents("static/modules/usuario/tbl_autorizacion_pendiente.html");
		$gui_autorizador = $this->render_regex_dict("TBL_COMPROBANTE", $gui_autorizador, $comprobante_collection);


		$render = str_replace("{novedades}", $gui_novedades, $gui);
		$render = str_replace("{pendientes_tres_dias}", $gui_autorizador, $render);
		$render = str_replace("{contador_facturas_pendientes}", $contador, $render);
		$template = $this->render_template($render);
		print $template;
	}

}
?>
