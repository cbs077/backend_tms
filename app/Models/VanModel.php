<?php 
namespace App\Models;
use CodeIgniter\Model;

class VanModel extends Model
{
    protected $table = 'TW_VAN_INFO';
    protected $primaryKey = 'VAN_ID';
    protected $allowedFields = ['VAN_ID', 'VAN_NM', 'MANAGER_NM', 'PHONE', 'FAX', 'ZIP_CODE', 'ADDR1', 'ADDR2', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

    public function getVanList($cur_page, $page_count, $van_id)    
    {        
        $sql = 'SELECT * FROM TW_VAN_INFO a
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count,
              'van_id' => $van_id
        ]);

        $count_sql = 'SELECT * FROM TW_VAN_INFO a
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END'; 

        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id
        ]);
        
        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getVanMg($id)    
    {        
        $sql = 'SELECT * FROM TW_VAN_INFO WHERE VAN_ID = :id:';
        $results = $this->db->query($sql, [
              'id' => $id,
        ]);
        
        return $results->getResultArray();
    }

    public function getVanIdCheck($id)    
    {        
        $sql = 'SELECT count(*) as count FROM TW_VAN_INFO WHERE VAN_ID = :id:';
        $results = $this->db->query($sql, [
              'id' => $id,
        ]);
        
        return $results->getRow();
    }
}

