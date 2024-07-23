<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubHeading extends Entity
{
    protected $db;
    protected $table      = 'subheading';
    protected $primaryKey = '';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}