<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $departement ? 'Éditer' : 'Créer' ?> un département</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <h1><?= $departement ? 'Éditer' : 'Nouveau' ?> département</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= $departement
        ? base_url('admin/departements/editer/' . $departement['id'])
        : base_url('admin/departements/creer') ?>"
        method="post" class="form-card">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom"
                   value="<?= old('nom', $departement['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3"><?= old('description', $departement['description'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('admin/departements') ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">
                <?= $departement ? 'Mettre à jour' : 'Créer' ?>
            </button>
        </div>

    </form>
</div>
</body>
</html>