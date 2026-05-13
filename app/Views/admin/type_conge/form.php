<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $type ? 'Éditer' : 'Créer' ?> un type de congé</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <h1><?= $type ? 'Éditer' : 'Nouveau' ?> type de congé</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= $type
        ? base_url('admin/type-conge/editer/' . $type['id'])
        : base_url('admin/type-conge/creer') ?>"
        method="post" class="form-card">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Libellé</label>
            <input type="text" name="libelle"
                   value="<?= old('libelle', $type['libelle'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Jours annuels</label>
            <input type="number" name="jour_annuels" step="0.5" min="0"
                   value="<?= old('jour_annuels', $type['jour_annuels'] ?? '0') ?>" required>
        </div>

        <div class="form-group">
            <label>Déductible du solde ?</label>
            <select name="deductible" required>
                <option value="1" <?= old('deductible', $type['deductible'] ?? '') == 1 ? 'selected' : '' ?>>
                    Oui
                </option>
                <option value="0" <?= old('deductible', $type['deductible'] ?? '') == 0 ? 'selected' : '' ?>>
                    Non
                </option>
            </select>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('admin/type-conge') ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">
                <?= $type ? 'Mettre à jour' : 'Créer' ?>
            </button>
        </div>

    </form>
</div>
</body>
</html>