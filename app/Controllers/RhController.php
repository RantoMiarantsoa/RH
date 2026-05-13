<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\TypeCongeModel;
use App\Models\CongeModel;
use App\Models\SoldeModel;
use CodeIgniter\Controller;
use Tests\Support\Libraries\ConfigReader;

class RhController extends Controller
{
    public function index()
    {
        return view('rh/index');
    }
    public function showDemandeAttente()
    {
        $congeModel = new CongeModel();

        $data['conges'] = $congeModel->getEnAttente();

        return view('rh/demandes', $data);
    }


    public function approuverConge($id)
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

        $rhId  = session()->get('employe_id');
        $conge = $congeModel->find($id);

        if (!$conge) {
            return redirect()->to('/rh/demandes');
        }

        $annee = (int) substr((string) $conge['date_debut'], 0, 4);

        $solde = $soldeModel->getSolde(
            (int) $conge['employe_id'],
            (int)   $conge['type_conge_id'],
            $annee
        );

        if (!$solde) {
            return redirect()->to('/rh/demandes');
        }

        if (($solde['jour_pris'] + $conge['nb_jours']) <= $solde['jour_attribues']) {
            $congeModel->approuver($id, $rhId, 'Demande acceptée');
            return redirect()->to('/rh/demandes')->with('success', 'Congé approuvé avec succès');
        } else {
            return redirect()->to('/rh/demandes')->with('error', 'Solde insuffisant pour cet employé');
        }

        return redirect()->to('/rh/demandes');
    }

    public function refuserDemande($id)
    {
        $congeModel = new CongeModel();
        $rhId = session()->get('employe_id');
        $congeModel->refuser($id, $rhId, 'Demande refusé');

        return redirect()->to('/rh/demandes')->with('success', 'Demande refusée avec succès');
    }
    public function annuleDemande($id)
    {
        $congeModel = new CongeModel();
        $rhId = session()->get('employe_id');
        $congeModel->annuler($id, $rhId, 'Demande annulée');

        return redirect()->to('/rh/demandes')->with('success', 'Demande refusée avec succès');
    }
}
