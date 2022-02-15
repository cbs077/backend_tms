<?php 
namespace App\Models;
use CodeIgniter\Model;

class SwOprMgModel extends Model
{
    //VAN_ID, SW_GROUP_ID, SW_VERSION, APPL_DT, REG_DT, REG_USER, DATA_SIZE, FILE_PATH, FILE_NM, UPLOAD_FILE_NM
    protected $table = 'TW_SW_VERSION';
    protected $primaryKey = ['VAN_ID'. 'SW_GROUP_ID', 'SW_VERSION'];
    protected $allowedFields = ['VAN_ID', 'SW_GROUP_ID', 'SW_VERSION', 'APPL_DT', 'REG_DT', 'REG_USER', 'DATA_SIZE', 'FILE_PATH', 'FILE_NM', 'UPLOAD_FILE_NM'];

    public function getSwOprMgList($cur_page, $total_page, $van_id, $sw_group_id, $sw_version)    ///WHERE CASE WHEN van_id<800 THEN  :van_id: ELSE END Where a.van_id = :sw_group_id: and a.sw_version = :sw_version:'

    {        
        $sql = 'SELECT * FROM 
                (SELECT van_id, sw_group_id, max(SW_VERSION) as sw_version FROM TW_SW_VERSION Where CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END
                GROUP BY van_id, sw_group_id) a
                left join TW_SW_VERSION b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id and a.sw_version = b.sw_version
                left join TW_VAN_INFO c on a.van_id = c.van_id 
                left join TW_SW_GROUP d on a.van_id = d.van_id and a.sw_group_id = d.sw_group_id
                Where CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END and
                CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END
                LIMIT :total_page: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'sw_group_id' => $sw_group_id,
              'sw_version' => $sw_version,
              'total_page' => $total_page,
              'offset' =>  ($cur_page - 1) * $total_page
        ]);
        
        $return['list'] = $results->getResultArray();

        $query = $this->db->query( "SELECT FOUND_ROWS() as cnt" );
        $return['count'] = $query->getRow()->cnt;

        return $return;
    }
    public function getSwOprMg($van_id, $sw_group_id, $sw_version)    
    {        
        $sql = 'SELECT a.*, b.sw_group_nm FROM TW_SW_VERSION a
                left join TW_SW_GROUP b on a.van_id = b.van_id and a.sw_group_id = b.sw_group_id
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
                and CASE WHEN :sw_group_id: = "" THEN true ELSE a.sw_group_id=:sw_group_id: END
                and CASE WHEN :sw_version: = "" THEN true ELSE a.sw_version=:sw_version: END                
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

    public function getSwIdCheck($van_id, $sw_group_id)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_SW_GROUP WHERE VAN_ID = :id: and SW_GROUP_ID = :sw_group_id:';
        $results = $this->db->query($sql, [
            'id' => $van_id,
            'sw_group_id' => $sw_group_id
        ]);
        
        return $results->getResultArray();
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

