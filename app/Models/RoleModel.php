<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'sys_roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];

    // Validation Rules
    protected $validationRules      = [
        'name' => 'required|min_length[3]|max_length[50]|is_unique[sys_roles.name,id,{id}]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}
