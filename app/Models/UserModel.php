<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'TW_USER_INFO';
    protected $primaryKey = 'USER_ID';
    protected $allowedFields = ['USER_ID', 'USER_NM', 'COMP_ID', 'PWD', 'USER_RIGHTS', 'PHONE', 'FAX', 'ZIP_CODE', 'ADDR1', 'ADDR2', 'REG_DT', 'REG_USER', 'UPDATE_DT'];

    public function getSwOprMgList($cur_page, $page_count, $van_id, $user_id, $user_nm)    ///WHERE CASE WHEN van_id<800 THEN  :van_id: ELSE END Where a.van_id = :sw_group_id: and a.sw_version = :sw_version:'
    {        
        $sql = 'SELECT * FROM TW_USER_INFO a
                Where CASE WHEN :comp_id: = "" THEN true ELSE a.comp_id=:comp_id: END and
                CASE WHEN :user_id: = "" THEN true ELSE a.user_id=:user_id: END and
                CASE WHEN :user_nm: = "" THEN true ELSE a.user_nm=:user_nm: END
                LIMIT :page_count: 
                offset :offset:'; 

        $results = $this->db->query($sql, [
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count,
              'comp_id' => $van_id,
              'user_id' => $user_id,
              'user_nm' => $user_nm,
        ]);

        $count_sql = 'SELECT * FROM TW_USER_INFO a
            Where CASE WHEN :comp_id: = "" THEN true ELSE a.comp_id=:comp_id: END and
            CASE WHEN :user_id: = "" THEN true ELSE a.user_id=:user_id: END and
            CASE WHEN :user_nm: = "" THEN true ELSE a.user_nm=:user_nm: END';

        $count_results = $this->db->query($count_sql, [
            'comp_id' => $van_id,
            'user_id' => $user_id,
            'user_nm' => $user_nm
        ]);
        
        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getUserInfo($id)    
    {        
        $sql = 'SELECT *, CASE WHEN user_rights = "S" THEN "SK" ELSE (SELECT VAN_NM FROM TW_VAN_INFO WHERE van_id = a.comp_id) END user_rights_nm
        FROM TW_USER_INFO a WHERE USER_ID = :id:';

        $results = $this->db->query($sql, [
              'id' => $id,
        ]);
        
        return $results->getResultArray();
    }
}

