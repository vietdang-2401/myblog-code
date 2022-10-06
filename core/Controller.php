<?php 

namespace core;

class Controller {
  
  protected function renderView($view, $params = []) {
    Application::$app->router->renderView($view, $params);
  }

  protected function getData() {
    $data = [];

    if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
      foreach ($_POST as $key => $value) {
        $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }
    // if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
    //   foreach ($_GET as $key => $value) {
    //     $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    //   }
    // }

    return $data;
  }
}
?>