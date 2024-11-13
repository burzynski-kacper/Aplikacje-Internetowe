<?php
/** @var \App\Service\Router $router */

$title = 'Create Fish Record';
$bodyClass = 'edit';

ob_start(); ?>
    <h1>Create Fish Record</h1>
    <form action="<?= $router->generatePath('fish-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . 'fish_form.html.php'; ?>
        <input type="hidden" name="action" value="fish-create">
    </form>
    <a href="<?= $router->generatePath('fish-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
