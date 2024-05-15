<?php

namespace app\controllers;

use app\database\Filters;
use app\database\models\User;

class HomeController extends Controller
{
  public function index()
  {
    // $filters = new Filters;
    // $filters->join('posts', 'users.id', '=', 'posts.userId', 'LEFT JOIN');
    // $filters->where('users.id', '>', 2);
    // $user = new User;
    // $user->setFields('users.id, firstName, lastName, title');
    // $user->setFilters($filters);
    // $usersFound = $user->fetchAll();

    // dd($usersFound);

    $user = new User;
    $created = $user->update('id', 4, [
      'firstName' => 'John',
      'lastName' => 'Doe'
    ]);

    dd($created);

    $this->view('home', ['title' => 'Homepage']);
  }
}
