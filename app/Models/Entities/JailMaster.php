<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JailMaster extends Entity
{
    protected $db;
    protected $table      = 'master.jail_master';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['loc_id', 'loc_no', 'loc_det', 'loc_address', 'state_code', 'district_code', 'loc_type', 'loc_sub_type', 'jail_name', 'police_state_code', 'police_state', 'police_district_code', 'police_district', 'police_station_code', 'police_station_name', 'cmis_state', 'cmis_district_id', 'lgd_state_code', 'lgd_district_code', 'prison_district_name', 'lgd_subdistrict_code', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}