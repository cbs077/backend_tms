<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SwGroupModel;


class SwGroup extends ResourceController
{
    use ResponseTrait;

    public function getSwGroupMgList(){
      log_message('info','getSwGroupMgList'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
      $search = "";
      if (isset($searchData) && isset($searchData['search'])) {
        $search = $searchData['search'];
      }
  
      // Get data 
      $model = new SwGroupModel();
  
      if ($search == '') {
        $paginateData = $model->paginate(2);
      } else {
        $paginateData = $model->select('*');
        $paginateData = $paginateData->orLike('VAN_ID', $search);  			
        $paginateData = $paginateData->paginate(2);
      }

      $data = [
        'data' => $paginateData,
        'currentPage' =>  $model->pager->getCurrentPage('default'),
        'totalPages' =>  $model->pager->getPageCount('default'),
        'search' => $search
      ];
  
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
    public function insertSwGroupMg() {
        log_message('info','swgroup_create'); 
        $model = new SwGroupModel();
        $data = [
            'VAN_ID' => $this->request->getVar('VAN_ID'),
            'SW_GROUP_ID'  => $this->request->getVar('SW_GROUP_ID'),
            'SW_GROUP_NM'  => $this->request->getVar('SW_GROUP_NM'),
            'DESCRIPTION'  => $this->request->getVar('DESCRIPTION'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'UPDATE_DT'  => $this->request->getVar('UPDATE_DT')
        ];
        $model->insert($data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'SwGroup created successfully'
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