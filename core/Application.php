<?php

namespace core;

use models\User;

class Application
{

  public static $ROOT_DIR;
  public static $VIEW_DIR;
  public static $app;
  public $user;

  public static $cnt = 0;

  public function __construct()
  {
    session_start();

    static::$ROOT_DIR = dirname(__DIR__);
    static::$VIEW_DIR = static::$ROOT_DIR . '/views';
    static::$app = $this;

    $this->router = new Router();
    $this->db = new Database();

    if (isset($_SESSION['user_id'])) {
      $id = $_SESSION['user_id'];
      $users = User::find(['id' => $id]);
      if (count($users) > 0) {
        $this->user = $users[0];
      }
    }
  }

  public function run()
  {
    static::$cnt += 1;
    $this->router->resolve();
  }

  public function login($user)
  {
    $this->user = $user;
    $_SESSION['user_id'] = $user->id;
  }

  public function logout()
  {
    $this->user = null;
    session_unset();
  }

  public function isLogin()
  {
    return $this->user != null;;
  }
}
