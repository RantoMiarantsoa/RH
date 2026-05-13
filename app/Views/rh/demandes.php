<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de congé</title>
    <link rel="stylesheet" href="<?= base_url('style/demandes.css') ?>">
</head>

<body>

    <div class="app-wrap">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon">🏢</div>
                <div class="sidebar-brand-name">
                    RH System
                    <span>Gestion Congés</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <li><a href="<?= base_url('/') ?>">📊 Accueil</a></li>
                <li><a href="<?= base_url('rh/demandes') ?>" class="active">📋 Demandes</a></li>
                <li><a href="<?= base_url('rh/employes') ?>">👥 Employés</a></li>
                <li><a href="<?= base_url('rh/soldes') ?>">📈 Soldes</a></li>
            </nav>
        </aside>

        <!-- Main -->
        <div class="main">
            <header class="topbar">
                <h1 class="topbar-title">Demandes de Congé en Attente</h1>
                <div class="topbar-actions">
                    <a href="<?= base_url('rh/deconnexion') ?>" class="btn btn-secondary">Déconnexion</a>
                </div>
            </header>

            <div class="content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash flash-success">
                        ✓ <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash flash-error">
                        ✕ <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Demandes en attente</h3>
                    </div>
                    <table class="tbl" id="tableConges">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Jours</th>
                                <th>Motif</th>
                                <th>Commentaire RH</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($conges)): ?>
                                <?php foreach ($conges as $conge): ?>
                                    <tr>
                                        <td class="td-mono"><?= $conge['id'] ?></td>
                                        <td class="td-name"><?= esc($conge['nom']) ?> <?= esc($conge['prenom']) ?></td>
                                        <td>
                                            <span class="type-badge t-maladie"><?= esc($conge['type_libelle']) ?></span>
                                        </td>
                                        <td class="td-mono"><?= $conge['date_debut'] ?></td>
                                        <td class="td-mono"><?= $conge['date_fin'] ?></td>
                                        <td class="td-mono"><strong><?= $conge['nb_jours'] ?></strong></td>
                                        <td class="td-muted"><?= esc($conge['motif'] ?? '—') ?></td>
                                        <td class="td-muted"><?= esc($conge['commentaire_rh'] ?? '—') ?></td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="<?= base_url('rh/approuver/' . $conge['id']) ?>"
                                                    class="btn-sm btn-approve"
                                                    onclick="return confirm('Approuver ce congé ?')">
                                                    ✓ Approuver
                                                </a>
                                                <a href="<?= base_url('rh/refuser/' . $conge['id']) ?>"
                                                    class="btn-sm btn-refuse"
                                                    onclick="return confirm('Refuser ce congé ?')">
                                                    ✕ Refuser
                                                </a>
                                                <a href="<?= base_url('rh/annuler/' . $conge['id']) ?>"
                                                    class="btn-sm btn-cancel"
                                                    onclick="return confirm('Annuler ce congé ?')">
                                                    ✕ Annuler
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="empty">✓ Aucune demande en attente</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/demandes.js') ?>"></script>
</body>

</html>