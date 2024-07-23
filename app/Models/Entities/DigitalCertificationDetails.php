<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DigitalCertificationDetails extends Entity
{
    
    protected $table      = 'digital_certification_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'certificate_number', 'certificate_year', 'faster_cases_id', 'faster_shared_document_details_id', 'created_at', 'created_by', 'is_deleted', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
