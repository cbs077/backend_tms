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
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'UPDATE_DT'  => $this->request->getVar('UPDATE_DT'),
        ];
        $result = $model->insert($data);
        //ERROR - 2022-02-04 14:24:35 --> Duplicate entry 'cbs2351' for key 'PRIMARY'
        //에러 처리 필요.
        //log_message('info',$result); 
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'User created successfully'
          ]
      ];
      return $this->respondCreated($response);
    }

    public function updatePwd($id = false){
      log_message('info','updatePwd'); 
      $model = new UserModel();

      $user_id = $this->request->getVar('user_id');
      $pwd = $this->request->getVar('pwd');

      $data = $model->set("PWD", password_hash($pwd ,PASSWORD_DEFAULT))->where("user_id", $user_id)->update();
      return $this->respond($data);
    }

    public function updateUserInfo(){
        $model = new UserModel();
        $session = session();
        $user_id = $session->get('user_id');
        $van_id = $session->get('van_id');

        $data = [
          'USER_NM'  => $this->request->getVar('USER_NM'),
          'PHONE'  => $this->request->getVar('phone'),
          'PWD'  => password_hash($this->request->getVar('PWD'), PASSWORD_BCRYPT),
          'FAX'  => $this->request->getVar('fax'),
          'ZIP_CODE'  => $this->request->getVar('zip_code'),
          'ADDR1'  => $this->request->getVar('addr1'),
          'ADDR2'  => $this->request->getVar('addr2'),
         ];
        log_message('info', json_encode($user_id)); 
        log_message('info', json_encode($data)); 
        $model->update($user_id, $data);
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