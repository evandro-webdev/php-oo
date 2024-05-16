<?php

namespace app\controllers;

use app\database\Filters;
use app\database\models\User;
use app\database\Pagination;

class HomeController extends Controller
{
  public function index()
  {
    $filters = new Filters;
    // $filters->join('posts', 'users.id', '=', 'posts.userId', 'LEFT JOIN');
    $filters->where('id', '>', 2);

    $pagination = new Pagination;
    $pagination->setItemsPerPage(10);

    $user = new User;
    $user->setFields('firstName, lastName, email');
    $user->setFilters($filters);
    $user->setPagination($pagination);
    $users = $user->fetchAll();

    $this->view('home', ['title' => 'Homepage', 'users' => $users, 'pagination' => $pagination]);
  }
}
