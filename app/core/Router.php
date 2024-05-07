<?php

namespace app\core;

use app\core\RoutersFilter;


class Router
{
  public static function run()
  {
    try {
      $routerRegistered = new RoutersFilter;
      $router = $routerRegistered->get();

      $controller = new Controller;
      $controller->execute($router);
      dd($router);
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }
}
