<?php

namespace app\database\models;

use app\database\Connection;
use PDOException;
use PDO;
use app\database\Filters;
use app\database\Pagination;

abstract class Model
{
  private string $fields = '*';
  private ?Filters $filters = null;
  private string $pagination = '';
  protected string $table;
  protected array $atributes = [];

  public function __set(string $property, mixed $value)
  {
    $this->atributes[$property] = $value;
  }

  public function __get(string $property)
  {
    return $this->atributes[$property];
  }

  public function setFields($fields)
  {
    $this->fields = $fields;
  }

  public function setFilters(Filters $filters)
  {
    $this->filters = $filters;
  }

  public function setPagination(Pagination $pagination)
  {
    $pagination->setTotalItems($this->count());
    $this->pagination = $pagination->dump();
  }

  public function create(array $data)
  {
    try {
      $sql = "INSERT INTO {$this->table} (";
      $sql .= implode(',', array_keys($data)) . ") VALUES(:";
      $sql .= implode(',:', array_keys($data)) . ")";

      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);

      return $prepare->execute($data);
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function update(string $field, string|int $fieldValue, array $data)
  {
    try {
      $sql = "UPDATE {$this->table} SET ";
      foreach ($data as $key => $value) {
        $sql .= "{$key} = :{$key}, ";
      }
      $sql = rtrim($sql, ', ');
      $sql .= " WHERE {$field} = :{$field}";

      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);

      $data[$field] = $fieldValue;
      return $prepare->execute($data);
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function fetchAll()
  {
    try {
      $sql = "SELECT {$this->fields} FROM {$this->table} {$this->filters?->dump()} {$this->pagination} ";
      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);
      $prepare->execute($this->filters ? $this->filters->getBind() : []);
      return $prepare->fetchAll(PDO::FETCH_CLASS);
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function findBy(string $field = '', string $value = '')
  {
    try {
      $sql = (!empty($this->filters)) ?
        "SELECT {$this->fields} FROM {$this->table} {$this->filters?->dump()}" :
        "SELECT {$this->fields} FROM {$this->table} WHERE {$field} = :{$field}";

      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);
      $prepare->execute($this->filters ? $this->filters->getBind() : [$field => $value]);

      return $prepare->fetchObject();
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

      return $query->fetchObject();
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
      return $prepare->execute(empty($this->filters) ? [$field => $value] : $this->filters->getBind());
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }

  public function count()
  {
    try {
      $sql = "SELECT {$this->fields} FROM {$this->table} {$this->filters?->dump()}";
      $connection = Connection::connect();

      $prepare = $connection->prepare($sql);
      $prepare->execute($this->filters ? $this->filters->getBind() : []);

      return $prepare->rowCount();
    } catch (PDOException $e) {
      dd($e->getMessage());
    }
  }
}
