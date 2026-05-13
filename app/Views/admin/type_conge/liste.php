<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types de congé</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Types de congé</h1>
        <a href="<?= base_url('admin/type-conge/creer') ?>" class="btn btn-primary">
            + Nouveau type
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
                <th>Libellé</th>
                <th>Jours annuels</th>
                <th>Déductible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($types)): ?>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?= $type['id'] ?></td>
                        <td><?= esc($type['libelle']) ?></td>
                        <td><?= $type['jour_annuels'] ?> j</td>
                        <td>
                            <?php if ($type['deductible']): ?>
                                <span class="badge badge-danger">Oui</span>
                            <?php else: ?>
                                <span class="badge badge-success">Non</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="<?= base_url('admin/type-conge/editer/' . $type['id']) ?>"
                               class="btn btn-warning">Éditer</a>
                            <a href="<?= base_url('admin/type-conge/supprimer/' . $type['id']) ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Supprimer ce type de congé ?')">
                               Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="empty">Aucun type de congé</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>