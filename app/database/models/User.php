<?php

namespace app\database\models;

class User extends Model
{
  public int $id;
  public string $firstName;
  public string $lastName;
  public string $email;
  public string $password;
  public string $created_at;
  public string $updated_at;

  public function __construct()
  {
    $this->table = 'users';
  }

  public function teste()
  {
    dd('teste');
  }
}
