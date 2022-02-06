<?php 
namespace App\Models;
use CodeIgniter\Model;

class TerminalMdlModel extends Model
{
    //VAN_ID, CAT_MODEL_ID, CAT_MODEL_NM, DESCRIPTION, USE_YN, REG_DT, REG_USER
    protected $table = 'TW_CAT_MODEL';
    protected $primaryKey =  ['VAN_ID','CAT_MODEL_ID'];
    protected $allowedFields = ['VAN_ID', 'CAT_MODEL_ID', 'CAT_MODEL_NM', 'DESCRIPTION', 'USE_YN', 'REG_DT', 'REG_USER'];

    public function getTerminalMdl($van_id, $cat_model_id)    
    {        
        $sql = 'SELECT a.*, b.VAN_NM FROM TW_CAT_MODEL a left join TW_VAN_INFO b on a.van_id = b.van_id Where a.VAN_ID = :van_id: and a.CAT_MODEL_ID = :cat_model_id:';
        $results = $this->db->query($sql, [
              'van_id' => $van_id,
              'cat_model_id' => $cat_model_id
        ]);
        
        return $results->getResultArray();
    }

    public function getMdlIdCheck($van_id, $cat_model_id)   
    {        
        $sql = 'SELECT count(*) as count FROM TW_CAT_MODEL  Where VAN_ID = :van_id: and CAT_MODEL_ID = :cat_model_id:';
        $results = $this->db->query($sql, [
            'van_id' => $van_id,
            'cat_model_id' => $cat_model_id
        ]);
        
        return $results->getResultArray();
    }
}

