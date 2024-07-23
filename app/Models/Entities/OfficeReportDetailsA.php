<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OfficeReportDetailsA extends Entity
{
    protected $db;
    protected $table      = 'office_report_details_a';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'order_dt', 'office_report_id', 'rec_dt', 'rec_user_id', 'status', 'office_repot_name', 'display', 'web_status', 'master_id', 'batch', 'discarded_by', 'user_ip', 'discarded_date', 'summary', 'gist_last_read_datetime', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}