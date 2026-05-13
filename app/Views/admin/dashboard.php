<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <h1>Tableau de bord</h1>
    <p class="subtitle">
        <?= strftime('%B %Y', mktime(0, 0, 0, (int)$mois, 1, (int)$annee)) ?>
    </p>

    <!-- Cartes stats -->
    <div class="cards">

        <div class="card">
            <span class="card-label">Employés actifs</span>
            <span class="card-value"><?= $total_employes ?></span>
        </div>

        <div class="card card-warning">
            <span class="card-label">En attente</span>
            <span class="card-value"><?= $en_attente ?></span>
        </div>

        <div class="card card-success">
            <span class="card-label">Approuvés ce mois</span>
            <span class="card-value"><?= $approuves_mois ?></span>
        </div>

        <div class="card card-danger">
            <span class="card-label">Refusés ce mois</span>
            <span class="card-value"><?= $refuses_mois ?></span>
        </div>

    </div>

    <!-- Absences du mois -->
    <h2>Absences du mois en cours</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Jours</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($absences)): ?>
                <?php foreach ($absences as $absence): ?>
                    <tr>
                        <td><?= esc($absence['nom']) ?> <?= esc($absence['prenom']) ?></td>
                        <td><?= esc($absence['type_libelle']) ?></td>
                        <td><?= $absence['date_debut'] ?></td>
                        <td><?= $absence['date_fin'] ?></td>
                        <td><?= $absence['nb_jours'] ?> j</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">Aucune absence ce mois</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<script src="<?= base_url('js/admin.js') ?>"></script>
</body>
</html>