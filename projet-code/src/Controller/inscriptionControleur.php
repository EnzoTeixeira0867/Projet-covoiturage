<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/authRepo.php';

function afficherFormulaireInscription(array $donnees = [], array $erreurs = [], bool $succes = false): void
{
    afficherVue('inscription/index', [
        'titre' => 'Créer un compte — Covoiturage',
        'pageCourante' => 'inscription',
        'champs' => $donnees,
        'donnees' => $donnees,
        'nom' => $donnees['nom'] ?? '',
        'prenom' => $donnees['prenom'] ?? '',
        'email' => $donnees['email'] ?? '',
        'tel' => $donnees['tel'] ?? '',
        'erreurs' => $erreurs,
        'succes' => $succes,
    ]);
}

function gererInscription(PDO $connexion): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        traiterInscription($connexion);
    } else {
        afficherFormulaireInscription();
    }
}

function traiterInscription(PDO $connexion): void
{
    $nomSaisi = (string) ($_POST['nom'] ?? '');
    $prenomSaisi = (string) ($_POST['prenom'] ?? '');
    $emailSaisi = (string) ($_POST['email'] ?? '');
    $telSaisi = (string) ($_POST['tel'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $codeSaisi = (string) ($_POST['code'] ?? '');

    $nom = ucfirst(trim($nomSaisi));
    $prenom = ucfirst(trim($prenomSaisi));
    $email = trim($emailSaisi);
    $tel = trim($telSaisi);
    $code = trim($codeSaisi);

    $erreurs = [];

    // 4 champs pour correction (hors mot de passe et code)
    $donnees = [
        'nom' => $nomSaisi,
        'prenom' => $prenomSaisi,
        'email' => $emailSaisi,
        'tel' => $telSaisi,
    ];

    // Disponibilité du code d'inscription dans les paramètres
    $codeAttendu = recupererCodeInscription($connexion);
    if ($codeAttendu === null) {
        $erreurs[] = 'Le service d’inscription est indisponible. Réessayez plus tard.';
        afficherFormulaireInscription($donnees, $erreurs);
        return;
    }

    // Validation du nom
    if ($nom === '') {
        $erreurs['nom'] = 'Le nom est obligatoire.';
    }

    // Validation du prénom
    if ($prenom === '') {
        $erreurs['prenom'] = 'Le prénom est obligatoire.';
    }

    // Validation du mail
    if ($email === '') {
        $erreurs['email'] = 'L’adresse électronique est obligatoire.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = 'Veuillez saisir une adresse électronique valide.';
    } elseif (emailExiste($connexion, $email)) {
        $erreurs['email'] = 'Cette adresse électronique est déjà utilisée.';
    }

    // Validation du numéro de téléphone
    $telChiffres = preg_replace("/[^0-9]/", '', $tel);
    if (str_starts_with($telChiffres, '33') && strlen($telChiffres) === 11) {
        $telChiffres = '0' . substr($telChiffres, 2);
    }

    if ($tel === '' || trim($tel) === '' || strlen($telChiffres) === 0) {
        $erreurs['tel'] = 'Le numéro de téléphone est obligatoire.';
    } elseif (strlen($telChiffres) !== 10) {
        $erreurs['tel'] = 'Le numéro de téléphone n’est pas valide. Format attendu : 10 chiffres (ex. 06 00 00 00 01).';
    }

    // Validation du mot de passe
    if ($password === '') {
        $erreurs['password'] = 'Le mot de passe est obligatoire.';
    }

    // Validation du code d'inscription
    if ($code === '') {
        $erreurs['code'] = 'Le code d’inscription est obligatoire.';
    } elseif ($code !== $codeAttendu) {
        $erreurs['code'] = 'Le code d’inscription est incorrect.';
    }

    // Réaffichage du formulaire pour correction
    if ($erreurs !== []) {
        afficherFormulaireInscription($donnees, $erreurs);
        return;
    }

    // Enregistrement du compte
    try {
        $reussite = creerUtilisateur(
            $connexion,
            $nom,
            $prenom,
            $email,
            $telChiffres,
            $password
        );

        if (!$reussite) {
            $erreurs[] = 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.';
            afficherFormulaireInscription($donnees, $erreurs);
            return;
        }

        // Confirmation et proposition de connexion
        afficherFormulaireInscription([], [], true);
    } catch (PDOException $exception) {
        // En cas de conflit d'unicité (ex. deux inscriptions simultanées avec le même email)
        if (str_contains($exception->getMessage(), 'UNIQUE constraint failed') || $exception->getCode() === '23000') {
            $erreurs['email'] = 'Cette adresse électronique est déjà utilisée.';
        } else {
            $erreurs[] = 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.';
        }

        afficherFormulaireInscription($donnees, $erreurs);
    }
}
