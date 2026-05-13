<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Déjà connecté → redirige selon le rôle
        if (session()->get('employe_id')) {
            return $this->redirectParRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function doLogin()
    {
        $employeModel = new EmployeModel();

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()
                             ->with('error', 'Email et mot de passe requis');
        }

        $employe = $employeModel->findByEmail($email);

        if (!$employe || !password_verify($password, $employe['password'])) {
            return redirect()->back()
                             ->with('error', 'Email ou mot de passe incorrect');
        }

        if (!$employe['actif']) {
            return redirect()->back()
                             ->with('error', 'Compte désactivé, contactez le RH');
        }

        // Stocke la session
        session()->set([
            'employe_id' => $employe['id'],
            'nom'        => $employe['nom'],
            'prenom'     => $employe['prenom'],
            'email'      => $employe['email'],
            'role'       => $employe['role'],
        ]);

        return $this->redirectParRole($employe['role']);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }

    private function redirectParRole(string $role)
    {
        return match($role) {
            'admin'   => redirect()->to('/admin/dashboard'),
            'rh'      => redirect()->to('/rh/demandes'),
            'manager' => redirect()->to('/rh/demandes'),
            default   => redirect()->to('/employe/dashboard'),
        };
    }
}