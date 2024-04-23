<?php

require_once __DIR__ . '/router.php';

//statique
any('/', 'index.php');
any('/index', 'index.php');
any('/login', 'login.php');
any('/newUser', 'newUser.php');
any('/profil', 'pageProfil.php');
any('/newPublication', 'newPublication.php');
any('/jsonConverter', 'jsonConverter.php');

//dynamique

//profil
get('/api/getProfils', '/api/getProfils/getProfils.php');
get('/api/getPhotoProfil/$id_profil', '/api/User/getPhotoProfil.php');

//filtre
get('/api/getCategories', '/api/Categories/getCategories.php');
get('/api/getEtats', '/api/Etats/getEtats.php');
get('/api/getOnglets', '/api/Onglets/getOnglets.php');
get('/api/getPublicationsFiltresPubliques/$titre/$prixMin/$prixMax/$id_etat/$id_categorie/$id_profil', '/api/getPublicationsFiltres/getPublicationsFiltresPubliques.php');
get('/api/getPublicationsFiltresPrivees/$titre/$prixMin/$prixMax/$id_etat/$id_categorie/$id_profil', '/api/getPublicationsFiltres/getPublicationsFiltresPrivees.php');
get('/api/getPublicationsFiltresAbonnes/$titre/$prixMin/$prixMax/$id_etat/$id_categorie/$id_profil', '/api/getPublicationsFiltres/getPublicationsFiltresAbonnes.php');
get('/api/getPublicationsFiltresFavoris/$titre/$prixMin/$prixMax/$id_etat/$id_categorie/$id_profil', '/api/getPublicationsFiltres/getPublicationsFiltresFavoris.php');

//publication
get('/api/getPublication/$id', '/api/getPublication/getPublication.php');
get('/api/getPublications/$id', '/api/getPublications/getPublications.php');
get('/api/getAllPublications', '/api/getAllPublications/getAllPublications.php');
post('/api/postPublication', '/api/postPublication/postPublication.php');
put('/api/putPublication/$id', '/api/putPublication/putPublication.php');
delete('/api/deletePublication/$id', '/api/deletePublication/deletePublication.php');

//favoris
get('/api/getFavoris/$id_profil/$id_pub', '/api/Favoris/getFavoris.php');
post('/api/postFavoris', '/api/Favoris/postFavoris.php');
delete('/api/deleteFavoris/$id_profil/$id_pub', '/api/Favoris/deleteFavoris.php');

//rating
post('/api/rating', '/api/User/rateUser.php');

//user
get('/api/getUser/$id_profil', '/api/User/getUser.php');
get('/api/getUserID/$id_publication', '/api/getUserID/getUserID.php');
post('/api/newUser', '/api/User/newUser.php');
post('/api/loginUser', '/api/User/loginUser.php');
put('/api/editUserMontant/$id', '/api/editUserMontant/editUserMontant.php');

//abonnement
get('/api/getAbonnements/$id_profil', '/api/User/getAbonnements.php');
get('/api/getAbonnement/$id_profil/$id_abonne', '/api/Abonnement/getAbonnement.php');
post('/api/postAbonnement', '/api/Abonnement/postAbonnement.php');
delete('/api/deleteAbonnement/$id_profil/$id_abonne', '/api/Abonnement/deleteAbonnement.php');

any('/404', '404.php');
