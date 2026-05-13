<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de congé</title>
    <link rel="stylesheet" href="<?= base_url('css/demandes.css') ?>">
</head>
<body>

    <div class="container">

        <h1>Demandes en attente</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <table class="table" id="tableConges">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employé</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Jours</th>
                    <th>Motif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($conges)): ?>
                    <?php foreach ($conges as $conge): ?>
                        <tr>
                            <td><?= $conge['id'] ?></td>
                            <td><?= esc($conge['nom']) ?> <?= esc($conge['prenom']) ?></td>
                            <td><?= esc($conge['type_libelle']) ?></td>
                            <td><?= $conge['date_debut'] ?></td>
                            <td><?= $conge['date_fin'] ?></td>
                            <td><?= $conge['nb_jours'] ?></td>
                            <td><?= esc($conge['motif'] ?? '—') ?></td>
                            <td class="actions">
                                <a href="<?= base_url('rh/approuver/' . $conge['id']) ?>"
                                   class="btn btn-success"
                                   onclick="return confirm('Approuver ce congé ?')">
                                    Approuver
                                </a>
                                <a href="<?= base_url('rh/refuser/' . $conge['id']) ?>"
                                   class="btn btn-danger"
                                   onclick="return confirm('Refuser ce congé ?')">
                                    Refuser
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="empty">Aucune demande en attente</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <script src="<?= base_url('js/demandes.js') ?>"></script>
</body>
</html>