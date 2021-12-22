<?php

use Restserver\Libraries\REST_Controller;


defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Ukmbasket extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ukmbasket_model', 'ukmbasket');

		$this->methods['index_get']['limit'] = 2;


	}

	public function index_get()
	{
		$id = $this->get('id');
		if ($id === null){
			
			$ukmbasket = $this->ukmbasket->getUkmbasket();
		} else{
			$ukmbasket = $this->ukmbasket->getUkmbasket($id);
		}
		

		if ($ukmbasket){
			$this->response([
                    'status' => true,
                    'data' => $ukmbasket
                ], REST_Controller::HTTP_OK);
		} else {
			$this->response([
                    'status' => false,
                    'message' => 'id tidak ditemukan !!!...'
                ], REST_Controller::HTTP_NOT_FOUND);
		}

	}


	public function index_delete()
	{
		$id = $this->delete('id');

		if ($id === null) {
			$this->response([
                    'status' => false,
                    'message' => 'provide an id !!!...'
                ], REST_Controller::HTTP_BAD_REQUEST);
		} else {

			if ($this->ukmbasket->deleteUkmbasket($id) > 0) {
				// ok
				$this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], REST_Controller::HTTP_NO_CONTENT);

			} else {
				// id not found
				$this->response([
                    'status' => false,
                    'message' => 'id not found !!!...'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}




	public function index_post()
	{
		$data = [
			'nim' => $this->post('nim'),
			'nama' => $this->post('nama'),
			'alasan_bergabung' => $this->post('alasan_bergabung'),
			'jurusan' => $this->post('jurusan')
		];


		if($this->ukmbasket->createUkmbasket($data) > 0){
		   $this->response([
                    'status' => true,
                    'message' => 'new data ukmbasket.'
                ], REST_Controller::HTTP_CREATED);
		} else {
				// id not found
				$this->response([
                    'status' => false,
                    'message' => 'failed tp create new data !!!...'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}
	}

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'nim' => $this->put('nim'),
			'nama' => $this->put('nama'),
			'alasan bergabung' => $this->put('alasan bergabung'),
			'jurusan' => $this->put('jurusan')
		];


		if($this->ukmbasket->updateUkmbasket($data, $id) > 0){
		   $this->response([
                    'status' => true,
                    'message' => 'new ukmbasket update.'
                ], REST_Controller::HTTP_NO_CONTENT);
		} else {
		
				$this->response([
                    'status' => false,
                    'message' => 'failed to update new data !!!...'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}

	}
} 