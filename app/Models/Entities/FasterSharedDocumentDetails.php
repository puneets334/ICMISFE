<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FasterSharedDocumentDetails extends Entity
{
    
    protected $table      = 'faster_shared_document_details';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'faster_cases_id', 'tw_notice_id', 'dated', 'file_path', 'file_name', 'process_id', 'remarks', 'created_on', 'created_by', 'created_by_ip', 'is_digitally_signed', 'digitally_signed_on', 'is_deleted', 'deleted_on', 'is_digitally_certified', 'digitally_certified_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}