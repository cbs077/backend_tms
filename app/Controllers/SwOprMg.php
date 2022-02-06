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
  
      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = $searchData['van_id'];
      }

      $sw_group_id = "";
      if (isset($sw_group_id) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }
  
      $sw_version = "";
      if (isset($sw_version) && isset($searchData['sw_version'])) {
        $sw_version = $searchData['sw_version'];
      }

      $model = new SwOprMgModel();
      $data = $model->getSwOprMgList($van_id, $sw_group_id, $sw_version);
      return $this->respond($data);
    }

    public function getSwGroupMg($van_id = false, $group_id = false){
      log_message('info','getSwGroupMg'); 
      $model = new SwGroupModel();
      $data = $model->getSwGroupMg($van_id, $group_id);
      return $this->respond($data);
    }

    public function getSwGroupIdCheck($van_id = false, $group_id = false){
      log_message('info','getSwGroupIdCheck'); 
      $model = new SwGroupModel();
      $data = $model->getSwGroupIdCheck($van_id, $group_id);
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
        $model->insert($data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'insertSwOprMg created successfully'
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