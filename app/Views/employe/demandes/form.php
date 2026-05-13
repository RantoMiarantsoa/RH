<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle demande</title>
    <link rel="stylesheet" href="<?= base_url('style/employe.css') ?>">
</head>
<body>
<div class="container">

    <h1>Nouvelle demande de congé</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <p><?= $e ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Soldes disponibles -->
    <div class="soldes-grid" style="margin-bottom: 24px;">
        <?php foreach ($soldes as $solde): ?>
            <div class="solde-card">
                <span class="solde-type"><?= esc($solde['libelle']) ?></span>
                <span class="solde-restant"><?= $solde['restant'] ?> j restants</span>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="<?= base_url('employe/demandes/creer') ?>" method="post" class="form-card">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Type de congé</label>
            <select name="type_conge_id" required>
                <option value="">— Choisir —</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id'] ?>"
                        <?= old('type_conge_id') == $type['id'] ? 'selected' : '' ?>>
                        <?= esc($type['libelle']) ?>
                        <?= $type['deductible'] ? '(déductible)' : '(non déductible)' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Date de début</label>
            <input type="date" name="date_debut"
                   value="<?= old('date_debut') ?>" required>
        </div>

        <div class="form-group">
            <label>Date de fin</label>
            <input type="date" name="date_fin"
                   value="<?= old('date_fin') ?>" required>
        </div>

        <div class="form-group">
            <label>Motif <span style="color:#999">(optionnel)</span></label>
            <textarea name="motif" rows="3"><?= old('motif') ?></textarea>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('employe/demandes') ?>" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>

    </form>
</div>
</body>
</html>