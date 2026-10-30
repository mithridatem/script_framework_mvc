<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= htmlspecialchars($title ?? 'Connexion', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
<main class="container">
    <h1>Connexion</h1>
    <form action="/login" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($this->getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" autocomplete="username" required>
        <?php $this->renderComponent('error_validation', ['errors' => $data['validation']['email'] ?? []]); ?>

        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password" autocomplete="current-password" required>
        <?php $this->renderComponent('error_validation', ['errors' => $data['validation']['password'] ?? []]); ?>

        <?php if (!empty($data['errors'])): ?>
            <p role="alert"><?= htmlspecialchars($data['errors'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <button type="submit">Se connecter</button>
    </form>
</main>
</body>
</html>
