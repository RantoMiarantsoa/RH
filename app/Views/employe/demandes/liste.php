<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes demandes</title>
    <link rel="stylesheet" href="<?= base_url('style/employe.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Mes demandes</h1>
        <a href="<?= base_url('employe/demandes/creer') ?>" class="btn btn-primary">
            + Nouvelle demande
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Jours</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Commentaire RH</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($demandes)): ?>
                <?php foreach ($demandes as $d): ?>
                    <tr>
                        <td><?= esc($d['type_libelle']) ?></td>
                        <td><?= $d['date_debut'] ?></td>
                        <td><?= $d['date_fin'] ?></td>
                        <td><?= $d['nb_jours'] ?> j</td>
                        <td><?= esc($d['motif'] ?? '—') ?></td>
                        <td><span class="badge badge-<?= $d['statut'] ?>"><?= $d['statut'] ?></span></td>
                        <td><?= esc($d['commentaire_rh'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="empty">Aucune demande</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="<?= base_url('employe/dashboard') ?>" class="btn btn-secondary">← Retour</a>
</div>
</body>
</html>