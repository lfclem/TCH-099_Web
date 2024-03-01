<?php

require_once __DIR__ . '/router.php';

any('/', 'index.php');
any('/index', 'index.php');
any('/login', 'login.php');
any('/newUser', 'newUser.php');

get('/getProfils', '/api/getProfils/getProfils.php');
get('/getCategories', '/api/getCategories/getCategories.php');
get('/getPublications/$id', '/api/getPublications/getPublications.php');
get('/getPanier/$id', '/api/getPanier/getPanier.php');
get('/getPaiement/$id', '/api/getPaiement/getPaiement.php');

any('/404', '404.php');
