<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalModel extends Model
{
    //VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, SW_GROUP_ID, SW_VERSION, STATUS, REG_DT, REG_USER, FIRST_USE_DT, LAST_USE_DT, BUSS_REG_NO, JOINS_NM, JOINS_ADDR
    protected $table = 'TW_CAT_LIST';
    protected $primaryKey = ['VAN_ID','CAT_SERIAL_NO'];
    protected $allowedFields = ['VAN_ID', 'CAT_SERIAL_NO', 'CAT_MODEL_ID', 'SW_GROUP_ID', 'SW_VERSION', 'STATUS', 'REG_DT', 'REG_USER', 'FIRST_USE_DT', 'LAST_USE_DT', 'BUSS_REG_NO', 'JOINS_NM', 'JOINS_ADDR'];


    // TW_SW_GROUP은 van_id 없이 함.
    // TW_CAT_MODEL도 van_id관계 없앰.
    public function getTerminalList($cur_page, $page_count, $van_id, $sw_group_id, $sw_version, $cat_serial_no, $cat_model_id, $status)
    {        
        log_message('info', $cat_model_id); 

        $sql = 'SELECT *, a.CAT_SERIAL_NO, a.REG_DT, a.LAST_USE_DT, f.SS_CODE, f.BUSS_REG_NO as buss_reg_no, a.BUSS_REG_NO as CAT_BUSS_REG_NO FROM (SELECT * FROM TW_CAT_LIST
                Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END
                and CASE WHEN :status: = "" THEN true ELSE status=:status: END
                and CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END) a
                left join TW_CAT_MODEL b on  a.van_id = b.van_id and a.cat_model_id = b.cat_model_id
                left join TW_SW_GROUP c on a.sw_group_id = c.sw_group_id
                left join TW_VAN_INFO d on a.van_id = d.van_id
                left join CM_CODE_MST e on e.code_type = "W001" and a.status = e.code
                left join TW_SS_CODE_INFO f on a.cat_serial_no = f.cat_serial_no
                ORDER BY a.van_id, a.cat_serial_no DESC        
                LIMIT :page_count: 
                offset :offset:'; 
                
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'cat_serial_no' => $cat_serial_no,
              'cat_model_id' => $cat_model_id,
              'status' => $status,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT * FROM (SELECT * FROM TW_CAT_LIST
                Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                and CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE sw_version=:sw_version: END
                and CASE WHEN :cat_serial_no: = "" THEN true ELSE cat_serial_no=:cat_serial_no: END
                and CASE WHEN :status: = "" THEN true ELSE status=:status: END
                and CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END) a
                left join TW_CAT_MODEL b on a.van_id = b.van_id and a.cat_model_id = b.cat_model_id
                left join TW_SW_GROUP c on a.sw_group_id = c.sw_group_id
                left join TW_VAN_INFO d on a.van_id = d.van_id
                left join CM_CODE_MST e on e.code_type = "W001" and a.status = e.code
                left join TW_SS_CODE_INFO f on a.cat_serial_no = f.cat_serial_no and a.buss_reg_no = f.buss_reg_no';  

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'sw_group_id' => $sw_group_id,
            'sw_version' => $sw_version,
            'status' => $status,
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
        
        return $results->getRow();
    }

    public function updateTerminal($van_id, $cat_serial_no, $cat_model_id, $sw_group_id, $status)    
    {        
        $sql = 'UPDATE TW_CAT_LIST SET 
                    cat_model_id = CASE WHEN :cat_model_id: = "" THEN cat_model_id ELSE :cat_model_id: END ,
                    sw_group_id = CASE WHEN :sw_group_id: = "" THEN sw_group_id ELSE :sw_group_id: END ,
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

