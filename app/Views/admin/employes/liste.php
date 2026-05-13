<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des employés</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Employés</h1>
        <a href="<?= base_url('admin/employes/creer') ?>" class="btn btn-primary">
            + Nouvel employé
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
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Département</th>
                <th>Embauche</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($employes)): ?>
                <?php foreach ($employes as $employe): ?>
                    <tr class="<?= $employe['actif'] ? '' : 'inactive' ?>">
                        <td><?= $employe['id'] ?></td>
                        <td><?= esc($employe['nom']) ?> <?= esc($employe['prenom']) ?></td>
                        <td><?= esc($employe['email']) ?></td>
                        <td><span class="badge badge-<?= $employe['role'] ?>"><?= $employe['role'] ?></span></td>
                        <td><?= esc($employe['departement_nom'] ?? '—') ?></td>
                        <td><?= $employe['date_embauche'] ?></td>
                        <td>
                            <?php if ($employe['actif']): ?>
                                <span class="badge badge-success">Actif</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="<?= base_url('admin/employes/editer/' . $employe['id']) ?>"
                               class="btn btn-warning">Éditer</a>
                            <a href="<?= base_url('admin/employes/desactiver/' . $employe['id']) ?>"
                               class="btn <?= $employe['actif'] ? 'btn-danger' : 'btn-success' ?>"
                               onclick="return confirm('Confirmer ?')">
                                <?= $employe['actif'] ? 'Désactiver' : 'Réactiver' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="empty">Aucun employé</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<script src="<?= base_url('js/admin.js') ?>"></script>
</body>
</html>