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

get('/api/getPublication/$id', '/api/getPublication/getPublication.php');
get('/api/getFavoris/$id_profil/$id_pub', '/api/Favoris/getFavoris.php');



get('/api/getPublications/$id', '/api/getPublications/getPublications.php');
get('/api/getAllPublications', '/api/getAllPublications/getAllPublications.php');
get('/api/getPanier/$id', '/api/getPanier/getPanier.php');
get('/api/getPaiement/$id', '/api/getPaiement/getPaiement.php');

post('/api/postPublication', '/api/postPublication/postPublication.php');
post('/api/postFavoris', '/api/Favoris/postFavoris.php');


put('/api/putPublication/$id', '/api/putPublication/putPublication.php');

delete('/api/deletePublication/$id', '/api/deletePublication/deletePublication.php');
delete('/api/deleteFavoris/$id_profil/$id_pub', '/api/Favoris/deleteFavoris.php');

get('/api/getAbonnement/$id_profil/$id_abonne', '/api/Abonnement/getAbonnement.php');
post('/api/postAbonnement', '/api/Abonnement/postAbonnement.php');
delete('/api/deleteAbonnement/$id_profil/$id_abonne', '/api/Abonnement/deleteAbonnement.php');

any('/404', '404.php');
