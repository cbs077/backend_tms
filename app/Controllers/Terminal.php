<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TerminalModel;

class Terminal extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getTerminalList(){
      log_message('info','getTerminalList'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = $searchData['van_id'];
      }

      $sw_version = "";
      if (isset($searchData) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }

      $page = "1";
      if (isset($searchData) && isset($searchData['page'])) {
        $page = $searchData['page'];
      }

      $page_count = 20;
      if (isset($searchData) && isset($searchData['page_count'])) {
        $page_count = (int)$searchData['page_count'];
      }

      $sw_group_id = "";
      if (isset($searchData) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }

      $sw_version = "";
      if (isset($searchData) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }

      $cat_serial_no = "";
      if (isset($searchData) && isset($searchData['cat_serial_no'])) {
        $cat_serial_no = $searchData['cat_serial_no'];
      }

      $cat_model_id = "";
      if (isset($searchData) && isset($searchData['cat_model_id'])) {
        $cat_model_id = $searchData['cat_model_id'];
      }

      $status = "";
      if (isset($searchData) && isset($searchData['status'])) {
        $status = $searchData['status'];
      }

      log_message('info', json_encode($status)); 
      // Get data 
      $model = new TerminalModel();
      $data = $model->getTerminalList($page ,$page_count ,$van_id, $sw_group_id, $sw_version, $cat_serial_no, $cat_model_id, $status);
      return $this->respond($data); 
    }

    public function getTerminal($van_id = false, $serial_no  = false){
      log_message('info','getTerminal'); 
      $model = new TerminalModel();
      $data = $model->getTerminal($van_id, $serial_no);
      return $this->respond($data);
    }

    public function getCatIdCheck($van_id = false, $serial_no = false){
      log_message('info','getCatIdCheck'); 
      $model = new TerminalModel();
      $data = $model->getCatIdCheck($van_id, $serial_no);
      return $this->respond($data);
    }

    // create
    public function insertTerminal() {
        log_message('info','insertTerminal'); 
        $model = new TerminalModel();
        //VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, SW_GROUP_ID, SW_VERSION, STATUS, REG_DT, REG_USER, FIRST_USE_DT, LAST_USE_DT, BUSS_REG_NO, JOINS_NM, JOINS_ADDR
        $data = [
            'VAN_ID' => $this->request->getVar('VAN_ID'),
            'CAT_SERIAL_NO'  => $this->request->getVar('CAT_SERIAL_NO'),
            'CAT_MODEL_ID'  => $this->request->getVar('CAT_MODEL_ID'),
            'SW_GROUP_ID'  => $this->request->getVar('SW_GROUP_ID'),
            'SW_VERSION'  => $this->request->getVar('SW_VERSION'),
            'STATUS'  => $this->request->getVar('STATUS'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
        ];
        log_message('info', json_encode($data)); 
        $res = $model->insert($data);
        $result = "";
        $resCode = 200;
        if((string)$res == 0) {
          $result = 'Terminal created successfully'; 
          $resCode = 200;
        }
        else {
          $result = 'Terminal created fail'; 
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

    // update
    public function updateTerminal(){
        log_message('info','updateTerminal'); 
        $model = new TerminalModel();

        $van_id = $this->request->getVar('VAN_ID');
        $cat_serial_no = $this->request->getVar('CAT_SERIAL_NO');

        $cat_model_id = $this->request->getVar('CAT_MODEL_ID');
        if (!isset($cat_model_id)) {
          $cat_model_id = "";
        }

        log_message('info','updateTerminal'); 
        $sw_group_id = $this->request->getVar('SW_GROUP_ID');
        if (!isset($sw_group_id)) {
          $sw_group_id = "";
        }

        $status = $this->request->getVar('STATUS');
        if (!isset($status)) {
          $status = "";
        }

        log_message('info',"updateTerminal11".json_encode($sw_group_id)); 
        $model->updateTerminal($van_id, $cat_serial_no, $cat_model_id, $sw_group_id, $status);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'User updated successfully'
          ]
      ];
      return $this->respond($response);
    }

    // delete
    public function deleteTerminal(){
        $model = new TerminalModel();       
        
        log_message('info',"deleteTerminal"); 
        $cat_serial_no = $this->request->getVar('CAT_SERIAL_NO');
        $van_id = $this->request->getVar('VAN_ID');
        $data = $model->where('CAT_SERIAL_NO', $cat_serial_no)->where('VAN_ID', $van_id)->find();

        log_message('info',"deleteTerminal".json_encode($data )); 
        if($data){
            $res = $model->deleteTerminal($van_id, $cat_serial_no);
            log_message('info',"deleteTerminal".json_encode($res)); 
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'TerminalModel successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No User found');
        }
    }

}