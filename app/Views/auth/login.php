<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('style/auth.css') ?>">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">

        <h1>Connexion</h1>
        <p class="subtitle">Gestion des congés</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="<?= old('email') ?>"
                       placeholder="votre@email.com" required autofocus>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>

    </div>
</div>
</body>
</html>