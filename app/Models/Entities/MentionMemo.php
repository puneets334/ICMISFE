<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MentionMemo extends Entity
{
    protected $db;
    protected $table      = 'mention_memo';

    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'date_of_received', 'date_on_decided', 'date_for_decided', 'result', 'date_of_entry', 'display', 'user_id', 'update_time', 'update_user', 'spl_remark', 'note_remark', 'pdfname', 'upload_date', 'uploadby', 'upld_dt', 'for_court', 'm_roster_id', 'm_brd_slno', 'm_conn_key', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
