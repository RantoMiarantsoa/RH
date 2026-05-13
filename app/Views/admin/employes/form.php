<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $employe ? 'Éditer' : 'Créer' ?> un employé</title>
    <link rel="stylesheet" href="<?= base_url('style/admin.css') ?>">
</head>
<body>
<div class="container">

    <h1><?= $employe ? 'Éditer' : 'Nouvel' ?> employé</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= $employe
        ? base_url('admin/employes/editer/' . $employe['id'])
        : base_url('admin/employes/creer') ?>"
        method="post" class="form-card">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom"
                   value="<?= old('nom', $employe['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom"
                   value="<?= old('prenom', $employe['prenom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= old('email', $employe['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Mot de passe <?= $employe ? '(laisser vide = inchangé)' : '' ?></label>
            <input type="password" name="password"
                   <?= $employe ? '' : 'required' ?> minlength="8">
        </div>

        <div class="form-group">
            <label>Rôle</label>
            <select name="role" required>
                <?php foreach (['employe', 'rh', 'manager', 'admin'] as $role): ?>
                    <option value="<?= $role ?>"
                        <?= old('role', $employe['role'] ?? '') === $role ? 'selected' : '' ?>>
                        <?= ucfirst($role) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Département</label>
            <select name="departement_id">
                <option value="">— Aucun —</option>
                <?php foreach ($departements as $dept): ?>
                    <option value="<?= $dept['id'] ?>"
                        <?= old('departement_id', $employe['departement_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                        <?= esc($dept['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Date d'embauche</label>
            <input type="date" name="date_embauche"
                   value="<?= old('date_embauche', $employe['date_embauche'] ?? '') ?>" required>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('admin/employes') ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">
                <?= $employe ? 'Mettre à jour' : 'Créer' ?>
            </button>
        </div>

    </form>
</div>
</body>
</html>