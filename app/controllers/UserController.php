<?php

namespace app\controllers;

class UserController extends Controller
{
  public function edit($params)
  {
    $this->view('user', ['title' => 'Página do usuário', 'name' => 'Evandro']);
  }
}
