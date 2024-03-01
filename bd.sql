CREATE TABLE Profil (
    id_profil INTEGER PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    info_paiement VARCHAR(255) NULL,
    date_naissance DATE NOT NULL,
    photo_profil VARCHAR(255) NULL,
    statut INTEGER NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    montant_balance DECIMAL(10,2) NOT NULL
);

CREATE TABLE Categorie (
    id_categorie INTEGER PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE Panier (
    id_panier INTEGER PRIMARY KEY,
    montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_panier) REFERENCES Profil (id_profil) ON DELETE CASCADE
);

CREATE TABLE Publication (
    id_publication INTEGER PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NULL,
    image VARCHAR(255) NOT NULL,
    video VARCHAR(255) NULL,
    id_profil INTEGER REFERENCES Profil (id_profil) ON DELETE CASCADE,
    id_categorie INTEGER REFERENCES Categorie (id_categorie) ON DELETE CASCADE
);

CREATE TABLE Paiement (
    id_paiement INTEGER PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    info_methode_paiement VARCHAR(255) NOT NULL,
    date_paiement DATE NOT NULL,
    id_profil INTEGER NOT NULL,
    id_publication INTEGER NOT NULL,
    FOREIGN KEY (id_profil) REFERENCES Profil (id_profil) ON DELETE CASCADE,
    FOREIGN KEY (id_publication) REFERENCES Publication (id_publication) ON DELETE CASCADE
);

CREATE TABLE Panier_Publication (
    id_panier INTEGER,
    id_publication INTEGER,
    PRIMARY KEY (id_panier, id_publication),
    FOREIGN KEY (id_panier) REFERENCES Panier(id_panier) ON DELETE CASCADE,
    FOREIGN KEY (id_publication) REFERENCES Publication(id_publication) ON DELETE CASCADE
);