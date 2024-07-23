<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FasterCommunicationDetails extends Entity
{
    
    protected $table      = 'faster_communication_details';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'faster_cases_id', 'stakeholder_details_id', 'email_id', 'mobile_number', 'created_on', 'created_by', 'created_by_ip', 'is_deleted', 'deleted_on', 'deleted_by', 'email_sent', 'email_sent_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}