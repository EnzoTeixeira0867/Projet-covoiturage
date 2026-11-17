<?php
$erreurs = $erreurs ?? [];
$valEmail = $email ?? '';
?>
<section aria-labelledby="titre-connexion">
    <h1 id="titre-connexion">Se connecter</h1>

    <?php if (isset($erreurs['auth'])): ?>
        <div class="alert alert-danger" role="alert">
            <p><?= htmlspecialchars($erreurs['auth'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    <?php endif; ?>

    <form action="index.php?action=connexion" method="post" novalidate>
        <div class="form-group<?= isset($erreurs['email']) ? ' has-error' : '' ?>">
            <label for="email">Adresse électronique <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars((string) $valEmail, ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="email"
                <?= isset($erreurs['email']) ? 'class="is-invalid" aria-invalid="true" aria-describedby="erreur-email"' : '' ?>
            >
            <?php if (isset($erreurs['email'])): ?>
                <span id="erreur-email" class="error-message" role="alert"><?= htmlspecialchars($erreurs['email'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group<?= isset($erreurs['password']) ? ' has-error' : '' ?>">
            <label for="password">Mot de passe <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
            <input
                type="password"
                id="password"
                name="password"
                value=""
                required
                autocomplete="current-password"
                <?= isset($erreurs['password']) ? 'class="is-invalid" aria-invalid="true" aria-describedby="erreur-password"' : '' ?>
            >
            <?php if (isset($erreurs['password'])): ?>
                <span id="erreur-password" class="error-message" role="alert"><?= htmlspecialchars($erreurs['password'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>

    <p class="form-footer">Pas encore de compte ? <a href="index.php?action=inscription">Créer un compte</a></p>
</section>

