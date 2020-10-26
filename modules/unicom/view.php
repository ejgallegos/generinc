<?php


class UnicomView extends View {
	
	function panel($unicom_collection) {
		$gui = file_get_contents("static/modules/unicom/panel.html");
		$render = $this->render_regex('TBL_UNICOM', $gui, $unicom_collection);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($unicom_collection, $obj_unicom) {
		$gui = file_get_contents("static/modules/unicom/editar.html");
		$render = $this->render_regex('TBL_UNICOM', $gui, $unicom_collection);
		$obj_unicom = $this->set_dict($obj_unicom);
		$render = $this->render($obj_unicom, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>