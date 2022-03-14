<?php 
namespace App\Models;
use CodeIgniter\Model;

class RegHistModel extends Model
{
    //VAN_ID, CAT_MODEL_ID, REG_DT, SERIAL_NO_FROM, SERIAL_NO_TO, REG_USER
    protected $table = 'TW_CAT_REG_HIST';
    protected $primaryKey = ['VAN_ID','CAT_MODEL_ID', 'REG_DT'];
    protected $allowedFields = ['VAN_ID', 'CAT_MODEL_ID', 'REG_DT', 'SERIAL_NO_FROM', 'SERIAL_NO_TO', 'REG_USER'];


    public function getTerminalRegHist($cur_page, $page_count, $van_id, $cat_model_id, $search_start_dt, $search_end_dt)
    {        
        $sql = 'SELECT *, a.REG_DT as REG_DT FROM (SELECT * FROM TW_CAT_REG_HIST
                Where CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END
                and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                and CASE WHEN :search_start_dt: = "" THEN true ELSE REG_DT >= :search_start_dt: END
                and CASE WHEN :search_end_dt: = "" THEN true ELSE REG_DT <= DATE_ADD(:search_end_dt:, INTERVAL 1 DAY)  END) a
                left join TW_CAT_MODEL b on a.van_id = b.van_id and a.cat_model_id = b.cat_model_id
                left join TW_VAN_INFO d on a.van_id = d.van_id
                ORDER BY a.van_id, a.cat_model_id DESC        
                LIMIT :page_count: 
                offset :offset:'; 
                
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_model_id' => $cat_model_id,
              'search_start_dt' => $search_start_dt,
              'search_end_dt' => $search_end_dt,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM (SELECT * FROM TW_CAT_REG_HIST
                Where CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END
                and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                and CASE WHEN :search_start_dt: = "" THEN true ELSE REG_DT >= :search_start_dt: END
                and CASE WHEN :search_end_dt: = "" THEN true ELSE REG_DT <= DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END) a
                left join TW_CAT_MODEL b on a.van_id = b.van_id and a.cat_model_id = b.cat_model_id
                left join TW_VAN_INFO d on a.van_id = d.van_id';

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'cat_model_id' => $cat_model_id,
            'search_start_dt' => $search_start_dt,
            'search_end_dt' => $search_end_dt
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function deleteRegHist($van_id, $cat_model_id, $reg_dt)    
    {    
        $sql = 'DELETE From TW_CAT_REG_HIST Where van_id=:van_id: and cat_model_id=:cat_model_id: and reg_dt=:reg_dt:';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_model_id' => $cat_model_id,
              'reg_dt' => $reg_dt
        ]);
        
        return $results;
    }
}

