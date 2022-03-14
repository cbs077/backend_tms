<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RcCmdModel;

class RcCmd extends ResourceController
{
    use ResponseTrait;

    // public function getVanMgList(){
    //   log_message('info','getVanMgList'); 
    //   $request = service('request');
    //   $searchData = $request->getGet(); // OR $this->request->getGet();
  
    //   log_message('info','getTerminalMdlList'); 
    //   $request = service('request');
    //   $searchData = $request->getGet(); 
  
    //   $page = "1";
    //   if (isset($searchData) && isset($searchData['page'])) {
    //     $page = $searchData['page'];
    //   }

    //   $page_count = 10;
    //   if (isset($searchData) && isset($searchData['page_count'])) {
    //     $page_count = (int)$searchData['page_count'];
    //   }

    //   $van_id = "";
    //   if (isset($searchData) && isset($searchData['van_id'])) {
    //     $van_id = (string)$searchData['van_id'];
    //   }
  
    //   // Get data 
    //   $model = new VanModel();
    //   $data = $model->getVanList($page ,$page_count, $van_id);
    //   return $this->respond($data);  
    // }

    // create
    public function insertRcCmd() {
        log_message('info','insertRcCmd'); 
        $model = new RcCmdModel();
        $terminalNo = $this->request->getVar('CAT_SERIAL_NO');
        $cmd = $this->request->getVar('CMD');
        //REQ_ID, VAN_ID, CAT_SERIAL_NO, SW_VERSION, RESULT_CODE, STSTUS, CMD, REG_DT, OPER_DT, REG_USER
        $data = $model->where('CAT_SERIAL_NO', $terminalNo)->where('CMD', $cmd )->where('STATUS', null)->find();

        log_message('info',"insertRcCmd".json_encode($data)); 
        if($data == []){
          $data = [
              'VAN_ID' => $this->request->getVar('VAN_ID'),
              'CAT_SERIAL_NO'  => $terminalNo,
              'CMD'  => $cmd ,
              'REG_DT'  => date('Y-m-d H:i:s'),
              'REG_USER'  => $this->request->getVar('REG_USER'),
          ];
        
          $res = $model->insert($data);
          log_message('info',"insertRcCmdres".json_encode($res)); 
          $result = "";
          $resCode = 200;
          if($res == false) {
            $result = 'insertRcCmd created fail'; 
            $resCode = 400;
          }
          else {
            $result = 'insertRcCmd created sucess'; 
            $resCode = 200;
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
        }else{
          log_message('info',"insertRcCmd alreay exists"); 
          return $this->failNotFound('insertRcCmd alreay exists');
        }
    }

    // // update
    // public function updateVanMg($id = null){
    //   log_message('info','updateVanMg'); 
    //   $model = new VanModel();
    //   $session = session();
    //   $van_id = $session->get('van_id');

    //   $cat_model_nm = $this->request->getVar('VAN_NM');
    //   $manager_nm = $this->request->getVar('MANAGER_NM');
    //   $phone = $this->request->getVar('PHONE');
    //   $fax = $this->request->getVar('FAX');
    //   $zip_code = $this->request->getVar('ZIP_CODE');
    //   $addr1 = $this->request->getVar('ADDR1');
    //   $addr2 = $this->request->getVar('ADDR2');
    //   $update_dt = $this->request->getVar('UPDATE_DT');

    //   log_message('info', json_encode($cat_model_nm)); 
    //   $model = $model->set("VAN_NM", $cat_model_nm);
    //   $model = $model->set("MANAGER_NM", $manager_nm);
    //   $model = $model->set("PHONE", $phone);
    //   $model = $model->set("FAX", $fax);
    //   $model = $model->set("ZIP_CODE", $zip_code);
    //   $model = $model->set("ADDR1", $addr1);
    //   $model = $model->set("ADDR2", $addr2);
    //   $model = $model->set("UPDATE_DT", $update_dt);
    //   $model->where("van_id", $van_id)->update();

    //   $response = [
    //     'status'   => 200,
    //     'error'    => null,
    //     'messages' => [
    //         'success' => 'VanModel updated successfully'
    //     ]
    //   ];
    //   return $this->respond($response);
    // }
}