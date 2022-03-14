<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalMdlModel extends Model
{
    //VAN_ID, CAT_MODEL_ID, CAT_MODEL_NM, DESCRIPTION, USE_YN, REG_DT, REG_USER
    protected $table = 'TW_CAT_MODEL';
    protected $primaryKey =  ['VAN_ID','CAT_MODEL_ID'];
    protected $allowedFields = ['VAN_ID', 'CAT_MODEL_ID', 'CAT_MODEL_NM', 'DESCRIPTION', 'USE_YN', 'REG_DT', 'REG_USER'];

    public function getTerminalMdlList($cur_page, $page_count, $van_id, $cat_model_id, $cat_model_nm)    
    {        
        $sql = 'SELECT * FROM (SELECT * FROM TW_CAT_MODEL
                Where CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END
                and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
                and CASE WHEN :cat_model_nm: = "" THEN true ELSE cat_model_nm=:cat_model_nm: END) a
                left join TW_VAN_INFO b on a.van_id = b.van_id
                ORDER BY a.van_id, a.cat_model_id DESC        
                LIMIT :page_count: 
                offset :offset:'; 
                
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_model_id' => $cat_model_id,
              'cat_model_nm' => $cat_model_nm,
              'page_count' => $page_count,
              'offset' =>  ($cur_page - 1) * $page_count
        ]);

        $count_sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT * FROM TW_CAT_MODEL
            Where CASE WHEN :cat_model_id: = "" THEN true ELSE cat_model_id=:cat_model_id: END
            and CASE WHEN :van_id: = "" THEN true ELSE van_id=:van_id: END 
            and CASE WHEN :cat_model_nm: = "" THEN true ELSE cat_model_nm=:cat_model_nm: END) a
            left join TW_VAN_INFO b on a.van_id = b.van_id
            ORDER BY a.van_id, a.cat_model_id DESC';        
        
        $count_results = $this->db->query($count_sql, [
            'van_id' => $van_id,
            'cat_model_id' => $cat_model_id,
            'cat_model_nm' => $cat_model_nm,
        ]);

        $return['list'] = $results->getResultArray();
        $return['total_count'] = ceil($count_results->getNumRows()/$page_count);

        return $return;
    }

    public function getTerminalMdl($van_id, $cat_model_id)    
    {        
        $sql = 'SELECT a.*, b.VAN_NM FROM TW_CAT_MODEL a 
                left join TW_VAN_INFO b on a.van_id = b.van_id 
                Where CASE WHEN :van_id: = "" THEN true ELSE a.van_id=:van_id: END 
                and CASE WHEN :cat_model_id: = "" THEN true ELSE a.cat_model_id=:cat_model_id: END';
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_model_id' => $cat_model_id
        ]);
        
        $return['list'] = $results->getResultArray();

        $query = $this->db->query( "SELECT FOUND_ROWS() as cnt" );
        $return['count'] = $query->getRow(2)->cnt;

        return $return;
    }

    public function getMdlIdCheck($van_id, $cat_model_id)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_CAT_MODEL  Where VAN_ID = :van_id: and CAT_MODEL_ID = :cat_model_id:';
        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'cat_model_id' => $cat_model_id
        ]);
        
        return $results->getRow();
    }
}

