<?php
$succes = $succes ?? false;
$erreurs = $erreurs ?? [];
$saisie = $champs ?? ($donnees['donnees'] ?? ($donnees ?? []));
$valNom = $nom ?? ($saisie['nom'] ?? '');
$valPrenom = $prenom ?? ($saisie['prenom'] ?? '');
$valEmail = $email ?? ($saisie['email'] ?? '');
$valTel = $tel ?? ($saisie['tel'] ?? '');

$erreursGenerales = array_filter(
    $erreurs,
    fn($k) => !in_array($k, ['nom', 'prenom', 'email', 'tel', 'password', 'code'], true),
    ARRAY_FILTER_USE_KEY
);
?>
<section aria-labelledby="titre-inscription">
    <h1 id="titre-inscription">Créer un compte</h1>

    <?php if ($succes): ?>
        <div class="alert alert-success">
            <p>Votre compte a été créé avec succès !</p>
        </div>
        <p>Vous pouvez dès à présent vous connecter avec votre adresse électronique et votre mot de passe personnel.</p>
        <div class="form-actions">
            <a href="index.php?action=connexion" class="btn btn-primary">Se connecter</a>
        </div>
    <?php else: ?>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger" role="alert">
                <p><strong>Veuillez corriger les erreurs indiquées ci-dessous :</strong></p>
                <?php if (!empty($erreursGenerales)): ?>
                    <ul>
                        <?php foreach ($erreursGenerales as $erreurGen): ?>
                            <li><?= htmlspecialchars($erreurGen, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=inscription" method="post" novalidate>
            <div class="form-group<?= isset($erreurs['nom']) ? ' has-error' : '' ?>">
                <label for="nom">Nom <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input 
                    type="text" 
                    id="nom" 
                    name="nom" 
                    value="<?= htmlspecialchars((string) $valNom, ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    autocomplete="family-name"
                    <?= isset($erreurs['nom']) ? 'class="is-invalid" aria-invalid="true" aria-describedby="erreur-nom"' : '' ?>
                >
                <?php if (isset($erreurs['nom'])): ?>
                    <span id="erreur-nom" class="error-message" role="alert"><?= htmlspecialchars($erreurs['nom'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group<?= isset($erreurs['prenom']) ? ' has-error' : '' ?>">
                <label for="prenom">Prénom <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input 
                    type="text" 
                    id="prenom" 
                    name="prenom" 
                    value="<?= htmlspecialchars((string) $valPrenom, ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    autocomplete="given-name"
                    <?= isset($erreurs['prenom']) ? 'class="is-invalid" aria-invalid="true" aria-describedby="erreur-prenom"' : '' ?>
                >
                <?php if (isset($erreurs['prenom'])): ?>
                    <span id="erreur-prenom" class="error-message" role="alert"><?= htmlspecialchars($erreurs['prenom'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

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

            <div class="form-group<?= isset($erreurs['tel']) ? ' has-error' : '' ?>">
                <label for="tel">Numéro de téléphone <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input 
                    type="tel" 
                    id="tel" 
                    name="tel" 
                    value="<?= htmlspecialchars((string) $valTel, ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    autocomplete="tel"
                    aria-describedby="aide-tel<?= isset($erreurs['tel']) ? ' erreur-tel' : '' ?>"
                    <?= isset($erreurs['tel']) ? 'class="is-invalid" aria-invalid="true"' : '' ?>
                >
                <small id="aide-tel" class="help-text">Format attendu : 10 chiffres (ex. 06 00 00 00 01 ou 0612345678)</small>
                <?php if (isset($erreurs['tel'])): ?>
                    <span id="erreur-tel" class="error-message" role="alert"><?= htmlspecialchars($erreurs['tel'], ENT_QUOTES, 'UTF-8') ?></span>
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
                    autocomplete="new-password"
                    <?= isset($erreurs['password']) ? 'class="is-invalid" aria-invalid="true" aria-describedby="erreur-password"' : '' ?>
                >
                <?php if (isset($erreurs['password'])): ?>
                    <span id="erreur-password" class="error-message" role="alert"><?= htmlspecialchars($erreurs['password'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group<?= isset($erreurs['code']) ? ' has-error' : '' ?>">
                <label for="code">Code d’inscription <span class="champ-obligatoire" aria-hidden="true">*</span> <span class="sr-only">(obligatoire)</span></label>
                <input 
                    type="password" 
                    id="code" 
                    name="code" 
                    value="" 
                    required 
                    autocomplete="off"
                    aria-describedby="aide-code<?= isset($erreurs['code']) ? ' erreur-code' : '' ?>"
                    <?= isset($erreurs['code']) ? 'class="is-invalid" aria-invalid="true"' : '' ?>
                >
                <small id="aide-code" class="help-text">Code commun communiqué par le lycée</small>
                <?php if (isset($erreurs['code'])): ?>
                    <span id="erreur-code" class="error-message" role="alert"><?= htmlspecialchars($erreurs['code'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Créer mon compte</button>
            </div>
        </form>

    <?php endif; ?>
</section>
