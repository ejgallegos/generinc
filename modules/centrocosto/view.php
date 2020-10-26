<?php


class CentroCostoView extends View {
	
	function panel($centrocosto_collection, $gerencia_collection) {
		$gui = file_get_contents("static/modules/centrocosto/panel.html");
		$gui_gerencia = file_get_contents("static/common/slt_gerencia.html");
		$gui_gerencia = $this->render_regex('SLT_GERENCIA', $gui_gerencia, $gerencia_collection);
		$render = $this->render_regex('TBL_CENTROCOSTO', $gui, $centrocosto_collection);
		$render = str_replace("{slt_gerencia}", $gui_gerencia, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($centrocosto_collection, $gerencia_collection, $obj_centrocosto) {
		$gui = file_get_contents("static/modules/centrocosto/editar.html");
		$gui_gerencia = file_get_contents("static/common/slt_gerencia.html");
		$gui_gerencia = $this->render_regex('SLT_GERENCIA', $gui_gerencia, $gerencia_collection);
		$render = $this->render_regex('TBL_CENTROCOSTO', $gui, $centrocosto_collection);
		$obj_centrocosto = $this->set_dict($obj_centrocosto);
		$render = $this->render($obj_centrocosto, $render);
		$render = str_replace("{slt_gerencia}", $gui_gerencia, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>