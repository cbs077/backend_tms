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
  
      $search = "";
      if (isset($searchData) && isset($searchData['search'])) {
        $search = $searchData['search'];
      }
  
      // Get data 
      $model = new VanModel();
  
      if ($search == '') {
        $paginateData = $model->paginate(2);
      } else {
        $paginateData = $model->select('*')
          ->orLike('VAN_ID', $search)
          //->orLike('email', $search)    			
          ->paginate(2);
      }

      $data = [
        'users' => $paginateData,
        'currentPage' =>  $model->pager->getCurrentPage('default'),
        'totalPages' =>  $model->pager->getPageCount('default'),
        'search' => $search
      ];
  
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
        $model->insert($data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'Van created successfully'
          ]
      ];
      return $this->respondCreated($response);
    }

    // update
    public function updateVanMg($id = null){
      log_message('info','updateVanMg'); 
      $model = new VanModel();
      $session = session();
      $van_id = $session->get('van_id');

      $cat_model_nm = $this->request->getVar('VAN_NM');
      $manager_nm = $this->request->getVar('MANAGER_NM');
      $phone = $this->request->getVar('PHONE');
      $fax = $this->request->getVar('FAX');
      $zip_code = $this->request->getVar('ZIP_CODE');
      $addr1 = $this->request->getVar('ADDR1');
      $addr2 = $this->request->getVar('ADDR2');
      $update_dt = $this->request->getVar('UPDATE_DT');

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