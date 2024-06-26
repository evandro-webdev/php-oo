<?php

namespace app\controllers;

use app\core\Request;
use app\database\models\User;
use app\support\Csrf;
use app\support\Validation;

class UserController extends Controller
{
  public function edit($params)
  {
    $user = new User;
    $user = $user->findBy('id', $params[0]);

    $this->view('user', ['title' => 'Editar usuário', 'user' => $user]);
  }

  public function update($params)
  {
    $validation = new Validation;
    $validated = $validation->validate([
      'firstName' => 'required',
      'lastName' => 'required',
      'email' => 'email|required|unique:' . User::class,
      'password' => 'maxLen:10|required',
    ]);

    if (!$validated) {
      return redirect("/user/{$params[0]}");
    }
  }
}
