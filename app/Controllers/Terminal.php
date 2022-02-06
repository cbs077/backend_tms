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
  
      //log_message('info',$searchData['sw_group_id']); 
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
  
      // Get data 
      $model = new TerminalModel();
  
      if ($sw_group_id == '' && $sw_version == '' && $cat_serial_no == '') {
        $paginateData = $model->paginate(2);
      } else {
        $paginateData = $model->select('*');
        if ( $sw_group_id != ""){
          $paginateData = $paginateData->Where('sw_group_id', $sw_group_id); 
        } 
        if ( $sw_version != ""){
          $paginateData = $paginateData->Where('sw_version', $sw_version); 
        } 
        if ( $cat_serial_no != ""){
          $paginateData = $paginateData->Where('cat_serial_no', $cat_serial_no); 
        } 
	
        $paginateData = $paginateData->paginate(2);

        $data = [
          'data' => $paginateData,
          'currentPage' =>  $model->pager->getCurrentPage('default'),
          'totalPages' =>  $model->pager->getPageCount('default'),
        ];
    
        return $this->respond($data);
      }
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
            'FIRST_USE_DT'  => $this->request->getVar('FIRST_USE_DT'),
            'LAST_USE_DT'  => $this->request->getVar('LAST_USE_DT'),
            'BUSS_REG_NO'  => $this->request->getVar('BUSS_REG_NO'),
            'JOINS_NM'  => $this->request->getVar('JOINS_NM'),
            'JOINS_ADDR'  => $this->request->getVar('JOINS_ADDR'),
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