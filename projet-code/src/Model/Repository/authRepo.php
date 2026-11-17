<?php

function recupererCodeInscription(PDO $connexion): ?string
{
    try {
        $requete = $connexion->query('SELECT code FROM parametres LIMIT 1');
        $code = $requete->fetchColumn();

        if ($code === false || trim((string) $code) === '') {
            return null;
        }

        return trim((string) $code);
    } catch (PDOException) {
        return null;
    }
}

function emailExiste(PDO $connexion, string $email): bool
{
    $requete = $connexion->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $requete->execute(['email' => $email]);

    return ((int) $requete->fetchColumn()) > 0;
}

function creerUtilisateur(
    PDO $connexion,
    string $nom,
    string $prenom,
    string $email,
    string $tel,
    string $motDePasse
): bool {
    $requete = $connexion->prepare(
        'INSERT INTO users (nom, prenom, email, tel, password) 
         VALUES (:nom, :prenom, :email, :tel, :password)'
    );

    return $requete->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'tel' => $tel,
        'password' => password_hash($motDePasse, PASSWORD_DEFAULT),
    ]);
}


function authentifierUtilisateur(PDO $connexion, string $email, string $motDePasse): ?array
{
    $requete = $connexion->prepare(
        'SELECT id, nom, prenom, email, tel, password FROM users WHERE email = :email LIMIT 1'
    );
    $requete->execute(['email' => $email]);
    $utilisateur = $requete->fetch();

    if ($utilisateur === false) {
        return null;
    }

    if (!password_verify($motDePasse, $utilisateur['password'])) {
        return null;
    }

        // Ne pas exposer le hash du mot de passe au reste de l'application
    unset($utilisateur['password']);

    return $utilisateur;
}