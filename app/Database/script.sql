
PRAGMA foreign_key = ON;


CREATE TABLE departements(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT 
);
CREATE TABLE type_conge(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jour_annuels REAL NOT NULL,
    deductible INTEGER NOT NULL
);
CREATE TABLE employes(
    id INTEGER PRIMARY KEY  AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL,
    departement_id INTEGER,
    date_embauche DATE NOT NULL,
    actif INTEGER NOT NULL,
    FOREIGN KEY (departement_id) REFERENCES departements(id)
);

CREATE TABLE soldes(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER,
    type_conge_id INTEGER,
    annee INTEGER NOT NULL,
    jour_attribues REAL NOT NULL DEFAULT 0,
    jour_pris REAL NOT NULL DEFAULT 0,

    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES type_conge(id),

    UNIQUE(employe_id,type_conge_id,annee)
);

CREATE TABLE conges (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours REAL NOT NULL,
    motif TEXT,
    statut TEXT NOT NULL,
    commentaire_rh TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER,

    FOREIGN KEY (employe_id)
        REFERENCES employes(id),

    FOREIGN KEY (type_conge_id)
        REFERENCES types_conge(id),

    FOREIGN KEY (traite_par)
        REFERENCES employes(id)
);

INSERT INTO employes(
    nom,
    prenom,
    email,
    password,
    role,
    departement_id,
    date_embauche,
    actif
)
VALUES (
    'Rakoto',
    'Jean',
    'jean@gmail.com',
    '$2y$10$abcdefghijklmnopqrstuv',
    'employe',
    1,
    '2026-01-10',
    1
);