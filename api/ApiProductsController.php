<?php

require_once "./Model/ProductsModel.php";
require_once "ApiController.php";


class ApiProductsController extends ApiController {

	function __construct() {
		parent::__construct();
		$this->model = new ProductsModel();
		$this->view = new ApiView();

	}

	public function getProducts($params = null) {
		$products = $this->model->GetProducts();
		$this->view->response($products,200);
	}


	public function getProductsID($params = null) {
		$products_id = $params[':ID'];
		$products = $this->model->GetProductById($products_id);


		if (!empty($products))  //puede ser distinto de false
			$this->view->response($products,200);
		else
			//404
			$this->view->response('La tarea no existe',404);		
	}


	public function deleteProducts($params = null) {
		$products_id = $params[':ID'];
		$result = $this->model->DeleteProducts($products_id);	

		if ($result > 0)  //viene del rowCount y toca alguna
			$this->view->response('La tarea se borro correctamente',200);
		else
			//404
			$this->view->response('La tarea no existe',404);	

	}

	public function insertProducts($params = null) {
		//traer la data desde el body postman
		$body = $this->getData();
		$idProducts = $this->model->InsertProducts($body->marca, $body->talle,$body->precio,$body->id_categoria);	

		if ($idProducts)  //puede ser distinto de false
			$this->view->response($this->model->GetProductById($idProducts),201);
		else
			//404
			$this->view->response('La tarea no se agrego',404);	
	}

	public function updateProducts($params = null) {
		$body = $this->getData();
		$id = $params[':ID'];

		$product = $this->model->GetProductById($id);
		if(empty($product)) { //si esta vacia
			$this->view->response("El producto con id= ".$id." no existe",404);
		} else {
			$result = $this->model->UpdateProducts($id,$body->marca,$body->talle,$body->precio,$body->id_categoria);
			if ($result > 0) {
				$this->view->response('Se actualizo',200);
				$this->view->response($this->model->GetProductById($id),200);
			} else {
				$this->view->response('La tarea no se actualizo',404);	
			}
		}

	}

	


}
