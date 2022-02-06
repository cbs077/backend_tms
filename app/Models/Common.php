<?php 
namespace App\Models;
use CodeIgniter\Model;

class CommonModel extends Model
{
    protected $table = 'TW_USER_INFO';
    protected $primaryKey = 'USER_ID';
    protected $allowedFields = ['USER_NM', 'COMP_ID', 'PWD', 'USER_RIGHTS', 'PHONE', 'FAX', 'ZIP_CODE', 'ADDR1', 'ADDR2', 'REG_DT', 'REG_USER', 'UPDATE_DT'];
}

