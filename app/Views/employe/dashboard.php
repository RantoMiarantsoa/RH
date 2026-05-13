<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon espace</title>
    <link rel="stylesheet" href="<?= base_url('style/employe.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Bonjour, <?= esc(session()->get('prenom')) ?> 👋</h1>
        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Déconnexion</a>
    </div>

    <div class="nav-links">
        <a href="<?= base_url('employe/demandes') ?>"       class="btn btn-secondary">Mes demandes</a>
        <a href="<?= base_url('employe/demandes/creer') ?>" class="btn btn-primary">+ Nouvelle demande</a>
        <a href="<?= base_url('employe/soldes') ?>"         class="btn btn-secondary">Mes soldes</a>
    </div>

    <!-- Soldes -->
    <h2>Mes soldes <?= date('Y') ?></h2>
    <div class="soldes-grid">
        <?php if (!empty($soldes)): ?>
            <?php foreach ($soldes as $solde): ?>
                <div class="solde-card">
                    <span class="solde-type"><?= esc($solde['libelle']) ?></span>
                    <span class="solde-restant"><?= $solde['restant'] ?> j</span>
                    <span class="solde-detail">
                        <?= $solde['jour_attribues'] ?> attribués —
                        <?= $solde['jour_pris'] ?> pris
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">Aucun solde disponible</p>
        <?php endif; ?>
    </div>

    <!-- Dernières demandes -->
    <h2>Mes dernières demandes</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Jours</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($demandes_recentes)): ?>
                <?php foreach (array_slice($demandes_recentes, 0, 5) as $d): ?>
                    <tr>
                        <td><?= esc($d['type_libelle']) ?></td>
                        <td><?= $d['date_debut'] ?></td>
                        <td><?= $d['date_fin'] ?></td>
                        <td><?= $d['nb_jours'] ?> j</td>
                        <td><span class="badge badge-<?= $d['statut'] ?>"><?= $d['statut'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="empty">Aucune demande</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>