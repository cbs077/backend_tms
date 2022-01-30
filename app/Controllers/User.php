<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;


class User extends ResourceController
{
    use ResponseTrait;

    // all users
    public function index(){
      log_message('info','user_index'); 
      $model = new UserModel();
      $data['Users'] = $model->orderBy('USER_ID', 'DESC')->findAll();
      return $this->respond($data);
    }

    // create
    public function create() {
        log_message('info','user_create'); 
        $model = new UserModel();
        $data = [
            'USER_ID' => $this->request->getVar('USER_ID'),
            'USER_NM'  => $this->request->getVar('USER_NM'),
            'COMP_ID'  => $this->request->getVar('COMP_ID'),
            'PWD'  => $this->request->getVar('PWD'),
            'USER_RIGHTS'  => $this->request->getVar('USER_RIGHTS'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER'),
            'UPDATE_DT'  => $this->request->getVar('UPDATE_DT'),
        ];
        $model->insert($data);
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'User created successfully'
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