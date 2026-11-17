<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/connexionControleur.php';

/**
 * Affiche l'espace connecté réservé aux enseignants.
 *
 * CA02 (US-02) : Après connexion, l'identité du compte est affichée.
 * CA05 : La session reconnaît l'enseignant entre les pages.
 * CA06, CA07 : L'accès est protégé — les non-connectés sont redirigés.
 */
function afficherAccueil(PDO $connexion): void
{
    exigerConnexion();

    $utilisateur = utilisateurConnecte();

    afficherVue('accueil/index', [
        'titre' => 'Espace enseignant — Covoiturage',
        'pageCourante' => 'accueil',
        'utilisateur' => $utilisateur,
        'prenom' => $utilisateur['prenom'],
        'nom' => $utilisateur['nom'],
        'emailUtilisateur' => $utilisateur['email'],
        'telUtilisateur' => $utilisateur['tel'],
    ]);
}

