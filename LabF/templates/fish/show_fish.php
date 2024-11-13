<?php
/** @var \App\Model\Fish $fish */
/** @var \App\Service\Router $router */

$title = "{$fish->getSpecies()} ({$fish->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $fish->getSpecies() ?></h1>
    <article>
        <p>Location: <?= $fish->getLocation() ?></p>
        <p>Record: <?= $fish->getRecord() ?></p>
    </article>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('fish-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('fish-edit', ['id'=> $fish->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
