<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Départements</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Départements</h1>
        <a href="<?= base_url('admin/departements/creer') ?>" class="btn btn-primary">
            + Nouveau département
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
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($departements)): ?>
                <?php foreach ($departements as $dept): ?>
                    <tr>
                        <td><?= $dept['id'] ?></td>
                        <td><?= esc($dept['nom']) ?></td>
                        <td><?= esc($dept['description'] ?? '—') ?></td>
                        <td class="actions">
                            <a href="<?= base_url('admin/departements/editer/' . $dept['id']) ?>"
                               class="btn btn-warning">Éditer</a>
                            <a href="<?= base_url('admin/departements/supprimer/' . $dept['id']) ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Supprimer ce département ?')">
                               Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="empty">Aucun département</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>