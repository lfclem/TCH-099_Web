CREATE TABLE
    Profil (
        id_profil INTEGER PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        info_paiement VARCHAR(255) NULL,
        date_naissance DATE NOT NULL,
        photo_profil BLOB NULL,
        bio VARCHAR(255) NULL,
        statut INTEGER DEFAULT 1,
        adresse VARCHAR(255) NOT NULL,
        montant_balance DECIMAL(10, 2) DEFAULT 0,
        nb_rating INTEGER DEFAULT 0,
        rating_total DECIMAL(10, 2) DEFAULT 0
    );

CREATE TABLE
    Categorie (
        id_categorie INTEGER PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(255) NOT NULL
    );

CREATE TABLE
    Onglet (
        id_onglet INTEGER PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(255) NOT NULL
    );

CREATE TABLE
    Etat (
        id_etat INTEGER PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(255) NOT NULL
    );

CREATE TABLE
    Publication (
        id_publication INTEGER PRIMARY KEY AUTO_INCREMENT,
        titre VARCHAR(255) NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        description VARCHAR(255) NULL,
        image BLOB NOT NULL,
        etat INTEGER REFERENCES Etat (id_etat) ON DELETE CASCADE NOT NULL,
        categorie INTEGER REFERENCES Categorie (id_categorie) ON DELETE CASCADE NOT NULL,
        id_profil INTEGER REFERENCES Profil (id_profil) ON DELETE CASCADE
    );

CREATE TABLE
    Paiement (
        id_paiement INTEGER PRIMARY KEY AUTO_INCREMENT,
        montant DECIMAL(10, 2) NOT NULL,
        info_methode_paiement VARCHAR(255) NOT NULL,
        date_paiement DATE NOT NULL,
        id_profil INTEGER NOT NULL,
        id_publication INTEGER NOT NULL,
        FOREIGN KEY (id_profil) REFERENCES Profil (id_profil) ON DELETE CASCADE,
        FOREIGN KEY (id_publication) REFERENCES Publication (id_publication) ON DELETE CASCADE
    );

CREATE TABLE
    Publication_Favoris (
        id_profil INTEGER NOT NULL,
        id_publication INTEGER NOT NULL,
        PRIMARY KEY (id_profil, id_publication),
        FOREIGN KEY (id_profil) REFERENCES Profil (id_profil) ON DELETE CASCADE,
        FOREIGN KEY (id_publication) REFERENCES Publication (id_publication) ON DELETE CASCADE
    );

CREATE TABLE
    Profil_Abonnements (
        id_profil INTEGER NOT NULL,
        id_abonne INTEGER NOT NULL,
        PRIMARY KEY (id_profil, id_abonne),
        FOREIGN KEY (id_profil) REFERENCES Profil (id_profil) ON DELETE CASCADE,
        FOREIGN KEY (id_abonne) REFERENCES Profil (id_profil) ON DELETE CASCADE
    );

INSERT INTO
    `Categorie` (`id_categorie`, `nom`)
VALUES
    (1, 'Toutes'),
    (2, 'Électroniques'),
    (3, 'Voitures'),
    (4, 'Meubles'),
    (5, 'Électroménagers'),
    (6, 'Vêtements'),
    (7, 'Livres'),
    (8, 'Sports'),
    (9, 'Jouets'),
    (10, 'Logements'),
    (11, 'Services');

INSERT INTO
    `Etat` (`id_etat`, `nom`)
VALUES
    (1, 'Tous'),
    (2, 'Neuf'),
    (3, 'Usagé'),
    (4, 'Reconditionné');

INSERT INTO
    `Onglet` (`id_onglet`, `nom`)
VALUES
    (1, 'Publiques'),
    (2, 'Abonnements'),
    (3, 'Favoris'),
    (4, 'Vos publications');