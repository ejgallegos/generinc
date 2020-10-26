<?php


class NivelView extends View {
	
	function panel($nivel_collection) {
		$gui = file_get_contents("static/modules/nivel/panel.html");
		$render = $this->render_regex('TBL_NIVEL', $gui, $nivel_collection);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($nivel_collection, $obj_nivel) {
		$gui = file_get_contents("static/modules/nivel/editar.html");
		$render = $this->render_regex('TBL_NIVEL', $gui, $nivel_collection);
		$obj_nivel = $this->set_dict($obj_nivel);
		$render = $this->render($obj_nivel, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>