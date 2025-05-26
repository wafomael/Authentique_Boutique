-- Création de la base de données stock_ab
CREATE DATABASE stock_ab;

-- Sélectionner la base de données
USE stock_ab;

-- Table 'collection' : pour répertorier les collections
CREATE TABLE collection (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Identifiant unique de la collection
    nom VARCHAR(255) NOT NULL,                   -- Nom de la collection
    description TEXT,                            -- Description de la collection
    aLaUne BOOLEAN DEFAULT FALSE                -- Indicateur pour savoir si la collection est mise en avant
);

-- Table 'article' : pour répertorier les articles
CREATE TABLE article (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Identifiant unique de l'article
    nom VARCHAR(255) NOT NULL,                   -- Nom de l'article
    description TEXT,                            -- Description de l'article
    prix DECIMAL(10, 2) NOT NULL,                -- Prix de l'article
    aLaUne BOOLEAN DEFAULT FALSE,               -- Indicateur pour savoir si l'article est mis en avant
    id_collection INT,                          -- Lien avec la table 'collection'
    FOREIGN KEY (id_collection) REFERENCES collection(id)  -- Clé étrangère vers la table 'collection'
);

-- Insertion d'une collection 'à la une'
INSERT INTO collection (nom, description, aLaUne) VALUES
('Collection Robes Africaines Printemps 2025', 'Collection mettant en avant l\'élégance des robes africaines modernes.', TRUE);

-- Insertion de 6 robes africaines 'à la une' et liées à la collection
INSERT INTO article (nom, description, prix, aLaUne, id_collection) VALUES
('Robe Africaine Traditionnelle 1', 'Robe inspirée des tissus et motifs traditionnels africains.', 150.00, TRUE, 1),
('Robe Africaine Moderne 1', 'Robe contemporaine avec des motifs africains colorés et une coupe élégante.', 180.00, TRUE, 1),
('Robe Africaine Chic', 'Robe de cérémonie en tissus africains fins, idéale pour les événements formels.', 250.00, TRUE, 1),
('Robe Africaine de Mariée', 'Robe de mariée avec des touches de broderies africaines et des tissus traditionnels.', 500.00, TRUE, 1),
('Robe Africaine Élégante', 'Robe de soirée en tissu wax avec des détails uniques et raffinés.', 200.00, TRUE, 1),
('Robe Africaine Cocktail', 'Robe cocktail en tissu africain avec une coupe moderne et élégante.', 120.00, TRUE, 1);




-- Collection de Robes de Mariée Africaines
INSERT INTO collection (nom, description, aLaUne) VALUES
('Collection Robes de Mariée Africaines 2025', 'Une collection raffinée mettant en valeur les robes de mariée aux influences africaines.', TRUE);

INSERT INTO article (nom, description, prix, aLaUne, id_collection) VALUES
('Robe de Mariée Royale', 'Une robe majestueuse avec des broderies africaines délicates et un tissu luxueux.', 800.00, TRUE, 2),
('Robe de Mariée Bohème', 'Robe fluide en dentelle et wax, parfaite pour une mariée moderne.', 600.00, TRUE, 2),
('Robe de Mariée Perles d’Afrique', 'Robe ornée de perles traditionnelles et d’un corsage raffiné.', 900.00, TRUE, 2),
('Robe de Mariée Satin Wax', 'Mélange de satin blanc et de motifs wax pour une touche unique.', 750.00, TRUE, 2),
('Robe de Mariée Prestige', 'Robe avec traîne en dentelle et détails dorés inspirés des cultures africaines.', 1200.00, TRUE, 2),
('Robe de Mariée Traditionnelle', 'Robe de cérémonie traditionnelle avec des tissus ancestraux africains.', 680.00, TRUE, 2);

-- Collection de Costumes pour Hommes
INSERT INTO collection (nom, description, aLaUne) VALUES
('Collection Costumes Africains pour Hommes 2025', 'Une collection élégante et moderne de costumes inspirés de la mode africaine.', TRUE);

INSERT INTO article (nom, description, prix, aLaUne, id_collection) VALUES
('Costume Africain Élégant', 'Costume trois pièces en tissu africain avec motifs discrets.', 400.00, TRUE, 3),
('Costume Wax Homme', 'Ensemble costume et pantalon en tissu wax pour un look moderne.', 350.00, TRUE, 3),
('Costume Traditionnel Homme', 'Costume inspiré des grandes tenues africaines pour des occasions spéciales.', 500.00, TRUE, 3),
('Costume Classique avec Touche Africaine', 'Costume noir avec une doublure et un col en tissu africain.', 450.00, TRUE, 3),
('Costume Homme Cérémonie', 'Costume sur-mesure avec broderies fines et coupes africaines authentiques.', 600.00, TRUE, 3),
('Costume Décontracté Homme', 'Costume léger parfait pour les événements semi-formels.', 320.00, TRUE, 3);

-- Collection de Robes pour Adolescentes
INSERT INTO collection (nom, description, aLaUne) VALUES
('Collection Robes Africaines pour Adolescentes 2025', 'Une collection fun et élégante de robes africaines pour jeunes filles.', TRUE);

INSERT INTO article (nom, description, prix, aLaUne, id_collection) VALUES
('Robe Teen Wax', 'Robe colorée en tissu wax, parfaite pour toutes occasions.', 90.00, TRUE, 4),
('Robe Jeune Fille Chic', 'Robe fluide avec détails africains pour un style tendance.', 110.00, TRUE, 4),
('Robe Bohème Ados', 'Robe légère avec motifs ethniques et coupe ample.', 95.00, TRUE, 4),
('Robe de Cérémonie Ado', 'Robe élégante pour fêtes et événements spéciaux.', 130.00, TRUE, 4),
('Robe d’Été Africaine', 'Robe courte et confortable en tissu traditionnel.', 85.00, TRUE, 4),
('Robe Festive Teen', 'Robe avec dentelle et touches de wax pour un look unique.', 120.00, TRUE, 4);

