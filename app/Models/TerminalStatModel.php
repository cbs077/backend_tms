<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalStatModel extends Model
{
    //VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, SW_GROUP_ID, SW_VERSION, STATUS, REG_DT, REG_USER, FIRST_USE_DT, LAST_USE_DT, BUSS_REG_NO, JOINS_NM, JOINS_ADDR
    protected $table = 'TW_CAT_LIST';
    protected $primaryKey = ['VAN_ID','CAT_SERIAL_NO'];
    protected $allowedFields = ['VAN_ID', 'CAT_SERIAL_NO', 'CAT_MODEL_ID', 'SW_GROUP_ID', 'SW_VERSION', 'STATUS', 'REG_DT', 'REG_USER', 'FIRST_USE_DT', 'LAST_USE_DT', 'BUSS_REG_NO', 'JOINS_NM', 'JOINS_ADDR'];





    public function getTerminalVanInfoList()
    {        
        $sql = 'select  a.VAN_ID, a.CAT_MODEL_ID, d.VAN_NM,  a.reg_dt, a.tw_count, (a.tw_count-count(distinct b.CAT_SERIAL_NO)) as init_count , count(distinct b.CAT_SERIAL_NO) as cur_count, count(distinct c.CAT_SERIAL_NO) as stop_count
        FROM (SELECT VAN_ID, CAT_MODEL_ID, count(CAT_MODEL_ID) as tw_count , max(REG_DT) as reg_dt  FROM TW_CAT_LIST 
            GROUP BY CAT_MODEL_ID, VAN_ID ) a
        left join (SELECT VAN_ID, CAT_MODEL_ID, CAT_SERIAL_NO FROM TS_CATREQ_LOG 
            where GUBUN = "VC" and RESULT_CODE=""
            group by  CAT_MODEL_ID, VAN_ID, CAT_SERIAL_NO) b on b.VAN_ID = a.VAN_ID and b.CAT_MODEL_ID = a.CAT_MODEL_ID                              
        left join (SELECT VAN_ID , CAT_MODEL_ID, CAT_SERIAL_NO FROM TS_CATREQ_LOG 
                where GUBUN = "VC" and RESULT_CODE="" and reg_dt<DATE_SUB(now(), INTERVAL 20 DAY)
                group by  CAT_MODEL_ID, VAN_ID, CAT_SERIAL_NO) c on c.VAN_ID = a.VAN_ID and c.CAT_MODEL_ID = a.CAT_MODEL_ID    
        left join TW_VAN_INFO d on d.VAN_ID = a.VAN_ID
             GROUP BY a.VAN_ID, a.CAT_MODEL_ID
        ORDER BY a.van_id DESC';  


        $results = $this->db->query($sql, [

        ]);

        $return['list'] = $results->getResultArray();

        return $return;
    }


    public function getTerminalUseInfoList($cur_page, $page_count, $van_id, $search_start_dt, $search_end_dt)
    {        
        $sql = 'SELECT a.VAN_ID, a.CAT_MODEL_ID, c.VAN_NM, a.tw_count, count(b.CAT_MODEL_ID) as sw_count, a.reg_dt
                FROM (SELECT VAN_ID, CAT_MODEL_ID, count(CAT_MODEL_ID) as tw_count , max(REG_DT) as reg_dt FROM TW_CAT_LIST 
                    Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                    and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                    and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END
                    GROUP BY CAT_MODEL_ID, VAN_ID ) a
                left join (SELECT VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, max(REG_DT) as reg_dt FROM TS_CATREQ_LOG 
                    where GUBUN = "FA" and RESULT_CODE=""
                    and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                    and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                    and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END                
                    group by CAT_SERIAL_NO, CAT_MODEL_ID, VAN_ID) b on b.VAN_ID = a.VAN_ID and b.CAT_MODEL_ID = a.CAT_MODEL_ID
                left join TW_VAN_INFO c on c.VAN_ID = a.VAN_ID
                     GROUP BY a.VAN_ID, a.CAT_MODEL_ID
                ORDER BY a.van_id DESC        
                LIMIT :page_count: 
                offset :offset:';   
                
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'search_start_dt' => $search_start_dt,
              'search_end_dt' => $search_end_dt,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT a.VAN_ID, a.CAT_MODEL_ID, c.VAN_NM, a.tw_count, count(b.CAT_MODEL_ID) as sw_count, a.reg_dt
                FROM (SELECT VAN_ID, CAT_MODEL_ID, count(CAT_MODEL_ID) as tw_count, max(REG_DT) as reg_dt FROM TW_CAT_LIST 
                    Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                    and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                    and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END
                    GROUP BY CAT_MODEL_ID, VAN_ID ) a
                left join (SELECT VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, max(REG_DT) as reg_dt FROM UCAT1.TS_CATREQ_LOG 
                    where GUBUN = "FA" and RESULT_CODE=""
                    and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                    and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                    and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END 
                    group by CAT_SERIAL_NO, CAT_MODEL_ID, VAN_ID) b on b.VAN_ID = a.VAN_ID and b.CAT_MODEL_ID = a.CAT_MODEL_ID
                left join TW_VAN_INFO c on c.VAN_ID = a.VAN_ID
                    GROUP BY a.VAN_ID, a.CAT_MODEL_ID';   

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'search_start_dt' => $search_start_dt,
            'search_end_dt' => $search_end_dt,
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }
}

