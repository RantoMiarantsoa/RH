<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes soldes</title>
    <link rel="stylesheet" href="<?= base_url('style/employe.css') ?>">
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Mes soldes <?= $annee ?></h1>
        <a href="<?= base_url('employe/dashboard') ?>" class="btn btn-secondary">← Retour</a>
    </div>

    <div class="soldes-grid">
        <?php if (!empty($soldes)): ?>
            <?php foreach ($soldes as $solde): ?>
                <div class="solde-card">
                    <span class="solde-type"><?= esc($solde['libelle']) ?></span>
                    <span class="solde-restant"><?= $solde['restant'] ?> j</span>
                    <div class="solde-barre">
                        <?php
                            $pct = $solde['jour_attribues'] > 0
                                ? ($solde['jour_pris'] / $solde['jour_attribues']) * 100
                                : 0;
                        ?>
                        <div class="barre-fond">
                            <div class="barre-remplie" style="width: <?= min($pct, 100) ?>%"></div>
                        </div>
                        <span class="solde-detail">
                            <?= $solde['jour_pris'] ?> pris / <?= $solde['jour_attribues'] ?> attribués
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">Aucun solde pour cette année</p>
        <?php endif; ?>
    </div>

</div>
</body>
</html>