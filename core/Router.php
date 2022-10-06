<?php

namespace core;

class Router
{

  private $routes;

  public function __construct()
  {
    $this->routes = [];
  }

  public function get($url, $callback, $middlewares = [])
  {
    $this->routes['get'][$url] = [
      'callback' => $callback,
      'middlewares' => $middlewares
    ];
  }

  public function post($url, $callback, $middlewares = [])
  {
    $this->routes['post'][$url] = [
      'callback' => $callback,
      'middlewares' => $middlewares
    ];
  }

  public function resolve()
  {
    $url = $_SERVER['REQUEST_URI'];
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $route_config = $this->routes[$method][$url] ?? null;

    $callback = $url;

    if ($route_config != null) {
      $middlewares = $route_config['middlewares'];
      foreach ($middlewares as $middleware) {
        $middleware->handle();
      }

      $callback = $route_config['callback'];
      if (is_array($callback)) {
        call_user_func($callback);
        return;
      }
    }


    $this->renderView($callback);
  }

  public function renderView($view, $params = [])
  {
    $app = Application::$app;

    foreach ($params as $key => $value) {
      $$key = $value;
    }

    ob_start();
    include Application::$VIEW_DIR . "/_layout.php";
    $layout_content = ob_get_clean();

    if (file_exists(Application::$VIEW_DIR . "/$view.php")) {
      include Application::$VIEW_DIR . "/$view.php";
    } else {
      include Application::$VIEW_DIR . "/404.php";
    }
    $view_content = ob_get_clean();
    echo str_replace('{{content}}', $view_content, $layout_content);
  }
}
