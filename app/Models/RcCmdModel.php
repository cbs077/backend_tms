<?php 
namespace App\Models;
use CodeIgniter\Model;

class RcCmdModel extends Model
{
    protected $table = 'TS_CAT_RC';
    protected $primaryKey = 'REQ_ID';
    protected $allowedFields = ['REQ_ID', 'VAN_ID', 'CAT_SERIAL_NO', 'SW_VERSION', 'RESULT_CODE', 'STATUS', 'CMD', 'CMD_SUB', 'REG_DT', 'OPER_DT', 'REG_USER'];


}

