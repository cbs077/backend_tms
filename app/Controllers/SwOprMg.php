<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SwOprMgModel;


class SwOprMg extends ResourceController
{
    use ResponseTrait;

    public function getSwOprMgList(){
      log_message('info','getSwOprMgList'); 
      $request = service('request');
      $searchData = $request->getGet(); 
  
      $page = "1";
      if (isset($searchData) && isset($searchData['page'])) {
        $page = $searchData['page'];
      }

      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = $searchData['van_id'];
      }

      $sw_group_id = "";
      if (isset($searchData) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }
  
      $sw_version = "";
      if (isset($searchData) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }

      $model = new SwOprMgModel();
      $data = $model->getSwOprMgList($page, 20, $van_id, $sw_group_id, $sw_version);
      return $this->respond($data);
    }

    public function getSwUpgradeList($van_id = false, $sw_group_id = false, $sw_version = false){
      log_message('info','getSwUpgradeList'); 
      $request = service('request');
      $searchData = $request->getGet(); 

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

      $sw_group_id = "";
      if (isset($searchData) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }
  
      $sw_version = "";
      if (isset($searchData) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }      

      log_message('info','getSwOprMg'); 
      $model = new SwOprMgModel();
      $data = $model->getSwUpgradeList($page, $page_count, $van_id, $sw_group_id, $sw_version);
      return $this->respond($data);
    }

    public function getSwUpdateList(){
      log_message('info','getSwUpdateList'); 
      $request = service('request');
      $searchData = $request->getGet(); 

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

      $gubun_code = "";
      if (isset($searchData) && isset($searchData['gubun_code'])) {
        $gubun_code = $searchData['gubun_code'];
      }

      $sw_group_id = "";
      if (isset($searchData) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }
  
      //일반 일떄가 fail, 오류일때 ''
      $response = "";
      if (isset($searchData) && isset($searchData['response'])) {
        $response = $searchData['response'];
      }   
      
      $sw_version = "";
      if (isset($searchData) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }   

      $cat_serial_no = "";
      if (isset($searchData) && isset($searchData['cat_serial_no'])) {
        $cat_serial_no = $searchData['cat_serial_no'];
      }

      $search_start_dt = "";
      if (isset($searchData) && isset($searchData['search_start_dt'])) {
        $search_start_dt = $searchData['search_start_dt'];
      }
  
      $search_end_dt = "";
      if (isset($searchData) && isset($searchData['search_end_dt'])) {
        $search_end_dt = $searchData['search_end_dt'];
      }      

      log_message('info','getSwUpdateList'); 
      log_message('info',$search_end_dt); 
      $model = new SwOprMgModel();
      $data = $model->getSwUpdateList($page, $page_count, $van_id, $gubun_code, $sw_group_id, $sw_version, $response, $cat_serial_no, $search_start_dt, $search_end_dt);
      return $this->respond($data);
    }

    public function getSwUpdateListA(){
      log_message('info','getSwUpdateList'); 
      $request = service('request');
      $searchData = $request->getGet(); 

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

      $gubun_code = "";
      if (isset($searchData) && isset($searchData['gubun_code'])) {
        $gubun_code = $searchData['gubun_code'];
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

      $search_start_dt = "";
      if (isset($searchData) && isset($searchData['search_start_dt'])) {
        $search_start_dt = $searchData['search_start_dt'];
      }
  
      $search_end_dt = "";
      if (isset($searchData) && isset($searchData['search_end_dt'])) {
        $search_end_dt = $searchData['search_end_dt'];
      }      

      log_message('info','getSwUpdateList'); 
      log_message('info',$search_end_dt); 
      $model = new SwOprMgModel();
      $data = $model->getSwUpdateListA($page, $page_count, $van_id, $gubun_code, $sw_group_id, $sw_version, $cat_serial_no, $search_start_dt, $search_end_dt);
      return $this->respond($data);
    }

    public function deleteSwOprMg($van_id = false, $sw_group_id = false, $sw_version = false){
      log_message('info','deleteSwOprMg'); 
      $model = new SwOprMgModel();
      $data['post'] = $model->where('van_id', $van_id)->where('sw_group_id', $sw_group_id)->where('sw_version', $sw_version)->delete();
      //$data = $model->deleteSwOprMg($van_id, $sw_group_id, $sw_version);
      return $this->respond($data);
    }

    public function getSwIdCheck($van_id = false, $sw_group_id = false, $sw_version = false){
      log_message('info','getSwIdCheck'); 
      $model = new SwOprMgModel();
      $data = $model->getSwIdCheck($van_id, $sw_group_id, $sw_version);
      return $this->respond($data);
    }

    // create
    public function insertSwOprMg() {
        log_message('info','insertSwOprMg'); 
        $model = new SwOprMgModel();
        //VAN_ID, SW_GROUP_ID, SW_VERSION, APPL_DT, REG_DT, REG_USER, DATA_SIZE, FILE_PATH, FILE_NM, UPLOAD_FILE_NM
        $data = [
            'VAN_ID' => $this->request->getVar('VAN_ID'),
            'SW_GROUP_ID'  => $this->request->getVar('SW_GROUP_ID'),
            'SW_VERSION'  => $this->request->getVar('SW_VERSION'),
            'APPL_DT'  => $this->request->getVar('APPL_DT'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'DATA_SIZE'  => $this->request->getVar('DATA_SIZE'),
            'FILE_PATH'  => $this->request->getVar('FILE_PATH'),
            'FILE_NM'  => $this->request->getVar('FILE_NM'),
            'UPLOAD_FILE_NM'  => $this->request->getVar('UPLOAD_FILE_NM')
        ];
        $res = $result = $model->insert($data);
        $result = "";
        $resCode = 200;
        if((string)$res == 0) {
          $result = 'insertSwOprMg created successfully'; 
          $resCode = 200;
        }
        else {
          $result = 'insertSwOprMg created fail'; 
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
}