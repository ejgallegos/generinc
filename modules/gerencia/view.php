<?php


class GerenciaView extends View {
	
	function panel($gerencia_collection) {
		$gui = file_get_contents("static/modules/gerencia/panel.html");
		$render = $this->render_regex('TBL_GERENCIA', $gui, $gerencia_collection);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($gerencia_collection, $obj_gerencia) {
		$gui = file_get_contents("static/modules/gerencia/editar.html");

		$render = $this->render_regex('TBL_GERENCIA', $gui, $gerencia_collection);
		$obj_gerencia = $this->set_dict($obj_gerencia);
		$render = $this->render($obj_gerencia, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>