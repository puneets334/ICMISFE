<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Proceedings extends Entity
{
    protected $db;
    protected $table      = 'proceedings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'order_date', 'court_number', 'item_number', 'diary_no', 'order_details', 'generated_by', 'generated_on', 'file_name', 'upload_flag', 'uploaded_by', 'upload_date_time', 'order_type', 'is_oral_mentioning', 'replace_reason', 'app_no', 'registration_number', 'registration_year', 'roster_id', 'display', 'ordernet_id', 'is_reportable', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}