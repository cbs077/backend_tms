<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TerminalMdlModel;

class TerminalMdl extends ResourceController
{
    use ResponseTrait;

    public function getTerminalMdlList(){
      log_message('info','getTerminalMdlList'); 
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

      $cat_model_id = "";
      if (isset($searchData) && isset($searchData['cat_model_id'])) {
        $cat_model_id = $searchData['cat_model_id'];
      }

      $cat_model_nm = "";
      if (isset($searchData) && isset($searchData['cat_model_nm'])) {
        $cat_model_nm = $searchData['cat_model_nm'];
      }
  
      $model = new TerminalMdlModel();
      $data = $model->getTerminalMdlList($page ,$page_count, $van_id ,$cat_model_id, $cat_model_nm);
      return $this->respond($data);  
    }

    public function getTerminalMdl(){
      $request = service('request');
      $searchData = $request->getGet(); 

      $van_id = "";
      if (isset($searchData) && isset($searchData['van_id'])) {
        $van_id = (string)$searchData['van_id'];
      }

      $cat_model_id = "";
      if (isset($searchData) && isset($searchData['cat_model_id'])) {
        $cat_model_id = $searchData['cat_model_id'];
      }      
      log_message('info',$van_id); 
      $model = new TerminalMdlModel();
      $data = $model->getTerminalMdl($van_id, $cat_model_id);
      return $this->respond($data);
    }

    public function getMdlIdCheck($van_id = false, $cat_model_id = false){
      log_message('info','getMdlIdCheck'); 
      $model = new TerminalMdlModel();
      $data = $model->getMdlIdCheck($van_id, $cat_model_id);
      return $this->respond($data);
    }

    // create
    public function insertTerminalMdl() {
        log_message('info','insertTerminalMdl'); 
        $model = new TerminalMdlModel();
        //VAN_ID, CAT_MODEL_ID, CAT_MODEL_NM, DESCRIPTION, USE_YN, REG_DT, REG_USER
        $data = [
            'VAN_ID' => $this->request->getVar('VAN_ID'),
            'CAT_MODEL_ID'  => $this->request->getVar('CAT_MODEL_ID'),
            'CAT_MODEL_NM'  => $this->request->getVar('CAT_MODEL_NM'),
            'DESCRIPTION'  => $this->request->getVar('DESCRIPTION'),
            'USE_YN'  => $this->request->getVar('USE_YN'),
            'REG_DT'  => $this->request->getVar('REG_DT'),
            'REG_USER'  => $this->request->getVar('REG_USER')
        ];
        $res = $model->insert($data);
        $result = "";
        $resCode = 200;
        if((string)$res == 0) {
          $result = 'TerminalMdl created successfully'; 
          $resCode = 200;
        }
        else {
          $result = 'TerminalMdl created fail'; 
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
    public function updateTerminalMdl($id = null){
      log_message('info','updateTerminalMdl'); 
      $model = new TerminalMdlModel();

      $van_id = $this->request->getVar('VAN_ID');
      $cat_model_id = $this->request->getVar('CAT_MODEL_ID');
      $cat_model_nm = $this->request->getVar('CAT_MODEL_NM');
      $description = $this->request->getVar('DESCRIPTION');

      $model->set("CAT_MODEL_NM", $cat_model_nm)->set("DESCRIPTION", $description)->where("van_id", $van_id)->where("cat_model_id", $cat_model_id)->update();
      $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
            'success' => 'updateTerminalMdl updated successfully'
        ]
    ];
    return $this->respond($response);
  }
}