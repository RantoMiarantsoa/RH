<?php
namespace App\Controllers;

use App\Models\ProduitModel;

class Produit extends BaseController
{
    public function index()
    {
        $model = new ProduitModel();
        $data['produits'] = $model->findAll();

        $nom = $this->request->getPost('nom');
        
        if ($nom) {
            return redirect()->to('/produits');
        }

   
        return view('listeProduit', $data);
    }

    public function show($id)
    {
        return "Détails du produit avec ID: " . $id;
    }

    
}