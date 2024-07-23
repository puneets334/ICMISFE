<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DocDetails extends Entity
{
    
    protected $table      = 'docdetails';
    // protected $primaryKey = 'dcode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['diary_no', 'doccode', 'doccode1', 'docnum', 'docyear', 'filedby', 'docfee', 'other1', 'iastat', 'forresp', 'feemode', 'fee1', 'fee2', 'usercode', 'ent_dt', 'display', 'remark', 'lst_mdf', 'lst_user', 'j1', 'j2', 'j3', 'party', 'advocate_id', 'verified', 'verified_by', 'verified_on', 'sc_ia_sta_code', 'sc_ref_code_id', 'sc_application_no', 'no_of_copy', 'sc_old_doc_code', 'docd_id', 'verified_remarks', 'dispose_date', 'last_modified_by', 'disposal_remark', 'is_efiled'];

    protected $useTimestamps = true;
    // protected $createdField  = 'create_modify';
    // protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
