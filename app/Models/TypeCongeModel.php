
<?php

namespace App\Models;


use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table      = 'type_conge';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle', 'jour_annuels', 'deductible'];
    protected $useTimestamps = false;
}