<?php
namespace App\Controllers;

class Employe extends BaseController{
    public function index(){
        // return view('page/Login');
    }
    
    public function connexion(){
        $password = $this->request->getPost('password');
        $hash = password_hash($password, PASSWORD_DEFAULT); 
        $email = $this->request->getPost('email');
        $employe = $this->EmployeModel->getByEmail($email);
         if (!$employe || !password_verify($password, $employe['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['general' => 'Email ou mot de passe incorrect.']);
        }

        session()->set('employe_id', $employe['id']);
        session()->set('employe_email', $employe['email']);

        return redirect()->to(base_url('/home'));
    }
}