/**
 * Gestionnaire du thème Clair / Sombre (Dark / Light mode toggle)
 * Entièrement côté client — aucun impact sur le backend.
 */
(function () {
    const STORAGE_KEY = 'covoit_theme';

    function getPreferredTheme() {
        const storedTheme = localStorage.getItem(STORAGE_KEY);
        if (storedTheme === 'dark' || storedTheme === 'light') {
            return storedTheme;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const button = document.getElementById('theme-toggle');
        if (button) {
            const isDark = theme === 'dark';
            button.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            button.setAttribute('aria-label', isDark ? 'Activer le mode clair' : 'Activer le mode sombre');
            button.setAttribute('title', isDark ? 'Passer en mode clair' : 'Passer en mode sombre');
        }
    }

    // Initialisation
    const currentTheme = getPreferredTheme();
    applyTheme(currentTheme);

    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('theme-toggle');
        if (!toggleBtn) return;

        applyTheme(document.documentElement.getAttribute('data-theme') || currentTheme);

        toggleBtn.addEventListener('click', function () {
            const activeTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = activeTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem(STORAGE_KEY, newTheme);
            applyTheme(newTheme);
        });
    });

    // Écoute des préférences système si l'utilisateur n'a pas forcé de choix
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (!localStorage.getItem(STORAGE_KEY)) {
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });
})();

