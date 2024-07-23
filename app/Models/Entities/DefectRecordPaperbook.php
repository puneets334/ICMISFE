<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DefectRecordPaperbook extends Entity
{
    
    protected $table      = 'master.defect_record_paperbook';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'id', 'diary_no','section_id', 'court_fees', 'defect_notify_date', 'rack_no', 'shelf_no', 'display', 'ent_dt', 'upd_dt', 'ent_userid', 'upd_userid', 'create_modify' ,'updated_on' ,'updated_by' ,'updated_by_ip' ];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
     
}