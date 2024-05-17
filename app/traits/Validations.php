<?php

namespace app\traits;

use app\core\Request;

trait Validations
{
  public function required($field)
  {
    $data = Request::input($field);

    if (empty($data)) {
      return null;
    }
  }

  public function unique($field)
  {
    // $data = Request::input($field);
  }

  public function email($field)
  {
    // $data = Request::input($field);
  }

  public function maxLen($field, $param)
  {
    $data = Request::input($field);
    if (strlen($data) > 10) {
      return null;
    }

    dd($data);
  }
}
