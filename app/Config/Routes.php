<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->group('/rh', function ($routes) {
 
    $routes->get('demandes',           'RhController::showDemandeAttente');
    $routes->get('approuver/(:num)',   'RhController::approuverConge/$1');
    $routes->get('refuser/(:num)',     'RhController::refuserConge/$1');
    $routes->get('annuler/(:num)',     'RhController::annulerConge/$1');

    });
$routes->get('/',        'AuthController::login');
$routes->post('login',   'AuthController::doLogin');
$routes->get('logout',   'AuthController::logout');

$routes->group('/employe', ['filter' => 'auth'], function ($routes) {
    // Dashboard employé
    $routes->get('dashboard',           'EmployeController::dashboard');
    // Demandes
    $routes->get('demandes',            'EmployeController::mesDemandes');
    $routes->get('demandes/creer',      'EmployeController::creerDemande');
    $routes->post('demandes/creer',     'EmployeController::sauvegarderDemande');
    // Solde
    $routes->get('soldes',              'EmployeController::mesSoldes');
});
$routes->group('/admin', ['filter' => 'auth'], function ($routes) {
    // Employés
    $routes->get('employes',                'AdminController::listeEmployes');
    $routes->get('employes/creer',          'AdminController::creerEmploye');
    $routes->post('employes/creer',         'AdminController::sauvegarderEmploye');
    $routes->get('employes/editer/(:num)',   'AdminController::editerEmploye/$1');
    $routes->post('employes/editer/(:num)', 'AdminController::mettreAJourEmploye/$1');
    $routes->get('employes/desactiver/(:num)', 'AdminController::desactiverEmploye/$1');

    $routes->get('departements',                    'AdminController::listeDepartements');
    $routes->get('departements/creer',              'AdminController::creerDepartement');
    $routes->post('departements/creer',             'AdminController::sauvegarderDepartement');
    $routes->get('departements/editer/(:num)',      'AdminController::editerDepartement/$1');
    $routes->post('departements/editer/(:num)',     'AdminController::mettreAJourDepartement/$1');
    $routes->get('departements/supprimer/(:num)',   'AdminController::supprimerDepartement/$1');

            // Types de congé
        $routes->get('type-conge',                  'AdminController::listeTypeConge');
        $routes->get('type-conge/creer',            'AdminController::creerTypeConge');
        $routes->post('type-conge/creer',           'AdminController::sauvegarderTypeConge');
        $routes->get('type-conge/editer/(:num)',    'AdminController::editerTypeConge/$1');
        $routes->post('type-conge/editer/(:num)',   'AdminController::mettreAJourTypeConge/$1');
        $routes->get('type-conge/supprimer/(:num)', 'AdminController::supprimerTypeConge/$1');

        $routes->get('dashboard', 'AdminController::dashboard');
});