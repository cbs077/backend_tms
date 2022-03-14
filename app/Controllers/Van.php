<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VanModel;

class Van extends ResourceController
{
    use ResponseTrait;

    public function getVanMgList(){
      log_message('info','getVanMgList'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
      log_message('info','getTerminalMdlList'); 
      $request = service('request');
      $searchData = $request->getGet(); 
  
      $page = "1";
      if (isset($searchData) && isset($searchData['page'])) {
        $page = $searchData['page'];
      }

      $page_count = 10;
      if (isset($searchData) && isset($searchData['page_count'])) {
        $page_count = (int)$searchData['page_count'];
      }

      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = (string)$searchData['van_id'];
      }
  
      // Get data 
      $model = new VanModel();
      $data = $model->getVanList($page ,$page_count, $van_id);
      return $this->respond($data);  
    }

    public function getVanMg($id = false){
      log_message('info','getVanMg'); 
      $model = new VanModel();
      $data = $model->getVanMg($id);
      return $this->respond($data);
    }

    public function getVanMgInfo($id = false){
      log_message('info','getVanMgInfo'); 
      $model = new VanModel();
      $data = $model->findall();
      return $this->respond($data);
    }

    public function getVanIdCheck($id = false){
      log_message('info','getVanMg'); 
      $model = new VanModel();
      $data = $model->getVanIdCheck($id);
      return $this->respond($data);
    }

    // create
    public function insertVanMg() {
        log_message('info','van_create'); 
        $model = new VanModel();
        //VAN_ID, VAN_NM, MANAGER_NM, PHONE, FAX, ZIP_CODE, ADDR1, ADDR2, REG_DT, REG_USER, UPDATE_DT
        $data = [
            'VAN_ID' => $this->request->getVar('VAN_ID'),
            'VAN_NM'  => $this->request->getVar('VAN_NM'),
            'MANAGER_NM'  => $this->request->getVar('MANAGER_NM'),
            'PHONE'  => $this->request->getVar('PHONE'),
            'FAX'  => $this->request->getVar('FAX'),
            'ZIP_CODE'  => $this->request->getVar('ZIP_CODE'),
            'ADDR1'  => $this->request->getVar('ADDR1'),
            'ADDR2'  => $this->request->getVar('ADDR2'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'UPDATE_DT'  => $this->request->getVar('UPDATE_DT'),
        ];
        $res = $model->insert($data);
        $result = "";
        $resCode = 200;
        if((string)$res == 0) {
          $result = 'insertVanMg created successfully'; 
          $resCode = 200;
        }
        else {
          $result = 'insertVanMg created fail'; 
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
    public function updateVanMg($id = null){
      log_message('info','updateVanMg'); 
      $model = new VanModel();

      $van_id = $this->request->getVar('VAN_ID');
      $cat_model_nm = $this->request->getVar('VAN_NM');
      $manager_nm = $this->request->getVar('MANAGER_NM');
      $phone = $this->request->getVar('PHONE');
      $fax = $this->request->getVar('FAX');
      $zip_code = $this->request->getVar('ZIP_CODE');
      $addr1 = $this->request->getVar('ADDR1');
      $addr2 = $this->request->getVar('ADDR2');
      $update_dt = date('Y-m-d H:i:s');

      log_message('info', json_encode($cat_model_nm)); 
      $model = $model->set("VAN_NM", $cat_model_nm);
      $model = $model->set("MANAGER_NM", $manager_nm);
      $model = $model->set("PHONE", $phone);
      $model = $model->set("FAX", $fax);
      $model = $model->set("ZIP_CODE", $zip_code);
      $model = $model->set("ADDR1", $addr1);
      $model = $model->set("ADDR2", $addr2);
      $model = $model->set("UPDATE_DT", $update_dt);
      $model->where("van_id", $van_id)->update();

      $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
            'success' => 'VanModel updated successfully'
        ]
      ];
      return $this->respond($response);
    }
}