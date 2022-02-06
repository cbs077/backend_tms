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
  
      $cat_model_id = "";
      if (isset($searchData) && isset($searchData['cat_model_id'])) {
        $cat_model_id = $searchData['cat_model_id'];
      }

      $cat_model_nm = "";
      if (isset($searchData) && isset($searchData['cat_model_nm'])) {
        $cat_model_nm = $searchData['cat_model_nm'];
      }
  
      // Get data 
      $model = new TerminalMdlModel();
  
      if ($cat_model_id == '' && $cat_model_nm == '') {
        $paginateData = $model->paginate(2);
      } else {      
        $paginateData = $model->select('TW_CAT_MODEL.*,TW_VAN_INFO.VAN_NM');
        if ( $cat_model_id != ""){
          $paginateData = $paginateData->Where('cat_model_id', $cat_model_id); 
        } 
        if ( $cat_model_nm != ""){
          $paginateData = $paginateData->Where('cat_model_nm', $cat_model_nm); 
        } 
        $paginateData = $paginateData->join('TW_VAN_INFO', "TW_VAN_INFO.van_id = TW_CAT_MODEL.van_id");
        $paginateData = $paginateData->paginate(2);

        $data = [
          'data' => $paginateData,
          'currentPage' =>  $model->pager->getCurrentPage('default'),
          'totalPages' =>  $model->pager->getPageCount('default'),
        ];

        return $this->respond($data);
      }
    }

    public function getTerminalMdl($van_id = false, $cat_model_id = false){
      log_message('info','getTerminalMdl'); 
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

}