<?php

namespace App;

use App\Http\Request;

class Router
{
    /**
     * @var string
     */
    private $viewPath;
    /**
     * @var AltoRouter
     */
    private $router;
    /**
     * @var App
     */
    private $app;

    public function __construct(string $viewPath, App $app)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
        $this->app = $app;
    }

    public function get(string $url, string $view, ?string $name = null)
    {
        $this->router->map('GET', $url, $view, $name);

        return $this;
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $match = $this->router->match();
        $view = $match['target'];
        $router = $this;
        $app = $this->app;
        $request = new Request($_GET);
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }
}