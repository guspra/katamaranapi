<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {
	var $table_name = 'ruangan';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->get_all_rows_table($this->table_name);//GET SEMUA ROW TABEL
	    				json_output($response['status'],$resp);
		        	}
			}
		}
	}

	public function detail($id) //parameter didapet dari url
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->get_row_detail($this->table_name,$id);
						json_output($response['status'],$resp);
		        	}
			}
		}
	}
	public function getDetailByFolder($id_folder) //parameter didapet dari url
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->get_row_detail_by_foreignkey($this->table_name,$id_folder,"id_folder");
						json_output($response['status'],$resp);
		        	}
			}
		}
	}

    public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	$respStatus = $response['status'];
		        	if($response['status'] == 200){
						$params = json_decode(file_get_contents('php://input'), TRUE);
						if (empty($params['nama']) ) {//ISI NAMA PARAMETER INPUT POST NYA
							$respStatus = 400;
							$resp = array('status' => 400,'message' =>  'Input form masih salah, silahkan coba lagi');
						} else {
								$resp = $this->MyModel->insert_to_table($this->table_name,$params);
						}
						json_output($respStatus,$resp);
		        	}
			}
		}
	}

    public function update($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	$respStatus = $response['status'];
				if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					$params['updated_at'] = date('Y-m-d H:i:s');
					if (empty($params['nama']) ) { //CEK PARAMETER INPUT NYA
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Input form masih salah, silahkan coba lagi');
					} else {
		        			$resp = $this->MyModel->update_data_table($this->table_name,$id,$params);
					}
					json_output($respStatus,$resp);
		       	}
			}
		}
	}

    public function delete($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->delete_data_table($this->table_name,$id); //DELETE SINGLE ROW
					json_output($response['status'],$resp);
		        	}
			}
		}
	}
}