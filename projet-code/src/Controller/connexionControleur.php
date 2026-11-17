<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/authRepo.php';

/**
 * Point d'entrée du formulaire de connexion (GET et POST).
 */
function gererConnexion(PDO $connexion): void
{
    // Si l'enseignant est déjà connecté, le rediriger vers l'accueil connecté
    if (estConnecte()) {
        header('Location: index.php?action=accueil');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        traiterConnexion($connexion);
    } else {
        afficherFormulaireConnexion();
    }
}

/**
 * Affiche le formulaire de connexion avec éventuellement des erreurs.
 */
function afficherFormulaireConnexion(array $erreurs = [], string $emailSaisi = ''): void
{
    afficherVue('connexion/index', [
        'titre' => 'Se connecter — Covoiturage',
        'pageCourante' => 'connexion',
        'erreurs' => $erreurs,
        'email' => $emailSaisi,
    ]);
}

/**
 * Traite la soumission du formulaire de connexion.
 *
 * CA02 : Connexion réussie → ouverture de session et redirection vers l'accueil.
 * CA03 : Adresse inconnue ou mauvais mot de passe → même message générique.
 * CA04 : Champ vide → message par champ.
 */
function traiterConnexion(PDO $connexion): void
{
    $emailSaisi = (string) ($_POST['email'] ?? '');
    $password   = (string) ($_POST['password'] ?? '');

    $email = trim($emailSaisi);

    $erreurs = [];

    // CA04 : Vérification des champs obligatoires
    if ($email === '') {
        $erreurs['email'] = 'L\'adresse électronique est obligatoire.';
    }
    if ($password === '') {
        $erreurs['password'] = 'Le mot de passe est obligatoire.';
    }

    if ($erreurs !== []) {
        afficherFormulaireConnexion($erreurs, $emailSaisi);
        return;
    }

    // CA02, CA03 : Tentative d'authentification
    $utilisateur = authentifierUtilisateur($connexion, $email, $password);

    if ($utilisateur === null) {
        // CA03 : Message identique pour adresse inconnue et mauvais mot de passe
        $erreurs['auth'] = 'Adresse électronique ou mot de passe incorrect.';
        afficherFormulaireConnexion($erreurs, $emailSaisi);
        return;
    }

    // CA02, CA05 : Ouverture de session — l'enseignant est reconnu entre les pages
    // CA08 : Régénérer l'identifiant de session pour éviter la fixation de session
    session_regenerate_id(true);

    $_SESSION['utilisateur'] = [
        'id'     => $utilisateur['id'],
        'nom'    => $utilisateur['nom'],
        'prenom' => $utilisateur['prenom'],
        'email'  => $utilisateur['email'],
        'tel'    => $utilisateur['tel'],
    ];

    // Redirection vers l'accueil connecté
    header('Location: index.php?action=accueil');
    exit;
}

/**
 * Vérifie si une session utilisateur valide est active.
 */
function estConnecte(): bool
{
    return isset($_SESSION['utilisateur']['id']);
}

/**
 * Retourne les données de l'utilisateur connecté, ou null.
 */
function utilisateurConnecte(): ?array
{
    return $_SESSION['utilisateur'] ?? null;
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
 * CA06, CA07 : Protège les pages et actions réservées.
 * CA06 : Empêche la mise en cache des pages protégées (bouton Retour du navigateur).
 */
function exigerConnexion(): void
{
    if (!estConnecte()) {
        header('Location: index.php?action=connexion');
        exit;
    }

    // CA06 : Configurer les en-têtes pour éviter la conservation en cache des pages réservées
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Pragma: no-cache');
}

