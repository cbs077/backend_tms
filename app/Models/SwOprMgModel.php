<?php 
namespace App\Models;
use CodeIgniter\Model;

class SwOprMgModel extends Model
{
    //VAN_ID, SW_GROUP_ID, SW_VERSION, APPL_DT, REG_DT, REG_USER, DATA_SIZE, FILE_PATH, FILE_NM, UPLOAD_FILE_NM
    protected $table = 'TW_SW_VERSION';
    protected $primaryKey = ['VAN_ID'. 'SW_GROUP_ID', 'SW_VERSION'];
    protected $allowedFields = ['VAN_ID', 'SW_GROUP_ID', 'SW_VERSION', 'APPL_DT', 'REG_DT', 'REG_USER', 'DATA_SIZE', 'FILE_PATH', 'FILE_NM', 'UPLOAD_FILE_NM'];

    public function getSwOprMgList($van_id, $sw_group_id, $sw_version)    ///WHERE CASE WHEN van_id<800 THEN  :van_id: ELSE END Where a.van_id = :sw_group_id: and a.sw_version = :sw_version:'

    {        
        $sql = 'SELECT * FROM 
                (SELECT van_id, sw_group_id, max(SW_VERSION) as sw_version FROM TW_SW_VERSION  GROUP BY van_id, sw_group_id) a
                left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
                left join TW_VAN_INFO c on a.van_id = c.van_id 
                left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END and
                    CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END' ;
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version
        ]);
        
        return $results->getResultArray();
    }

    // public function getSwGroupIdCheck($van_id, $sw_group_id)   
    // {        
    //     $sql = 'SELECT count(*) as count FROM TW_SW_GROUP WHERE VAN_ID = :id: and SW_GROUP_ID = :sw_group_id:';
    //     $results = $this->db->query($sql, [
    //         'id' => $van_id,
    //         'sw_group_id' => $sw_group_id
    //     ]);
        
    //     return $results->getResultArray();
    // }
}

