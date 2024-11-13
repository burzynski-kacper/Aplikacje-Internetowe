<?php
/** @var \App\Model\Fish[] $fishes */
/** @var \App\Service\Router $router */

$title = 'Fish List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Fish List</h1>
    <a href="<?= $router->generatePath('fish-create') ?>">Add new Fish Record</a>

    <ul class="index-list">
        <?php foreach ($fishes as $fish): ?>
            <li>
                <h3><?= $fish->getSpecies() ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('fish-show', ['id' => $fish->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('fish-edit', ['id' => $fish->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
