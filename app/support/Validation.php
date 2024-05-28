<?php

namespace app\support;

use app\traits\Validations;
use Exception;

class Validation
{
  use Validations;

  private $inputsValidation = [];

  private function getParam($validationType, $param)
  {
    if (substr_count($validationType, ':') == 1) {
      [$validationType, $param] = explode(':', $validationType);
    }

    return [$validationType, $param];
  }

  private function validationExists($validationType)
  {
    if (!method_exists($this, $validationType)) {
      throw new Exception("O método {$validationType} não existe na validação");
    }
  }

  public function validate(array $validations)
  {
    foreach ($validations as $field => $validationType) {
      $havePipes = str_contains($validationType, '|');

      if (!$havePipes) {
        $param = '';

        [$validationType, $param] = $this->getParam($validationType, $param);

        $this->validationExists($validationType);

        $this->inputsValidation[$field] = $this->$validationType($field, $param);
      } else {

        $validations = explode('|', $validationType);
        $param = '';

        $inputsValidation[$field] = $this->multipleValidations($validations, $field, $param);
      }
    }

    return $this->returnValidation();
  }

  private function multipleValidations($validations, $field, $param)
  {
    foreach ($validations as $validation) {

      [$validation, $param] = $this->getParam($validation, $param);

      $this->validationExists($validation);

      $this->inputsValidation[$field] = $this->$validation($field, $param);

      if ($this->inputsValidation[$field] === null) {
        break;
      }
    }
  }

  private function returnValidation()
  {
    Csrf::validateToken();

    if (in_array(null, $this->inputsValidation, true)) {
      return null;
    }

    return $this->inputsValidation;
  }
}
