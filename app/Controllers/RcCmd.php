<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RcCmdModel;

class RcCmd extends ResourceController
{
    use ResponseTrait;

    // create
    public function insertRcCmd() {
        log_message('info','insertRcCmd'); 
        $model = new RcCmdModel();
        $terminalNo = $this->request->getVar('CAT_SERIAL_NO');
        $cmd = $this->request->getVar('CMD');
        $cmdSub = $this->request->getVar('CMD_SUB');
        //REQ_ID, VAN_ID, CAT_SERIAL_NO, SW_VERSION, RESULT_CODE, STSTUS, CMD, REG_DT, OPER_DT, REG_USER
        $data = $model->where('CAT_SERIAL_NO', $terminalNo)->where('CMD', $cmd )->where('STATUS', null)->find();

        log_message('info',"insertRcCmd".json_encode($data)); 
        if($data == []){
          $data = [
              'VAN_ID' => $this->request->getVar('VAN_ID'),
              'CAT_SERIAL_NO'  => $terminalNo,
              'CMD'  => $cmd ,
              'CMD_SUB' => $cmdSub ,
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

}