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
        $van_id = (string)$searchData['van_id'];
      }

      $sw_group_id = "";
      if (isset($searchData) && isset($searchData['sw_group_id'])) {
        $sw_group_id = $searchData['sw_group_id'];
      }

      $sw_group_nm = "";
      if (isset($searchData) && isset($searchData['sw_group_nm'])) {
        $sw_group_nm = $searchData['sw_group_nm'];
      }
  
      // Get data 
      $model = new SwGroupModel();
      $data = $model->getSwGroupMgList($page ,$page_count , $van_id, $sw_group_id, $sw_group_nm);
      return $this->respond($data);  
    }

    public function getSwGroupMg($van_id = false, $group_id = false){
      log_message('info','getSwGroupMg'); 

      $request = service('request');
      $searchData = $request->getGet(); 

      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = (string)$searchData['van_id'];
      }

      $group_id = "";
      if (isset($searchData) && isset($searchData['group_id'])) {
        $group_id = $searchData['group_id'];
      }   
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
          'UPDATE_DT'  => date('Y-m-d H:i:s')
      ];
      $res = $model->insert($data);
      $result = "";
      $resCode = 200;
      if((string)$res == 0) {
        $result = 'SwGroup created successfully'; 
        $resCode = 200;
      }
      else {
        $result = 'SwGroup created fail'; 
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
    public function updateSwGroupMg($sw_group_id = false){
      log_message('info','updateSwGroupMg'); 
      $model = new SwGroupModel();

      $van_id = $this->request->getVar('VAN_ID');
      $sw_group_id = $this->request->getVar('SW_GROUP_ID');
      $sw_group_nm = $this->request->getVar('SW_GROUP_NM');
      $description = $this->request->getVar('DESCRIPTION');

      log_message('info','updateSwGroupMg:'.$van_id.":".$sw_group_id.":".$sw_group_nm.":".$description);   
      $res = $model->updateSwGroupMg($van_id, $sw_group_id, $sw_group_nm, $description);
      $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'User updated successfully',
              'res' => $res
          ]
      ];
      return $this->respond($response);
    }

    // delete
    public function deleteTerminal($id = null){
      log_message('info','deleteTerminal'); 
      $model = new SwGroupModel();       
      $van_id = $this->request->getVar('VAN_ID');
      $sw_group_id = $this->request->getVar('SW_GROUP_ID');

      $data = $model->where('van_id', $van_id)->where('sw_group_id', $sw_group_id)->find();
      log_message('info',"SwGroupModel".json_encode($data)); 
      if($data){
          $res = $model->deleteSwGroupMg($van_id, $sw_group_id);

          $response = [
              'status'   => 200,
              'error'    => null,
              'messages' => [
                  'success' => 'SwGroupModel successfully deleted'
              ]
          ];
          return $this->respondDeleted($response);
      }else{
          return $this->failNotFound('No SwGroupModel found');
      }
  }
}