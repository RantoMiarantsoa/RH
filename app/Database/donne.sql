-- =========================
-- DEPARTEMENTS
-- =========================
INSERT INTO departements (nom, description) VALUES
('Informatique', 'Département IT et développement'),
('Ressources Humaines', 'Gestion du personnel et recrutement'),
('Finance', 'Comptabilité et gestion financière'),
('Marketing', 'Communication et publicité');

-- =========================
-- TYPE CONGE
-- =========================
INSERT INTO type_conge (libelle, jour_annuels, deductible) VALUES
('Congé annuel', 30, 1),
('Congé maladie', 15, 0),
('Congé maternité', 90, 0),
('Congé exceptionnel', 10, 1);

-- =========================
-- EMPLOYES
-- =========================
INSERT INTO employes (nom, prenom, email, password, role, departement_id, date_embauche, actif) VALUES
('Rakoto', 'Jean', 'jean.rakoto@rh.com', '1234', 'admin', 1, '2023-01-10', 1),
('Rabe', 'Marie', 'marie.rabe@rh.com', '1234', 'rh', 2, '2022-05-20', 1),
('Andry', 'Paul', 'paul.andry@rh.com', '1234', 'employe', 1, '2024-02-15', 1),
('Rasolon', 'Claire', 'claire.raso@rh.com', '1234', 'employe', 3, '2023-07-01', 1);

-- =========================
-- SOLDES
-- =========================
INSERT INTO soldes (employe_id, type_conge_id, annee, jour_attribues, jour_pris) VALUES
(1, 1, 2026, 30, 5),
(2, 1, 2026, 30, 2),
(3, 1, 2026, 30, 10),
(4, 1, 2026, 30, 0),
(3, 2, 2026, 15, 3);

-- =========================
-- CONGES
-- =========================
INSERT INTO conges (employe_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, commentaire_rh, traite_par) VALUES
(3, 1, '2026-01-10', '2026-01-15', 5, 'Vacances', 'validé', 'OK RH', 2),
(4, 2, '2026-02-01', '2026-02-03', 3, 'Maladie', 'en attente', NULL, NULL),
(1, 1, '2026-03-10', '2026-03-12', 3, 'Repos', 'validé', 'Approuvé', 2);