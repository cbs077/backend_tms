<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalModel extends Model
{
    //VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, SW_GROUP_ID, SW_VERSION, STATUS, REG_DT, REG_USER, FIRST_USE_DT, LAST_USE_DT, BUSS_REG_NO, JOINS_NM, JOINS_ADDR
    protected $table = 'TW_CAT_LIST';
    protected $primaryKey = ['VAN_ID','CAT_SERIAL_NO'];
    protected $allowedFields = ['VAN_ID', 'CAT_SERIAL_NO', 'CAT_MODEL_ID', 'SW_GROUP_ID', 'SW_VERSION', 'STATUS', 'REG_DT', 'REG_USER', 'FIRST_USE_DT', 'LAST_USE_DT', 'BUSS_REG_NO', 'JOINS_NM', 'JOINS_ADDR'];


    public function getTerminalList($cur_page, $page_count, $sw_group_id, $sw_version, $cat_serial_no, $cat_model_id)
    {        
        $sql = 'SELECT * FROM (SELECT * FROM TW_CAT_LIST
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END
                and CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END) a
                left join TW_CAT_MODEL b on a.van_id = b.van_id and a.cat_model_id = b.cat_model_id
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id
                left join TW_VAN_INFO d on a.van_id = d.van_id
                left join CM_CODE_MST e on e.code_type = "W001" and a.status = e.code
                ORDER BY a.van_id, cat_serial_no DESC        
                LIMIT :page_count: 
                offset :offset:'; 
                
        $results = $this->db->query($sql, [
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'cat_serial_no' => $cat_serial_no,
              'cat_model_id' => $cat_model_id,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM (SELECT * FROM TW_CAT_LIST
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END
                and CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END) a
                left join TW_CAT_MODEL b on a.van_id = b.van_id and a.sw_group_id = b.cat_model_id
                left join TW_SW_GROUP c on a.van_id = c.van_id and a.sw_group_id = c.sw_group_id
                left join TW_VAN_INFO d on a.van_id = d.van_id
                left join CM_CODE_MST e on e.code_type = "W001" and a.status = e.code';   

        $count_results = $this->db->query($count_sql, [
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
            'cat_serial_no' => $cat_serial_no,
            'cat_model_id' => $cat_model_id
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getTerminal($van_id, $serial_no)    
    {        
        $sql = 'SELECT * FROM TW_CAT_LIST WHERE VAN_ID = :van_id: and CAT_SERIAL_NO = :serial_no:';
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'serial_no' => $serial_no
        ]);
        
        return $results->getResultArray();
    }

    public function getCatIdCheck($van_id, $serial_no)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_CAT_LIST WHERE VAN_ID = :van_id: and CAT_SERIAL_NO = :serial_no:';
        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'serial_no' => $serial_no
        ]);
        
        return $results->getResultArray();
    }

    public function updateTerminal($van_id, $cat_serial_no, $cat_model_id, $sw_group_id, $status)    
    {        
        $sql = 'UPDATE TW_CAT_LIST SET 
                    cat_model_id = :cat_model_id:,
                    sw_group_id = :sw_group_id:,
                    status = CASE WHEN :status: = "" THEN status ELSE :status: END 
                Where van_id=:van_id: and cat_serial_no=:cat_serial_no:';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_serial_no' => $cat_serial_no,
              'cat_model_id' => $cat_model_id,
              'sw_group_id' => $sw_group_id,
              'status' => $status
        ]);
        
        return $results;
    }

    public function deleteTerminal($van_id, $cat_serial_no)    
    {    
        $sql = 'DELETE FROM TW_CAT_LIST Where van_id=:van_id: and cat_serial_no=:cat_serial_no:';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_serial_no' => $cat_serial_no,
        ]);
        
        return $results;
    }
}

