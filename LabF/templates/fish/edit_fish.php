<?php
/** @var \App\Model\Fish $fish */
/** @var \App\Service\Router $router */

$title = "Edit Fish {$fish->getSpecies()} ({$fish->getId()})";
$bodyClass = 'edit';

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('fish-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . 'fish_form.html.php'; ?>
        <input type="hidden" name="action" value="fish-edit">
        <input type="hidden" name="id" value="<?= $fish->getId() ?>">
    </form>
    <form action="<?= $router->generatePath('fish-delete') ?>" method="post">
        <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
        <input type="hidden" name="action" value="fish-delete">
        <input type="hidden" name="id" value="<?= $fish->getId() ?>">
    </form>
    <a href="<?= $router->generatePath('fish-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
