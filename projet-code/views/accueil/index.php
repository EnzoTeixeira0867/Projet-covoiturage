<?php
$prenom = $prenom ?? '';
$nom = $nom ?? '';
$emailUtilisateur = $emailUtilisateur ?? '';
$telUtilisateur = $telUtilisateur ?? '';
?>
<section aria-labelledby="titre-accueil">
    <h1 id="titre-accueil">Bienvenue, <?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?> !</h1>

    <div class="alert alert-success">
        <p>Vous êtes connecté à votre espace enseignant.</p>
    </div>

    <div class="profil-card">
        <h2>Mon profil</h2>
        <dl class="profil-details">
            <div class="profil-row">
                <dt>Nom</dt>
                <dd><?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
            <div class="profil-row">
                <dt>Prénom</dt>
                <dd><?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
            <div class="profil-row">
                <dt>Adresse électronique</dt>
                <dd><?= htmlspecialchars($emailUtilisateur, ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
            <div class="profil-row">
                <dt>Téléphone</dt>
                <dd><?= htmlspecialchars($telUtilisateur, ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
        </dl>
    </div>

    <p>La liste des offres de covoiturage sera disponible prochainement.</p>
</section>

