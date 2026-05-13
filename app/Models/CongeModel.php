<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;

class CongeModel extends Model
{
    protected $table      = 'conges';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; 

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

    $conge = $this->find($id);

    $soldeModel = new SoldeModel();
  $annee = (int) substr($conge['date_debut'], 0, 4);
        $typeCongeModel = new TypeCongeModel();
        $typeConge = $typeCongeModel->find($conge['type_conge_id']);
        if($typeConge['deductible']){
            $soldeModel->deduire(
                $conge['employe_id'],
                $conge['type_conge_id'],
                $annee,
                $conge['nb_jours']
                );
                }
        return $this->update($id, [
            'statut'         => 'approuve',
            'commentaire_rh' => $commentaire,
            'traite_par'     => $rhId,
        ]);
    }

  public function refuser(int $id, int $rhId, string $motif): bool
{
    $conge = $this->find($id);
    $soldeModel = new SoldeModel();
    $annee = (int) substr($conge['date_debut'],0,4);
    $typeCongeModel= new TypeCongeModel();
    if($conge['statut']=='approuve'){
        $typeConge = $typeCongeModel->find($conge['type_conge_id']);

           if($typeConge['deductible']){
            $soldeModel->recréditer(
                $conge['employe_id'],
                $conge['type_conge_id'],
                $annee,
                $conge['nb_jours']
                );
                }

        }
    return $this->update($id, [
        'statut'         => 'refuse',
        'commentaire_rh' => $motif,
        'traite_par'     => $rhId,
    ]);
}
      public function annuler(int $id, int $rhId, string $motif): bool
    {
            $conge = $this->find($id);
    $soldeModel = new SoldeModel();
    $annee = (int) substr($conge['date_debut'],0,4);
    $typeCongeModel= new TypeCongeModel();
    if($conge['statut']=='approuve'){
        $typeConge = $typeCongeModel->find($conge['type_conge_id']);

           if($typeConge['deductible']){
            $soldeModel->recréditer(
                $conge['employe_id'],
                $conge['type_conge_id'],
                $annee,
                $conge['nb_jours']
                );
                }

        }
        return $this->update($id, [
            'statut'         => 'annule',
            'commentaire_rh' => $motif,
            'traite_par'     => $rhId,
        ]);
    }
}