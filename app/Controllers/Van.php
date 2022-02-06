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

    // single user
    // public function show($id = null){
    //     $model = new UserModel();
    //     $data = $model->where('id', $id)->first();
    //     if($data){
    //         return $this->respond($data);
    //     }else{
    //         return $this->failNotFound('No User found');
    //     }
    // }

    // // update
    // public function update($id = null){
    //     $model = new UserModel();
    //     $id = $this->request->getVar('id');
    //     $data = [
    //         'name' => $this->request->getVar('name'),
    //         'email'  => $this->request->getVar('email'),
    //     ];
    //     $model->update($id, $data);
    //     $response = [
    //       'status'   => 200,
    //       'error'    => null,
    //       'messages' => [
    //           'success' => 'User updated successfully'
    //       ]
    //   ];
    //   return $this->respond($response);
    // }

    // // delete
    // public function delete($id = null){
    //     $model = new UserModel();
    //     $data = $model->where('id', $id)->delete($id);
    //     if($data){
    //         $model->delete($id);
    //         $response = [
    //             'status'   => 200,
    //             'error'    => null,
    //             'messages' => [
    //                 'success' => 'User successfully deleted'
    //             ]
    //         ];
    //         return $this->respondDeleted($response);
    //     }else{
    //         return $this->failNotFound('No User found');
    //     }
    // }

}