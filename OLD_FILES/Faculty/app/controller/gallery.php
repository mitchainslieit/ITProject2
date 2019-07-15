<?php
class Gallery extends Controller
{
	protected $model = null;

	function __construct(){
		$this->loadModel();
		parent::__construct();
	}

	protected function loadModel(){
		require MVC . '/model/GalleryModel.php';
		$this->model = new GalleryModel();
	}
	
	public function index($view){
		$gallery = $this->model->getGalleryImages('gallery');
		require MVC . 'view/template/header.php';
		require MVC . 'view/'.$view.'.php';
		require MVC . 'view/template/footer.php';
	}
}
