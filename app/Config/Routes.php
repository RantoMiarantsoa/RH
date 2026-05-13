<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produits', 'Produit::index');
$routes->get('/produits/(:num)', 'Produit::show/$1');

$routes->group('employe',function($routes){
    $routes->post('/connexion','Employe::connexion');
    $routes->get('/deconnexion','Employe::deconnexion'); 
});


