<?php

namespace controllers;

use core\Controller;
use core\Application;
use models\User;

class AuthController extends Controller
{

  public function login()
  {
    return $this->renderView('login');
  }

  public function logout()
  {
    Application::$app->logout();
    header("Location: /login");
  }

  public function handleLogin()
  {
    $email = $this->getData()['email'];
    $password = $this->getData()['password'];

    $users = User::find(['email' => $email]);
    if (count($users) == 0) {
      return $this->renderView('login', ['errors' => ["This email not exist"]]);
    }
    $user = $users[0];

    if (!$user->verifyPassword($password)) {
      return $this->renderView('login', ['user' => $user, 'errors' => ["Password is incorrect!"]]);
    }

    Application::$app->login($user);
    header("location:/dashboard");
    return $this->renderView('dashboard', ['user' => $user]);
  }

  public function dashboard()
  {
    return $this->renderView('dashboard', ['user' => Application::$app->user]);
  }

  public function handleSignup()
  {
    $password = $this->getData()['password'];
    $confirm_password = $this->getData()['confirm-password'];

    $user = new User();
    $user->loadData($this->getData());
    $user->validate();

    if (count($user->errors) > 0) {
      return $this->renderView('signup', ['user' => $user, 'errors' => $user->errors]);
    }

    if ($password != $confirm_password) {
      return $this->renderView('signup', ['user' => $user, 'errors' => ["Confirm password not match!"]]);
    }

    $user->hashPassword();

    if (!$user->save()) {
      $user->errors[] = "Database failed";
      return $this->renderView('signup', ['user' => $user, 'errors' => $user->errors]);
    }

    return $this->renderView('home', ['user' => $user]);
  }
}
