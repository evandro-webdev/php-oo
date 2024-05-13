<?php

namespace app\database\models;

use app\database\Connection;
use PDOException;
use PDO;
use app\database\Filters;

abstract class Model
{
  private string $fields = '*';
  private string $filters = '';
  protected string $table;

  public function setFields($fields)
  {
    $this->fields = $fields;
  }

  public function setFilters(Filters $filters)
  {
    $this->filters = $filters->dump();
  }

  public function fetchAll()
  {
    try {
      $sql = "SELECT {$this->fields} FROM {$this->table} {$this->filters}";
      $connection = Connection::connect();

      $query = $connection->query($sql);
      return $query->fetchAll(PDO::FETCH_CLASS, get_called_class());
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function findBy(string $field = '', string $value = '')
  {
    try {
      $sql = (!empty($this->filters)) ?
        "SELECT {$this->fields} FROM {$this->table} {$this->filters}" :
        "SELECT {$this->fields} FROM {$this->table} WHERE {$field} = :{$field}";

      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);
      $prepare->execute(empty($this->filters) ? [$field => $value] : []);

      return $prepare->fetchObject(get_called_class());
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function first($field = 'id', $order = 'asc')
  {
    try {
      $sql = "SELECT {$this->fields} FROM {$this->table} ORDER BY {$field} {$order}";
      $connection = Connection::connect();

      $query = $connection->query($sql);

      return $query->fetchObject(get_called_class());
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function delete(string $field = '', string|int $value = '')
  {
    try {
      $sql = (!empty($this->filters)) ?
        "DELETE FROM {$this->table} {$this->filters}" :
        "DELETE FROM {$this->table} WHERE {$field} = :{$field}";

      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);
      return $prepare->execute(empty($this->filters) ? [$field => $value] : []);
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function count()
  {
    try {
      $sql = "SELECT {$this->fields} FROM {$this->table} {$this->table}";
      $connection = Connection::connect();

      $query = $connection->query($sql);

      return $query->rowCount();
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }
}
