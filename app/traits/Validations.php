<?php

namespace app\traits;

use app\core\Request;
use app\support\Flash;

trait Validations
{
  public function required($field)
  {
    $data = Request::input($field);

    if (empty($data)) {
      Flash::set($field, "Esse campo é obrigatório");
      return null;
    }

    return strip_tags($data, '<p><b>');
  }

  public function unique($field, $param)
  {
    $data = Request::input($field);

    $model = new $param;
    $registerFound = $model->findBy($field, $data);

    // dd($registerFound);

    if ($registerFound) {
      Flash::set($field, "{$data} já está registrado");
      return null;
    }

    return strip_tags($data, '<p><b>');
  }

  public function email($field)
  {
    $data = Request::input($field);
    if (!filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)) {
      Flash::set($field, "Esse email é inválido");
      return null;
    }

    return strip_tags($data, '<p><span>');
  }

  public function maxLen($field, $param)
  {
    $data = Request::input($field);
    if (strlen($data) > 10) {
      Flash::set($field, "Esse campo aceita no máximo {$param} caracteres");

      return null;
    }

    return strip_tags($data, '<p><b>');
  }
}
