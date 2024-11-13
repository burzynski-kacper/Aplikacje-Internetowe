<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    // Akcje dla Post
    case 'post-index':
    case null:
        $controller = new \App\Controller\PostController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'post-create':
        $controller = new \App\Controller\PostController();
        $view = $controller->createAction($_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-edit':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->editAction($_REQUEST['id'], $_REQUEST['post'] ?? null, $templating, $router);
        break;
    case 'post-show':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'post-delete':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\PostController();
        $view = $controller->deleteAction($_REQUEST['id'], $router);
        break;

    // Nowe akcje dla Fish
    case 'fish-index':
        $controller = new \App\Controller\FishController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'fish-create':
        $controller = new \App\Controller\FishController();
        $view = $controller->createAction($_REQUEST['fish'] ?? null, $templating, $router);
        break;
    case 'fish-edit':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\FishController();
        $view = $controller->editAction($_REQUEST['id'], $_REQUEST['fish'] ?? null, $templating, $router);
        break;
    case 'fish-show':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\FishController();
        $view = $controller->showAction($_REQUEST['id'], $templating, $router);
        break;
    case 'fish-delete':
        if (! $_REQUEST['id']) {
            break;
        }
        $controller = new \App\Controller\FishController();
        $view = $controller->deleteAction($_REQUEST['id'], $router);
        break;

    // Akcja informacyjna
    case 'info':
        $controller = new \App\Controller\InfoController();
        $view = $controller->infoAction();
        break;

    // Obsługa nieznanej akcji
    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
