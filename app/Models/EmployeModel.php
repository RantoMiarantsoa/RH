<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model
{
    protected $table      = 'employes';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'nom', 'prenom', 'email', 'password',
        'role', 'departement_id', 'date_embauche', 'actif',
    ];

    // Ne jamais retourner le mot de passe par défaut
    protected $hidden = ['password'];

    protected $validationRules = [
        'nom'          => 'required|min_length[2]',
        'prenom'       => 'required|min_length[2]',
        'email'        => 'required|valid_email|is_unique[employes.email,id,{id}]',
        'password'     => 'required|min_length[8]',
        'role'         => 'required|in_list[employe,rh,manager,admin]',
        'date_embauche'=> 'required|valid_date',
    ];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->where('actif', 1)->first();
    }

    public function getAvecDepartement()
    {
        return $this->select('employes.*, departements.nom AS departement_nom')
                    ->join('departements', 'departements.id = employes.departement_id', 'left')
                    ->where('employes.actif', 1)
                    ->findAll();
    }
}