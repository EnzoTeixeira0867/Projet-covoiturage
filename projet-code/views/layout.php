<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?></title>
    <script>
        (function() {
            var theme = localStorage.getItem('covoit_theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="brand">
            <div>
                <p class="brand-title">Covoit' Pergaud</p>
                <p class="subtitle">Pour les enseignants de Pergaud</p>
            </div>
        </div>

        <nav class="nav-bar" aria-label="Navigation principale">
            <a href="index.php?action=bienvenue"<?= $pageCourante === 'bienvenue' ? ' class="active" aria-current="page"' : '' ?>>Bienvenue</a>
            <?php if (isset($_SESSION['utilisateur']['id'])): ?>
                <a href="index.php?action=accueil"<?= $pageCourante === 'accueil' ? ' class="active" aria-current="page"' : '' ?>>Espace enseignant</a>
                <a href="index.php?action=deconnexion" class="btn-deconnexion">Se déconnecter</a>
            <?php else: ?>
                <a href="index.php?action=inscription"<?= $pageCourante === 'inscription' ? ' class="active" aria-current="page"' : '' ?>>Créer un compte</a>
                <a href="index.php?action=connexion"<?= $pageCourante === 'connexion' ? ' class="active" aria-current="page"' : '' ?>>Se connecter</a>
            <?php endif; ?>

            <button type="button" id="theme-toggle" class="theme-toggle" aria-label="Changer de thème" title="Basculer entre mode sombre et clair">
                <span class="theme-icon-sun" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </span>
                <span class="theme-icon-moon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </span>
            </button>
        </nav>
    </header>

    <main>
        <?= $contenu ?>
    </main>

    <script src="js/theme.js"></script>
</body>

</html>
