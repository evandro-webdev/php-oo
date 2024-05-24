<?php

use app\support\Flash;

function flash(string $index, string $css = '')
{
  if (isset($_SESSION[$index])) {
    $message = Flash::get($index);

    return "<span class='msg {$css}'>{$message}</span>";
  }
}
