<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FdrRecords extends Entity
{
    
    protected $table      = 'fdr_records';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'type', 'document_number', 'ec_case_id', 'petitioner_name', 'respondent_name', 'account_number', 'amount', 'ref_section_code', 'ref_bank_id', 'ref_status_id', 'deposit_date', 'maturity_date', 'order_date', 'mode_code', 'mode_document_number', 'remarks', 'case_number_display', 'updated_by_id', 'updated_by_name', 'updated_datetime', 'ip_address', 'is_deleted', 'roi', 'days', 'month', 'year', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}