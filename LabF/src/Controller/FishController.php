<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Fish;
use App\Service\Router;
use App\Service\Templating;

class FishController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $fishes = Fish::findAll();
        $html = $templating->render('fish/index_fish.php', [
            'fishes' => $fishes,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $fish = Fish::fromArray($requestPost);
            $fish->save();

            $path = $router->generatePath('fish-index');
            $router->redirect($path);
            return null;
        } else {
            $fish = new Fish();
        }

        $html = $templating->render('fish/create_fish.php', [
            'fish' => $fish,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $fishId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $fish = Fish::find($fishId);
        if (! $fish) {
            throw new NotFoundException("Missing fish with id $fishId");
        }

        if ($requestPost) {
            $fish->fill($requestPost);
            $fish->save();

            $path = $router->generatePath('fish-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('fish/edit_fish.php', [
            'fish' => $fish,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $fishId, Templating $templating, Router $router): ?string
    {
        $fish = Fish::find($fishId);
        if (! $fish) {
            throw new NotFoundException("Missing fish with id $fishId");
        }

        $html = $templating->render('fish/show_fish.php', [
            'fish' => $fish,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $fishId, Router $router): ?string
    {
        $fish = Fish::find($fishId);
        if (! $fish) {
            throw new NotFoundException("Missing fish with id $fishId");
        }

        $fish->delete();
        $path = $router->generatePath('fish-index');
        $router->redirect($path);
        return null;
    }
}
