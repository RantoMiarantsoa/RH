<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produits', 'Produit::index');
$routes->get('/produits/(:num)', 'Produit::show/$1');


$routes->group('/rh', function ($routes) {
    
    // Demandes
    $routes->get('demandes',           'RhController::showDemandeAttente');
    $routes->get('approuver/(:num)',   'RhController::approuverConge/$1');
    $routes->get('refuser/(:num)',     'RhController::refuserConge/$1');
    $routes->get('annuler/(:num)',     'RhController::annulerConge/$1');

$routes->group('employe',function($routes){
    $routes->post('/connexion','Employe::connexion');
    $routes->get('/deconnexion','Employe::deconnexion'); 
});



    // Employés
    $routes->get('employes',           'RhController::listeEmployes');
    $routes->get('employes/(:num)',    'RhController::voirEmploye/$1');

    // Soldes
    $routes->get('soldes',             'RhController::listeSoldes');
    $routes->get('soldes/(:num)',      'RhController::voirSolde/$1');

});