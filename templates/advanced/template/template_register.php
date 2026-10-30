<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
        <link rel="stylesheet" href="asset/style/main.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>

    <main class="container-fluid">
        <h1>Créer un compte</h1>
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($this->getCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <fieldset>
                <input type="text" name="firstname" placeholder="saisir votre Prénom">
                <?php $this->renderComponent("error_validation", ["errors" => $data["validation"]["firstname"] ?? []]); ?>
                <input type="text" name="lastname" placeholder="saisir votre Nom">
                <?php $this->renderComponent("error_validation", ["errors" => $data["validation"]["lastname"] ?? []]); ?>
                <input type="email" name="email" placeholder="saisir votre Email">
                <?php $this->renderComponent("error_validation", ["errors" => $data["validation"]["email"] ?? []]); ?>
                <input type="password" name="password" placeholder="saisir votre mot de passe">
                <?php $this->renderComponent("error_validation", ["errors" => $data["validation"]["password"] ?? []]); ?>
                <input type="password" name="confirm_password" placeholder="confimer votre mot de passe">
                <input type="submit" value="ajouter" name="submit">
            </fieldset>
        </form>
        <hgroup>
            <p class="errors"><small><?= htmlspecialchars($data["errors"] ?? "", ENT_QUOTES, 'UTF-8') ?></small></p>
            <p class="success"><ins><?= htmlspecialchars($data["success"] ?? "", ENT_QUOTES, 'UTF-8') ?></ins></p>
        </hgroup>

    </main>
</body>

</html>