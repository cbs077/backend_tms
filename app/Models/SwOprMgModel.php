<?php 
namespace App\Models;
use CodeIgniter\Model;

class SwOprMgModel extends Model
{
    //VAN_ID, SW_GROUP_ID, SW_VERSION, APPL_DT, REG_DT, REG_USER, DATA_SIZE, FILE_PATH, FILE_NM, UPLOAD_FILE_NM
    protected $table = 'TW_SW_VERSION';
    protected $primaryKey = ['VAN_ID'. 'SW_GROUP_ID', 'SW_VERSION'];
    protected $allowedFields = ['VAN_ID', 'SW_GROUP_ID', 'SW_VERSION', 'APPL_DT', 'REG_DT', 'REG_USER', 'DATA_SIZE', 'FILE_PATH', 'FILE_NM', 'UPLOAD_FILE_NM'];

    public function getSwOprMgList($cur_page, $page_count, $van_id, $sw_group_id, $sw_version)    ///WHERE CASE WHEN van_id<800 THEN  :van_id: ELSE END Where a.van_id = :sw_group_id: and a.sw_version = :sw_version:'
    {        
        $sql = 'SELECT *, b.REG_DT as REG_DT FROM 
                    (SELECT van_id, sw_group_id, max(SW_VERSION) as sw_version FROM TW_SW_VERSION 
                        Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                        GROUP BY van_id, sw_group_id
                    ) a
                left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
                left join TW_VAN_INFO c on a.van_id = c.van_id 
                left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END and
                CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM 
            (SELECT van_id, sw_group_id, max(SW_VERSION) as sw_version FROM TW_SW_VERSION 
            Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END GROUP BY van_id, sw_group_id) a
            left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
            left join TW_VAN_INFO c on a.van_id = c.van_id 
            left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
            Where CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END and
            CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END';

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version
        ]);
        
        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getSwUpgradeList($cur_page, $page_count, $van_id, $sw_group_id, $sw_version)  
    {        
        $sql = 'SELECT *, a.REG_DT FROM TW_SW_VERSION a
                left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
                left join TW_VAN_INFO c on a.van_id = c.van_id 
                left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
                and CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END                
                ORDER BY a.reg_dt DESC
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
            'page_count' => $page_count,
            'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM TW_SW_VERSION a    
            left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
            left join TW_VAN_INFO c on a.van_id = c.van_id 
            left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
            Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
            and CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END
            and CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END                
            ORDER BY a.reg_dt DESC';

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getSwUpdateList($cur_page, $page_count, $van_id, $gubun_code, $sw_group_id, $sw_version, $response, $cat_serial_no, $search_start_dt, $search_end_dt)  
    {        
        $sql = 'SELECT *, a.reg_dt as REG_DT, a.SW_GROUP_ID as SW_GROUP_ID, a.SW_VERSION as SW_VERSION FROM 
                    (SELECT * FROM TS_CATREQ_LOG 
                        Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                        and CASE WHEN :gubun_code: = "" THEN true ELSE gubun=:gubun_code: END 
                        and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END 
                        and CASE WHEN :sw_version: = "" THEN true ELSE sw_version!=:sw_version: END
                        and CASE WHEN :response: = "" THEN  result_code=:response: ELSE result_code!="" END
                        and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END   
                        and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                        and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END   
                    ) a
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id
                ORDER BY a.req_id DESC
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'gubun_code' => $gubun_code,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'response' => $response,
              'cat_serial_no' => $cat_serial_no,
              'search_start_dt' => $search_start_dt,
              'search_end_dt' => $search_end_dt,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM 
                    (SELECT * FROM TS_CATREQ_LOG 
                        Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                        and CASE WHEN :gubun_code: = "" THEN true ELSE gubun=:gubun_code: END 
                        and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END 
                        and CASE WHEN :sw_version: = "" THEN true ELSE sw_version!=:sw_version: END
                        and CASE WHEN :response: = "" THEN  result_code=:response: ELSE result_code!="" END
                        and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END   
                        and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                        and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END   
                    ) a
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id';

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'gubun_code' => $gubun_code,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
            'response' => $response,
            'cat_serial_no' => $cat_serial_no,
            'search_start_dt' => $search_start_dt,
            'search_end_dt' => $search_end_dt,
        ]);
        
        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getSwUpdateListA($cur_page, $page_count, $van_id, $gubun_code, $sw_group_id, $sw_version, $cat_serial_no, $search_start_dt, $search_end_dt)  
    {        
        $sql = 'SELECT *, a.reg_dt as REG_DT, a.SW_GROUP_ID as SW_GROUP_ID, a.SW_VERSION as SW_VERSION FROM 
                    (SELECT * FROM TS_CATREQ_LOG 
                        Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                        and CASE WHEN :gubun_code: = "" THEN true ELSE gubun=:gubun_code: END 
                        and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END 
                        and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END      
                        and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END   
                        and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                        and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END   
                    ) a
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id
                ORDER BY a.req_id DESC
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'gubun_code' => $gubun_code,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'cat_serial_no' => $cat_serial_no,
              'search_start_dt' => $search_start_dt,
              'search_end_dt' => $search_end_dt,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM 
                    (SELECT * FROM TS_CATREQ_LOG 
                        Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                        and CASE WHEN :gubun_code: = "" THEN true ELSE gubun=:gubun_code: END 
                        and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END 
                        and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                        and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END   
                        and CASE WHEN :search_start_dt: = "" THEN true ELSE reg_dt>:search_start_dt: END
                        and CASE WHEN :search_end_dt: = "" THEN true ELSE reg_dt<DATE_ADD(:search_end_dt:, INTERVAL 1 DAY) END   
                    ) a
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id';

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'gubun_code' => $gubun_code,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
            'cat_serial_no' => $cat_serial_no,
            'search_start_dt' => $search_start_dt,
            'search_end_dt' => $search_end_dt,
        ]);
        
        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function deleteSwOprMg($van_id, $sw_group_id, $sw_version)    
    {        
        $sql = 'DELETE TW_SW_VERSION Where van_id=1 and sw_group_id=2 and sw_version=5'; 

        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
        ]);
        
        return $results->getResultArray();
    }

    public function getSwIdCheck($van_id, $sw_group_id, $sw_version)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_SW_VERSION WHERE VAN_ID = :id: and SW_GROUP_ID = :sw_group_id: and SW_VERSION = :sw_version:';
        $results = $this->db->query($sql, [
            'id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version
        ]);
        
        return $results->getRow();
    }

    public function getSwUpgradeListExcel($van_id, $sw_group_id, $sw_version)    
    {        
        $sql = 'SELECT * FROM 
                (SELECT *as sw_version FROM TW_SW_VERSION 
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                Where CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                GROUP BY van_id, sw_group_id) a
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                left join TW_SW_GROUP c on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
                ORDER BY a.reg_dt DESC'; 

        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
        ]);
        
        $return['list'] = $results->getResultArray();

        $query = $this->db->query( "SELECT FOUND_ROWS() as cnt" );
        $return['count'] = $query->getRow(2)->cnt;

        return $results;
    }

}

