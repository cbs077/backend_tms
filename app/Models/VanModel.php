<?php 
namespace App\Models;
use CodeIgniter\Model;

class VanModel extends Model
{
    protected $table = 'TW_VAN_INFO';
    protected $primaryKey = 'VAN_ID';
    protected $allowedFields = ['VAN_ID', 'VAN_NM', 'MANAGER_NM', 'PHONE', 'FAX', 'ZIP_CODE', 'ADDR1', 'ADDR2', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

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
        
        return $results->getResultArray();
    }
    // public function insertVanMg($id)    
    // {        
    //     $sql = '
    //     SELECT * FROM TW_USER_INFO WHERE USER_ID = :id:
    //     ';
    //     $results = $this->db->query($sql, [
    //           'id' => $id,
    //     ]);
        
    //     return $results->getResultArray();
    // }
}

