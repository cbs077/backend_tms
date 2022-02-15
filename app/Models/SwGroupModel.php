<?php 
namespace App\Models;
use CodeIgniter\Model;

class SwGroupModel extends Model
{
    protected $table = 'TW_SW_GROUP';
    protected $primaryKey = ['VAN_ID'. 'SW_GROUP_ID'];
    protected $allowedFields = ['VAN_ID', 'SW_GROUP_ID', 'SW_GROUP_NM', 'DESCRIPTION', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

    public function getSwGroupMgList($cur_page, $page_count, $sw_group_id, $sw_group_nm)    
    {        
        $sql = 'SELECT * FROM (SELECT * FROM TW_SW_GROUP
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_group_nm: = "" THEN true ELSE sw_group_nm=:sw_group_nm: END) a
                left join TW_VAN_INFO b on a.van_id = b.van_id
                ORDER BY a.sw_group_id DESC        
                LIMIT :page_count: 
                offset :offset:'; 
                
        $results = $this->db->query($sql, [
              'sw_group_id' => $sw_group_id,
              'sw_group_nm' => $sw_group_nm,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT * FROM TW_SW_GROUP
            Where CASE WHEN :sw_group_id: = "" THEN true ELSE sw_group_id=:sw_group_id: END
            and CASE WHEN :sw_group_nm: = "" THEN true ELSE sw_group_nm=:sw_group_nm: END) a
            left join TW_VAN_INFO b on a.van_id = b.van_id
            ORDER BY a.sw_group_id DESC';        
        
        $count_results = $this->db->query($count_sql, [
            'sw_group_id' => $sw_group_id,
            'sw_group_nm' => $sw_group_nm,
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function updateSwGroupMg($van_id, $sw_group_id, $sw_group_nm, $description)    
    {        
        $sql = 'UPDATE TW_SW_GROUP SET 
                    SW_GROUP_NM = :sw_group_nm:  ,
                    description = :description:
                Where van_id=:van_id: and sw_group_id=:sw_group_id:';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
              'sw_group_nm' => $sw_group_nm,
              'description' => $description
        ]);
        
        return $results;
    }

    public function getSwGroupMg($van_id, $sw_group_id)    
    {        
        $sql = 'SELECT * FROM TW_SW_GROUP a 
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
                and CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id
        ]);
        
        $return['list'] = $results->getResultArray();

        return $return;
    }

    public function getSwGroupIdCheck($van_id, $sw_group_id)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_SW_GROUP WHERE VAN_ID = :id: and SW_GROUP_ID = :sw_group_id:';
        $results = $this->db->query($sql, [
            'id' => $van_id,
            'sw_group_id' => $sw_group_id
        ]);
        
        return $results->getResultArray();
    }

    public function deleteSwGroupMg($van_id, $sw_group_id)    
    {    
        $sql = 'DELETE FROM TW_SW_GROUP Where van_id=:van_id: and sw_group_id=:sw_group_id:';         
        
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
        ]);
        
        return $results;
    }
}

