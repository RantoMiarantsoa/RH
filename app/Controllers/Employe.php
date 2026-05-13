<?php
namespace App\Controllers;

use App\Models\EmployeModel;

class Employe extends BaseController
{
    protected $employeModel;

    public function __construct()
    {
        $this->employeModel = new EmployeModel();
    }

    // Affiche le formulaire de connexion
    public function index()
    {
        return view('page/Login');
    }

    // Traite la connexion
    public function connexion()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->employeModel->findByEmail($email);

        if (!$user) {
            return redirect()->back()->with('error', 'Email introuvable');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        }

        session()->set([
            'user_id'   => $user['id'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        return redirect()->to('/page/EmpDashboard');
    }

    public function deconnexion()
    {
        session()->destroy();
        return redirect()->to('/employe/connexion');
    }

    public function soumettreDemande(){
        
    }
}
