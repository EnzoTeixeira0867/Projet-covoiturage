<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/connexionControleur.php';

/**
 * Ferme la session de l'enseignant connecté et redirige vers la page de connexion.
 *
 * CA02 : La session devient inutilisable et la page de connexion s'affiche.
 * CA08 : Déconnexion alors déjà déconnecté → reste déconnecté, accès à la connexion sans erreur bloquante.
 */
function gererDeconnexion(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Supprimer toutes les données de session côté serveur
        $_SESSION = [];

        // Supprimer le cookie de session côté client
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();
    }

    // Redirection vers la page de connexion
    header('Location: index.php?action=connexion');
    exit;
}
