<?php

namespace app\support;

use app\traits\Validations;
use Exception;

class Validation
{
  use Validations;
  public function validate(array $validations)
  {
    $inputsValidation = [];
    foreach ($validations as $field => $validationType) {
      $havePipes = str_contains($validationType, '|');

      if (!$havePipes) {
        $param = '';
        if (substr_count($validationType, ':') == 1) {
          [$validationType, $param] = explode(':', $validationType);
        }

        if (!method_exists($this, $validationType)) {
          throw new Exception("O método {$validationType} não existe na validação");
        }

        $inputsValidation[$field] = $this->$validationType($field, $param);
      } else {

        $validations = explode('|', $validationType);
        $param = '';
        foreach ($validations as $validation) {
          if (substr_count($validation, ':') == 1) {
            [$validation, $param] = explode(':', $validation);
          }

          if (!method_exists($this, $validation)) {
            throw new Exception("O método {$validation} não existe na validação");
          }

          $inputsValidation[$field] = $this->$validation($field, $param);

          if (empty($inputsValidation[$field])) {
            break;
          }
        }
      }
    }

    Csrf::validateToken();

    if (in_array(null, $inputsValidation, true)) {
      return null;
    }

    return $inputsValidation[$field];
  }
}
