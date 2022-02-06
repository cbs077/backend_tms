<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalModel extends Model
{
    //VAN_ID, CAT_SERIAL_NO, CAT_MODEL_ID, SW_GROUP_ID, SW_VERSION, STATUS, REG_DT, REG_USER, FIRST_USE_DT, LAST_USE_DT, BUSS_REG_NO, JOINS_NM, JOINS_ADDR
    protected $table = 'TW_CAT_LIST';
    protected $primaryKey = ['VAN_ID','CAT_SERIAL_NO'];
    protected $allowedFields = ['VAN_ID', 'CAT_SERIAL_NO', 'CAT_MODEL_ID', 'SW_GROUP_ID', 'SW_VERSION', 'STATUS', 'REG_DT', 'REG_USER', 'FIRST_USE_DT', 'LAST_USE_DT', 'BUSS_REG_NO', 'JOINS_NM', 'JOINS_ADDR'];

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
}

