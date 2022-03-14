<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TerminalStatModel;

class TerminalStat extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getTerminalUseInfoList(){
      log_message('info','getTerminalUseInfoList'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
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
        $van_id = $searchData['van_id'];
      }

      $search_start_dt = "";
      if (isset($searchData) && isset($searchData['search_start_dt'])) {
        $search_start_dt = $searchData['search_start_dt'];
      }
  
      $search_end_dt = "";
      if (isset($searchData) && isset($searchData['search_end_dt'])) {
        $search_end_dt = $searchData['search_end_dt'];
      }     

      // Get data 
      $model = new TerminalStatModel();
      $data = $model->getTerminalUseInfoList($page ,$page_count ,$van_id, $search_start_dt, $search_end_dt);
      return $this->respond($data); 
    }

    public function getTerminalVanInfoList(){
      log_message('info','getTerminalVanInfoList'); 
      $request = service('request');
      $searchData = $request->getGet(); // OR $this->request->getGet();
  
      // $page = "1";
      // if (isset($searchData) && isset($searchData['page'])) {
      //   $page = $searchData['page'];
      // }

      // $page_count = 20;
      // if (isset($searchData) && isset($searchData['page_count'])) {
      //   $page_count = (int)$searchData['page_count'];
      // }

      // $van_id = "";
      // if (isset($searchData) && isset($searchData['van_id'])) {
      //   $van_id = $searchData['van_id'];
      // }

      // $search_start_dt = "";
      // if (isset($searchData) && isset($searchData['search_start_dt'])) {
      //   $search_start_dt = $searchData['search_start_dt'];
      // }
  
      // $search_end_dt = "";
      // if (isset($searchData) && isset($searchData['search_end_dt'])) {
      //   $search_end_dt = $searchData['search_end_dt'];
      // }     

      // Get data 
      $model = new TerminalStatModel();
      $data = $model->getTerminalVanInfoList();
      return $this->respond($data); 
    }
}