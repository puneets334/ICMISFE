<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TDocDetails extends Entity
{
    protected $db;
    protected $table      = 'master.t_doc_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'title', 'category_id', 'destination_id', 'document_id', 'destination_directory', 'dated', 'from_date', 'to_date', 'by_user_id', 'authorized_by', 'access_id', 'access_dated', 'record_status', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}