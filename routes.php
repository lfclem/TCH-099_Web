<?php

require_once __DIR__ . '/router.php';

any('/', 'index.php');
any('/index', 'index.php');
any('/login', 'login.php');
any('/newUser', 'newUser.php');
any('/profil', 'pageProfil.php');
any('/newPublication', 'newPublication.php');
any('/jsonConverter', 'jsonConverter.php');

get('/api/getProfils', '/api/getProfils/getProfils.php');
get('/api/getCategories', '/api/getCategories/getCategories.php');
get('/api/getPublications/$id', '/api/getPublications/getPublications.php');
get('/api/getAllPublications', '/api/getAllPublications/getAllPublications.php');
get('/api/getPanier/$id', '/api/getPanier/getPanier.php');
get('/api/getPaiement/$id', '/api/getPaiement/getPaiement.php');
post('/api/postPublication/', '/api/postPublication/postPublication.php');
put('/api/putPublication/$id', '/api/putPublication/putPublication.php');
delete('/api/deletePublication/$id', '/api/deletePublication/deletePublication.php');

any('/404', '404.php');
