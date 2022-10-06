<?php

namespace core;

abstract class Model
{

  public function loadData($data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }

  const RULE_REQUIRE = 'require';
  const RULE_EMAIL = 'email';

  public $errors = [];

  abstract function getRules();

  public function validate()
  {
    foreach ($this->getRules() as $attr => $rules) {
      $value = $this->{$attr};

      foreach ($rules as $rule_name) {
        if ($rule_name === static::RULE_REQUIRE && !$value) {
          $this->addErrorByRule($attr, static::RULE_REQUIRE);
        }
        if ($rule_name === static::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
          $this->addErrorByRule($attr, static::RULE_EMAIL);
        }
      }
    }
  }

  private function addErrorByRule($attr, $rule)
  {
    if ($rule === static::RULE_REQUIRE) {
      $this->errors[] = "$attr: this field is require";
    }
    if ($rule === static::RULE_EMAIL) {
      $this->errors[] = "$attr: this field is email";
    }
  }

  protected static abstract function table();
  protected static abstract function columns();

  public function save()
  {
    $table = $this->table();
    $columns = $this->columns();

    $values = array_map(function ($c) {
      return $this->{$c};
    }, $columns);
    $values = array_map(function ($v) {
      return "'$v'";
    }, $values);

    $columns = implode(",", $columns);
    $values = implode(",", $values);

    $query = "INSERT INTO $table ($columns) VALUE ($values)";
    return Application::$app->db->pdo->exec($query);
  }

  public static function find($where, $limit = 0, $offset = 0, $order = null)
  {
    $table = static::table();
    $columns = array_keys($where);

    $params_value = [];
    foreach ($columns as $column) {
      $params_value[$column] = $where[$column];
    }

    $sql = "SELECT * FROM $table";

    if (count($columns) > 0) {
      $sql .= " WHERE " .
        implode(" AND ", array_map(
          function ($column) use ($params_value) {
            return "$column = '$params_value[$column]'";
          },
          $columns
        ));
    }
    $result = Application::$app->db->pdo->query($sql);

    $objs = [];

    while ($row = $result->fetchObject(static::class)) {
      $objs[] = $row;
    }

    return $objs;
  }
}
