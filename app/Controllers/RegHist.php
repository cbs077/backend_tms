<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RegHistModel;

class RegHist extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getTerminalRegHist(){
      log_message('info','getTerminalRegHist'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
      $page = "1";
      if (isset($searchData) && isset($searchData['page'])) {
        $page = $searchData['page'];
      }

      $page_count = 20;
      if (isset($searchData) && isset($searchData['page_count'])) {
        $page_count = (int)$searchData['page_count'];
      }

      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = $searchData['van_id'];
      }

      $cat_model_id = "";
      if (isset($searchData) && isset($searchData['cat_model_id'])) {
        $cat_model_id = $searchData['cat_model_id'];
      }

      $search_start_dt = "";
      if (isset($searchData) && isset($searchData['search_start_dt'])) {
        $search_start_dt = $searchData['search_start_dt'];
      }

      $search_end_dt = "";
      if (isset($searchData) && isset($searchData['search_end_dt'])) {
        $search_end_dt = $searchData['search_end_dt'];
      }

      // Get data 
      $model = new RegHistModel();
      $data = $model->getTerminalRegHist($page ,$page_count, $van_id ,$cat_model_id, $search_start_dt, $search_end_dt);
      return $this->respond($data); 
    }
    // create
    public function insertRegHist() {
      log_message('info','insertRegHist'); 
      $model = new RegHistModel();
      $data = [
        'VAN_ID' => $this->request->getVar('VAN_ID'),
        'CAT_MODEL_ID'  => $this->request->getVar('CAT_MODEL_ID'),
        'SERIAL_NO_FROM'  => $this->request->getVar('SERIAL_NO_FROM'),
        'SERIAL_NO_TO'  => $this->request->getVar('SERIAL_NO_TO'),
        'REG_DT'  => date('Y-m-d H:i:s'),
        'REG_USER'  => $this->request->getVar('REG_USER'),
      ];
      //VAN_ID, CAT_MODEL_ID, REG_DT, SERIAL_NO_FROM, SERIAL_NO_TO, REG_USER

      $res = $model->insert($data);
      $result = "";
      $resCode = 200;
      if((string)$res == 0) {
        $result = 'insertRegHist created successfully'; 
        $resCode = 200;
      }
      else {
        $result = 'insertRegHist created fail'; 
        $resCode = 400;
      }

      $response = [
        'status'   => $resCode,
        'error'    => null,
        'messages' => [
            'success' => $result,
            "resutl" => $res
        ]
          
      ];
      return $this->respondCreated($response);
    }

    // delete
    public function deleteRegHist($id = null){
      $model = new RegHistModel();       
      $session = session();
      $van_id = $session->get('van_id');

      $cat_model_id = $this->request->getVar('CAT_MODEL_ID');
      $reg_dt = $this->request->getVar('REG_DT');

      $data = $model->where('van_id', $van_id)->where('cat_model_id', $cat_model_id)->find();

      if($data){
          $res = $model->deleteRegHist($van_id, $cat_model_id, $reg_dt);
          log_message('info',"deleteRegHist".json_encode($res)); 

          $response = [
              'status'   => 200,
              'error'    => null,
              'messages' => [
                  'success' => 'RegHistModel successfully deleted'
              ]
          ];
          return $this->respondDeleted($response);
      }else{
          return $this->failNotFound('No RegHistModel found');
      }
    }
}