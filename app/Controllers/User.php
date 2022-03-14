<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
//use App\Dao\UserModel;


class User extends ResourceController
{
    use ResponseTrait;

    public function getUserMgList(){
      log_message('info','getUserMgList'); 
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

      $user_id = "";
      if (isset($searchData) && isset($searchData['user_id'])) {
        $user_id = $searchData['user_id'];
      }
  
      $user_nm = "";
      if (isset($searchData) && isset($searchData['user_nm'])) {
        $user_nm = $searchData['user_nm'];
      }

      $model = new UserModel();
      $data = $model->getSwOprMgList($page, $page_count, $van_id, $user_id, $user_nm);
      return $this->respond($data);
    }


    public function getUserIdCheck($id = false){
      log_message('info','getUserIdCheck'); 
      $model = new UserModel();
      $session = session();
      $user_id = $session->get('user_id');

      $data = $model->where('USER_ID', $user_id)->find();
      return $this->respond($data);
    }


    public function getUserInfo($id = false){
      log_message('info','user_index'); 
      $model = new UserModel();
      $data = $model->getUserInfo($id);
      return $this->respond($data);
    }

    // create
    public function insertUserMg() {
        log_message('info','user_create'); 
        $model = new UserModel();
        $data = [
            'USER_ID' => $this->request->getVar('USER_ID'),
            'USER_NM'  => $this->request->getVar('USER_NM'),
            'COMP_ID'  => $this->request->getVar('COMP_ID'),
            'PWD'  => password_hash($this->request->getVar('PWD'), PASSWORD_BCRYPT),//$this->request->getVar('PWD'),
            'USER_RIGHTS'  => $this->request->getVar('USER_RIGHTS'),
            'PHONE'  => $this->request->getVar('PHONE'),
            'FAX'  => $this->request->getVar('FAX'),
            'ZIP_CODE'  => $this->request->getVar('ZIP_CODE'),
            'ADDR1'  => $this->request->getVar('ADDR1'),
            'ADDR2w'  => $this->request->getVar('ADDR2'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'UPDATE_DT'  => $this->request->getVar('UPDATE_DT'),
        ];
        $res = $result = $model->insert($data);
        $result = "";
        $resCode = 200;
        if((string)$res == 0) {
          $result = 'User created created successfully'; 
          $resCode = 200;
        }
        else {
          $result = 'User created created fail'; 
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

    public function updatePwd($id = false){
      log_message('info','updatePwd'); 
      $model = new UserModel();

      $user_id = $this->request->getVar('USER_ID');
      $pwd = $this->request->getVar('PWD');

      $data = $model->set("PWD", password_hash($pwd ,PASSWORD_DEFAULT))->where("user_id", $user_id)->update();
      return $this->respond($data);
    }

    public function updateUserInfo(){
        $model = new UserModel();
        $user_id = $this->request->getVar('USER_ID');
        $user_nm = $this->request->getVar('USER_NM');
        $phone = $this->request->getVar('PHONE');
        $fax = $this->request->getVar('FAX');
        $zip_code = $this->request->getVar('ZIP_CODE');
        $addr1 = $this->request->getVar('ADDR1');
        $update_dt = date('Y-m-d H:i:s');

        $model = $model->set("USER_NM", $user_nm);
        $model = $model->set("PHONE", $phone);
        $model = $model->set("FAX", $fax);
        $model = $model->set("ZIP_CODE", $zip_code);
        $model = $model->set("ADDR1", $addr1);
        $model = $model->set("UPDATE_DT", $update_dt);
        $model->where("user_id", $user_id)->update();

        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'User updated successfully'
          ]
      ];
      return $this->respond($response);
    }
}