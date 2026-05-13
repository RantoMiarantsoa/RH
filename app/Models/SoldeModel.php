<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table      = 'soldes';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'employe_id', 'type_conge_id', 'annee',
        'jour_attribues', 'jour_pris',
    ];

    public function getSolde(int $employeId, int $typeCongeId, int $annee)
    {
        return $this->where('employe_id',    $employeId)
                    ->where('type_conge_id', $typeCongeId)
                    ->where('annee',         $annee)
                    ->first();
    }

    public function getRestant(int $employeId, int $typeCongeId, int $annee): float
    {
        $row = $this->getSolde($employeId, $typeCongeId, $annee);
        if (!$row) return 0;
        return $row['jour_attribues'] - $row['jour_pris'];
    }

    public function deduire(int $employeId, int $typeCongeId, int $annee, float $jours): bool
    {
        return $this->set('jour_pris', "jour_pris + $jours", false)
                    ->where('employe_id',    $employeId)
                    ->where('type_conge_id', $typeCongeId)
                    ->where('annee',         $annee)
                    ->update();
    }
    public function restituer(int $employeId, int $typeCongeId, int $annee, float $jours): bool
{
    return $this->set('jour_pris', "jour_pris - $jours", false)
                ->where('employe_id',    $employeId)
                ->where('type_conge_id', $typeCongeId)
                ->where('annee',         $annee)
                ->update();
}
public function getSoldesEmploye(int $employeId, int $annee)
{
    return $this->select('soldes.*, type_conge.libelle,
                          (soldes.jour_attribues - soldes.jour_pris) AS restant')
                ->join('type_conge', 'type_conge.id = soldes.type_conge_id')
                ->where('soldes.employe_id', $employeId)
                ->where('soldes.annee',      $annee)
                ->findAll();
}
}