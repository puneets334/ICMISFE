<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SentencePeriod extends Entity
{
    protected $db;
    protected $table      = 'master.sentence_period';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'sentence_yr', 'ucode', 'entdt', 'sentence_mth', 'lower_court_id', 'id', 'accused_id', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}