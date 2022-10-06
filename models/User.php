<?php

namespace models;

use core\Model;

class User extends Model
{

  public $name;
  public $email;
  public $password;

  public function welcome()
  {
    return 'Welcome ' . $this->name;
  }

  public function getRules()
  {
    return [
      'name' => [static::RULE_REQUIRE],
      'email' => [static::RULE_REQUIRE, static::RULE_EMAIL],
      'password' => [static::RULE_REQUIRE],
    ];
  }

  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
  }

  public function verifyPassword($password)
  {
    return password_verify($password, $this->password);
  }

  protected static function table()
  {
    return "users";
  }

  protected static function columns()
  {
    return ['name', 'email', 'password'];
  }
}
