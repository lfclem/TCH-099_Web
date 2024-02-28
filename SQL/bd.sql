CREATE TABLE Profil (
    id INTEGER PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    info_paiement VARCHAR(255) NULL,
    date_naissance DATE NOT NULL,
    photo_profil VARCHAR(255) NULL,
    statut INTEGER NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    montant_balance DECIMAL(10,2) NOT NULL,
    id_parent INTEGER NULL,
    FOREIGN KEY (id_parent) REFERENCES Profil(id)
);

CREATE TABLE Categorie (
    id INTEGER PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE Panier (
    id_profil INTEGER PRIMARY KEY,
    nombre_article DECIMAL(10,2) NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_profil) REFERENCES Profil (id) ON DELETE CASCADE
);

CREATE TABLE Publication (
    id INTEGER PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NULL,
    image VARCHAR(255) NOT NULL,
    video VARCHAR(255) NULL,
    id_Profil INTEGER REFERENCES Profil (id) ON DELETE CASCADE
);

CREATE TABLE Paiement (
    id_paiement INTEGER PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    info_methode_paiement VARCHAR(255) NOT NULL,
    date_paiement DATE NOT NULL,
    id_profil INTEGER NOT NULL,
    id_publication INTEGER NOT NULL,
    FOREIGN KEY (id_profil) REFERENCES Profil (id) ON DELETE CASCADE,
    FOREIGN KEY (id_publication) REFERENCES Publication (id) ON DELETE CASCADE
);

CREATE TABLE Categorie_Publication (
    id_categorie INTEGER NOT NULL,
    id_publication INTEGER NOT NULL,
    PRIMARY KEY (id_categorie, id_publication),
    FOREIGN KEY (id_categorie) REFERENCES Categorie (id),
    FOREIGN KEY (id_publication) REFERENCES Publication (id)
);