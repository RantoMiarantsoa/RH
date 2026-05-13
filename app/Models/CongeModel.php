<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table      = 'conges';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;  // gère created_at / updated_at

    protected $allowedFields = [
        'employe_id', 'type_conge_id', 'date_debut', 'date_fin',
        'nb_jours', 'motif', 'statut', 'commentaire_rh', 'traite_par',
    ];

    protected $validationRules = [
        'employe_id'    => 'required|integer',
        'type_conge_id' => 'required|integer',
        'date_debut'    => 'required|valid_date',
        'date_fin'      => 'required|valid_date',
        'nb_jours'      => 'required|decimal|greater_than[0]',
    ];

    // ── Requêtes métier ──────────────────────────────────────────────────────

    public function getEnAttente()
    {
        return $this->select('conges.*, 
                    employes.nom, employes.prenom,
                    type_conge.libelle AS type_libelle')
                    ->join('employes',   'employes.id   = conges.employe_id')
                    ->join('type_conge', 'type_conge.id = conges.type_conge_id')
                    ->where('conges.statut', 'en_attente')
                    ->orderBy('conges.created_at', 'ASC')
                    ->findAll();
    }

    public function getByEmploye(int $employeId)
    {
        return $this->select('conges.*, type_conge.libelle AS type_libelle')
                    ->join('type_conge', 'type_conge.id = conges.type_conge_id')
                    ->where('conges.employe_id', $employeId)
                    ->orderBy('conges.date_debut', 'DESC')
                    ->findAll();
    }

    public function approuver(int $id, int $rhId, string $commentaire = ''): bool
    {
        return $this->update($id, [
            'statut'         => 'approuve',
            'commentaire_rh' => $commentaire,
            'traite_par'     => $rhId,
        ]);
    }

    public function refuser(int $id, int $rhId, string $motif): bool
    {
        return $this->update($id, [
            'statut'         => 'refuse',
            'commentaire_rh' => $motif,
            'traite_par'     => $rhId,
        ]);
    }
}