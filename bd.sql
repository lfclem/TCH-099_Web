CREATE TABLE Profil (
    id_profil INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    info_paiement VARCHAR(255) NULL,
    date_naissance DATE NOT NULL,
    photo_profil BLOB NULL,
    bio VARCHAR(255) NULL,
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
    id_publication INTEGER PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NULL,
    image BLOB NOT NULL,
    video BLOB NULL,
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

/* commande a faire pour ajouter dans bd les articles et categories (avec profil pour test)*/
INSERT INTO `Profil` (`id_profil`, `username`,`email`, `password`, `date_naissance`, `statut`, `adresse`, `montant_balance`) VALUES
(1, 'admin', '123','test@gmail.com', '1990-02-02', 1, 'O-block', 10000000);

INSERT INTO `Categorie` (`id_categorie`, `nom`) VALUES
(1, 'Vêtements'),
(2, 'Chaussures'),
(3, 'Accessoires'),
(4, 'Électroniques'),
(5, 'Livres'),
(6, 'Meubles'),
(7, 'Jouets'),
(8, 'Véhicules');

INSERT INTO `Publication` (`id_publication`, `titre`, `prix`, `image`, `id_profil`, `id_categorie`) VALUES
(1, 'Elegant Chair', 99.99, '/IMG/peter.jpg', 1, 6),
(2, 'Cozy Sofa', 249.99, '/IMG/peter.jpg', 1, 6),
(3, 'Vintage Desk', 199.99, '/IMG/peter.jpg', 1, 6),
(4, 'Modern Lamp', 39.99, '/IMG/peter.jpg', 1, 6),
(5, 'Rustic Table', 149.99, '/IMG/peter.jpg', 1, 6),
(6, 'Luxury Ottoman', 99.99, '/IMG/peter.jpg', 1, 6),
(7, 'Stylish Bookshelf', 179.99, '/IMG/peter.jpg', 1, 3),
(8, 'Chic Coffee Table', 129.99, '/IMG/peter.jpg', 1, 6),
(9, 'Minimalist Chair', 79.99, '/IMG/peter.jpg', 1, 6),
(10, 'Contemporary Rug', 199.99, '/IMG/peter.jpg', 1, 6),
(11, 'Elegant Dining Table', 349.99, '/IMG/peter.jpg', 1, 6),
(12, 'Vintage Armchair', 219.99, '/IMG/peter.jpg', 1, 6),
(13, 'Modern Side Table', 69.99, '/IMG/peter.jpg', 1, 6),
(14, 'Rustic Bench', 99.99, '/IMG/peter.jpg', 1, 6),
(15, 'Luxury Chandelier', 499.99, '/IMG/peter.jpg', 1, 6),
(16, 'Stylish Ottoman', 179.99, '/IMG/peter.jpg', 1, 6);