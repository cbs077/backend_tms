<?php 
namespace App\Models;
use CodeIgniter\Model;

class SwGroupModel extends Model
{
    protected $table = 'TW_SW_GROUP';
    protected $primaryKey = ['VAN_ID'. 'SW_GROUP_ID'];
    protected $allowedFields = ['VAN_ID', 'SW_GROUP_ID', 'SW_GROUP_NM', 'DESCRIPTION', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

    public function getSwGroupMg($van_id, $sw_group_id)    
    {        
        $sql = 'SELECT * FROM TW_SW_GROUP WHERE VAN_ID = :id: and SW_GROUP_ID = :sw_group_id:';
        $results = $this->db->query($sql, [
              'id' => $van_id,
              'sw_group_id' => $sw_group_id
        ]);
        
        return $results->getResultArray();
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
}

