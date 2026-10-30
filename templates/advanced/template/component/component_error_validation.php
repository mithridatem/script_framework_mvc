<hgroup>
<?php foreach ($data["errors"] ?? [] as $error) : ?>
    <p><small><?= htmlspecialchars($error->message, ENT_QUOTES, 'UTF-8'); ?></small></p>
<?php endforeach; ?>
</hgroup>

