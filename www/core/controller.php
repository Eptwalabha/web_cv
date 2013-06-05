<?php
abstract class controller {

	private $vars = array();
	private $layout = "basic";


	public function addMessage($type, $title = "", $text = "", $closable = false) {
		
		$message = array();
		$message['type'] = $type;
		$message['title'] = $title;
		$message['text'] = $text;
		$message['closable'] = $closable;
		
		$this->vars['messages'][] = $message;
	}
	
	public function setData($data = array()){
		$this->vars = array_merge($this->vars, $data);
	}

	public function setLayout($layout = "basic"){
		$this->layout = $layout;
	}

	/**
	 * Demande le rendu de la page HTML.
	 * si on ne souhaite pas afficher le template par défaut, mettre le paramètre $basic_layout à faux.
	 * @param unknown $file_name
	 * @param string $basic_layout
	 */
	public function render($file_name, $basic_layout = true){

		extract($this->vars);
		ob_start();
		require(ROOT."views/".strtolower(get_class($this))."/".strtolower($file_name).".php");
		$layout_content = ob_get_clean();
		if($basic_layout == false){
			echo $layout_content;
		}else{
			require(ROOT."views/layouts/".$this->layout.".php");
		}
	}

	public function error($file_name){

		ob_start();
		require(ROOT."views/erreurs/".strtolower($file_name).".php");
		$layout_content = ob_get_clean();
		if($this->layout == false){
			echo $layout_content;
		}else{
			require(ROOT."views/layouts/".$this->layout.".php");
		}
	}
	
	public function error404(){
	
		ob_start();
		require(ROOT."views/commun/404.php");
	
		$layout_content = ob_get_clean();
	
		require(ROOT."views/layouts/basic.php");
	
	}

	public function loadModel($model){

		require_once(ROOT."models/".strtolower($model).".php");
		$this->$model = new $model();

	}


}