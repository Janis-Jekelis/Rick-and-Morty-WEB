<?php
declare(strict_types=1);
require_once "vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('Public/Views');
$twig = new \Twig\Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', "/search", ["App\Controllers\EpisodeController", "search"]);
    $r->addRoute('GET', "/", ["App\Controllers\SeasonController", "index"]);
    $r->addRoute('GET', '/season/{id}', ["App\Controllers\SeasonController", "show"]);
    $r->addRoute('GET', '/season/episode/{id}', ["App\Controllers\EpisodeController", "show"]);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];
        $handler = $routeInfo[1];
        [$class, $method] = [$handler[0], $handler[1]];

        if ($handler[1] == "show") {
            $response = (new $class)->$method(intval($vars["id"]));
            if ($response->getViewName() == "SingleSeason") {
                $json = json_encode($vars);
                file_put_contents("season.json", $json);
            }
        } else {
            $response = (new $class)->$method();
        }
        echo $twig->render($response->getViewName() . ".twig", $response->getData());

        break;
}