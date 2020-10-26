<?php


class ConfiguracionView extends View {
	
	function panel($configuracion_collection) {
		$gui = file_get_contents("static/modules/configuracion/panel.html");
		$render = $this->render_regex('TBL_CONFIGURACION', $gui, $configuracion_collection);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($configuracion_collection, $obj_configuracion) {
		$gui = file_get_contents("static/modules/configuracion/editar.html");
		$render = $this->render_regex('TBL_CONFIGURACION', $gui, $configuracion_collection);
		$obj_configuracion = $this->set_dict($obj_configuracion);
		$render = $this->render($obj_configuracion, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>