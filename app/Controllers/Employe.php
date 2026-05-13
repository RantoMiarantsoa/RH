<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;

class EmployeController extends BaseController
{
    private int $employeId;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->employeId = (int) session()->get('employe_id');
    }

    // ── Dashboard ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();
        $annee      = (int) date('Y');

        $data['demandes_recentes'] = $congeModel->getByEmploye($this->employeId);
        $data['soldes']            = $soldeModel->getSoldesEmploye($this->employeId, $annee);
        $data['en_attente']        = array_filter(
            $data['demandes_recentes'],
            fn($d) => $d['statut'] === 'en_attente'
        );

        return view('employe/dashboard', $data);
    }

    // ── Mes demandes ──────────────────────────────────────────────────────────
    public function mesDemandes()
    {
        $congeModel = new CongeModel();

        $data['demandes'] = $congeModel->getByEmploye($this->employeId);

        return view('employe/demandes/liste', $data);
    }

    // ── Soumettre une demande ─────────────────────────────────────────────────
    public function creerDemande()
    {
        $typeCongeModel = new TypeCongeModel();
        $soldeModel     = new SoldeModel();
        $annee          = (int) date('Y');

        $data['types']  = $typeCongeModel->findAll();
        $data['soldes'] = $soldeModel->getSoldesEmploye($this->employeId, $annee);

        return view('employe/demandes/form', $data);
    }

    public function sauvegarderDemande()
    {
        $congeModel     = new CongeModel();
        $soldeModel     = new SoldeModel();
        $typeCongeModel = new TypeCongeModel();

        if (!$this->validate([
            'type_conge_id' => 'required|integer',
            'date_debut'    => 'required|valid_date',
            'date_fin'      => 'required|valid_date',
            'motif'         => 'permit_empty|max_length[500]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $dateDebut = $this->request->getPost('date_debut');
        $dateFin   = $this->request->getPost('date_fin');
        $typeId    = (int) $this->request->getPost('type_conge_id');
        $annee     = (int) substr($dateDebut, 0, 4);

        // Calcul du nombre de jours
        $nbJours = $this->calculerJoursOuvrables($dateDebut, $dateFin);

        if ($nbJours <= 0) {
            return redirect()->back()->withInput()
                             ->with('error', 'Les dates sont invalides');
        }

        // Vérifie le solde si type déductible
        $typeConge = $typeCongeModel->find($typeId);
        if ($typeConge['deductible']) {
            $restant = $soldeModel->getRestant($this->employeId, $typeId, $annee);
            if ($restant < $nbJours) {
                return redirect()->back()->withInput()
                                 ->with('error', "Solde insuffisant — il vous reste {$restant} jours");
            }
        }

        $congeModel->insert([
            'employe_id'    => $this->employeId,
            'type_conge_id' => $typeId,
            'date_debut'    => $dateDebut,
            'date_fin'      => $dateFin,
            'nb_jours'      => $nbJours,
            'motif'         => $this->request->getPost('motif'),
            'statut'        => 'en_attente',
        ]);

        return redirect()->to('/employe/demandes')
                         ->with('success', 'Demande soumise avec succès');
    }

    // ── Mes soldes ────────────────────────────────────────────────────────────
    public function mesSoldes()
    {
        $soldeModel = new SoldeModel();
        $annee      = (int) date('Y');

        $data['soldes'] = $soldeModel->getSoldesEmploye($this->employeId, $annee);
        $data['annee']  = $annee;

        return view('employe/soldes', $data);
    }

    // ── Helper : calcul jours ouvrables ───────────────────────────────────────
    private function calculerJoursOuvrables(string $debut, string $fin): float
    {
        $start = new \DateTime($debut);
        $end   = new \DateTime($fin);
        $jours = 0;

        while ($start <= $end) {
            $dow = (int) $start->format('N');
            if ($dow < 6) $jours++; // Lundi=1 à Vendredi=5
            $start->modify('+1 day');
        }

        return (float) $jours;
    }
}