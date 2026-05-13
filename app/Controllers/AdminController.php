<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementModel;


class AdminController extends BaseController
{
  
    public function listeEmployes()
    {
        $employeModel = new EmployeModel();

        $data['employes'] = $employeModel->getAvecDepartement();

        return view('admin/employes/liste', $data);
    }

    public function creerEmploye()
    {
        $departementModel = new DepartementModel();

        $data['departements'] = $departementModel->findAll();
        $data['employe']      = null;

        return view('admin/employes/form', $data);
    }

    public function sauvegarderEmploye()
    {
        $employeModel = new EmployeModel();

        if (!$this->validate([
            'nom'           => 'required|min_length[2]',
            'prenom'        => 'required|min_length[2]',
            'email'         => 'required|valid_email|is_unique[employes.email]',
            'password'      => 'required|min_length[8]',
            'role'          => 'required|in_list[employe,rh,manager,admin]',
            'date_embauche' => 'required|valid_date',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $employeModel->insert([
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => 1,
        ]);

        return redirect()->to('/admin/employes')
                         ->with('success', 'Employé créé avec succès');
    }


    public function editerEmploye(int $id)
    {
        $employeModel     = new EmployeModel();
        $departementModel = new DepartementModel();

        $data['employe']      = $employeModel->find($id);
        $data['departements'] = $departementModel->findAll();

        if (!$data['employe']) {
            return redirect()->to('/admin/employes')
                             ->with('error', 'Employé introuvable');
        }

        return view('admin/employes/form', $data);
    }

    public function mettreAJourEmploye(int $id)
    {
        $employeModel = new EmployeModel();

        if (!$this->validate([
            'nom'           => 'required|min_length[2]',
            'prenom'        => 'required|min_length[2]',
            'email'         => "required|valid_email|is_unique[employes.email,id,{$id}]",
            'role'          => 'required|in_list[employe,rh,manager,admin]',
            'date_embauche' => 'required|valid_date',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'date_embauche'  => $this->request->getPost('date_embauche'),
        ];

       
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $employeModel->update($id, $data);

        return redirect()->to('/admin/employes')
                         ->with('success', 'Employé mis à jour');
    }


    public function desactiverEmploye(int $id)
    {
        $employeModel = new EmployeModel();
        $employe      = $employeModel->find($id);

        if (!$employe) {
            return redirect()->to('/admin/employes')
                             ->with('error', 'Employé introuvable');
        }

       
        $employeModel->update($id, [
            'actif' => $employe['actif'] == 1 ? 0 : 1,
        ]);

        $msg = $employe['actif'] == 1 ? 'Employé désactivé' : 'Employé réactivé';

        return redirect()->to('/admin/employes')->with('success', $msg);
    }

 
public function listeDepartements()
{
    $departementModel = new DepartementModel();

    $data['departements'] = $departementModel->findAll();

    return view('admin/departements/liste', $data);
}


public function creerDepartement()
{
    $data['departement'] = null;

    return view('admin/departements/form', $data);
}

public function sauvegarderDepartement()
{
    $departementModel = new DepartementModel();

    if (!$this->validate([
        'nom' => 'required|min_length[2]|is_unique[departements.nom]',
    ])) {
        return redirect()->back()->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    $departementModel->insert([
        'nom'         => $this->request->getPost('nom'),
        'description' => $this->request->getPost('description'),
    ]);

    return redirect()->to('/admin/departements')
                     ->with('success', 'Département créé avec succès');
}


public function editerDepartement(int $id)
{
    $departementModel = new DepartementModel();

    $data['departement'] = $departementModel->find($id);

    if (!$data['departement']) {
        return redirect()->to('/admin/departements')
                         ->with('error', 'Département introuvable');
    }

    return view('admin/departements/form', $data);
}

public function mettreAJourDepartement(int $id)
{
    $departementModel = new DepartementModel();

    if (!$this->validate([
        'nom' => "required|min_length[2]|is_unique[departements.nom,id,{$id}]",
    ])) {
        return redirect()->back()->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    $departementModel->update($id, [
        'nom'         => $this->request->getPost('nom'),
        'description' => $this->request->getPost('description'),
    ]);

    return redirect()->to('/admin/departements')
                     ->with('success', 'Département mis à jour');
}

public function supprimerDepartement(int $id)
{
    $departementModel = new DepartementModel();

    $departement = $departementModel->find($id);

    if (!$departement) {
        return redirect()->to('/admin/departements')
                         ->with('error', 'Département introuvable');
    }

    $departementModel->delete($id);

    return redirect()->to('/admin/departements')
                     ->with('success', 'Département supprimé');
}


public function listeTypeConge()
{
    $typeCongeModel = new TypeCongeModel();

    $data['types'] = $typeCongeModel->findAll();

    return view('admin/type_conge/liste', $data);
}

public function creerTypeConge()
{
    $data['type'] = null;

    return view('admin/type_conge/form', $data);
}

public function sauvegarderTypeConge()
{
    $typeCongeModel = new TypeCongeModel();

    if (!$this->validate([
        'libelle'      => 'required|min_length[2]|is_unique[type_conge.libelle]',
        'jour_annuels' => 'required|decimal|greater_than_equal_to[0]',
        'deductible'   => 'required|in_list[0,1]',
    ])) {
        return redirect()->back()->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    $typeCongeModel->insert([
        'libelle'      => $this->request->getPost('libelle'),
        'jour_annuels' => $this->request->getPost('jour_annuels'),
        'deductible'   => $this->request->getPost('deductible'),
    ]);

    return redirect()->to('/admin/type-conge')
                     ->with('success', 'Type de congé créé avec succès');
}


public function editerTypeConge(int $id)
{
    $typeCongeModel = new TypeCongeModel();

    $data['type'] = $typeCongeModel->find($id);

    if (!$data['type']) {
        return redirect()->to('/admin/type-conge')
                         ->with('error', 'Type de congé introuvable');
    }

    return view('admin/type_conge/form', $data);
}

public function mettreAJourTypeConge(int $id)
{
    $typeCongeModel = new TypeCongeModel();

    if (!$this->validate([
        'libelle'      => "required|min_length[2]|is_unique[type_conge.libelle,id,{$id}]",
        'jour_annuels' => 'required|decimal|greater_than_equal_to[0]',
        'deductible'   => 'required|in_list[0,1]',
    ])) {
        return redirect()->back()->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    $typeCongeModel->update($id, [
        'libelle'      => $this->request->getPost('libelle'),
        'jour_annuels' => $this->request->getPost('jour_annuels'),
        'deductible'   => $this->request->getPost('deductible'),
    ]);

    return redirect()->to('/admin/type-conge')
                     ->with('success', 'Type de congé mis à jour');
}


public function supprimerTypeConge(int $id)
{
    $typeCongeModel = new TypeCongeModel();

    if (!$typeCongeModel->find($id)) {
        return redirect()->to('/admin/type-conge')
                         ->with('error', 'Type de congé introuvable');
    }

    $typeCongeModel->delete($id);

    return redirect()->to('/admin/type-conge')
                     ->with('success', 'Type de congé supprimé');
}
public function dashboard()
{
    $congeModel   = new CongeModel();
    $employeModel = new EmployeModel();
    $soldeModel   = new SoldeModel();

    $moisCourant = date('m');
    $anneeCourante = date('Y');

    // Absences du mois en cours
    $data['absences'] = $congeModel->getAbsencesMois($moisCourant, $anneeCourante);

    // Stats globales
    $data['total_employes']  = $employeModel->where('actif', 1)->countAllResults();
    $data['en_attente']      = $congeModel->where('statut', 'en_attente')->countAllResults();
    $data['approuves_mois']  = $congeModel->getCountParStatutMois('approuve', $moisCourant, $anneeCourante);
    $data['refuses_mois']    = $congeModel->getCountParStatutMois('refuse', $moisCourant, $anneeCourante);

    $data['mois']  = $moisCourant;
    $data['annee'] = $anneeCourante;

    return view('admin/dashboard', $data);
}
}