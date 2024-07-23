<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PendencyReportA extends Entity
{
    protected $db;
    protected $table      = 'pendency_report_a';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'submaster_id', 'main', 'conn', 'misc_main', 'misc_conn', 'regular_main', 'regular_conn', 'ent_dt', 'display', 'include_defect'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}