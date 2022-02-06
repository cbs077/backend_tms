<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'TW_USER_INFO';
    protected $primaryKey = 'USER_ID';
    protected $allowedFields = ['USER_ID', 'USER_NM', 'COMP_ID', 'PWD', 'USER_RIGHTS', 'PHONE', 'FAX', 'ZIP_CODE', 'ADDR1', 'ADDR2', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

    public function getUserInfo($id)    
    {        
        $sql = 'SELECT * FROM TW_USER_INFO WHERE USER_ID = :id:';
        $results = $this->db->query($sql, [
              'id' => $id,
        ]);
        
        return $results->getResultArray();
    }


    // COMP_ID = VANID
    //public $getUserInfo = 'SELECT * FROM TW_USER_INFO WHERE id = :id:';
}

