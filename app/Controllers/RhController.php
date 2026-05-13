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
    public function __construct()
    {
        // Vérifier l'authentification et le rôle
        if (!session()->get('logged_in')) {
            redirect()->to('/login')->send();
        }
        
        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'rh') {
            redirect()->to('/login')->with('error', 'Accès refusé')->send();
        }
    }
    public function index()
    {
        return view('rh/index');
    }

    public function showDemandeAttente()
    {
        $congeModel = new CongeModel();

        $data['conges'] = $congeModel->getEnAttente();
        $data['role'] = session()->get('role');

        return view('rh/demandes', $data);
    }


    public function approuverConge($id)
    {
        $rhId  = session()->get('employe_id');

        if (!$rhId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }

        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

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

    public function refuserConge($id)
    {
        $rhId = session()->get('employe_id');

        if (!$rhId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }

        $congeModel = new CongeModel();
        $congeModel->refuser($id, $rhId, 'Demande refusée');

        return redirect()->to('/rh/demandes')->with('success', 'Congé refusé avec succès');
    }

    public function annulerConge($id)
    {
        $rhId = session()->get('employe_id');

        if (!$rhId) {
            return redirect()->to('/employe/connexion')->with('error', 'Veuillez vous connecter');
        }

        $congeModel = new CongeModel();
        $congeModel->annuler($id, $rhId, 'Demande annulée');

        return redirect()->to('/rh/demandes')->with('success', 'Congé annulé avec succès');
    }
}
