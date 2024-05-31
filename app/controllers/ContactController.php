<?php

namespace app\controllers;

use app\support\Email;
use app\support\Flash;
use app\support\Validation;

class ContactController extends Controller
{
  public function index()
  {
    $this->view('contact', ['title' => 'Contact']);
  }

  public function store()
  {
    $validation = new Validation;
    $validated = $validation->validate([
      'name' => 'required',
      'email' => 'email|required',
      'subject' => 'required|maxLen:50',
      'message' => 'required'
    ]);

    if (!$validated) {
      return redirect('/contact');
    }

    $email = new Email;
    $sent = $email->from($validated['email'], $validated['name'])
      ->to(['evandromateus066@gmail.com'])
      ->subject($validated['subject'])
      ->message($validated['message'])
      ->template('contact', ['name' => $validated['name']])
      ->send();

    if ($sent) {
      Flash::set('sent_success', 'Email enviado');
      return redirect('/contact');
    }

    Flash::set('sent_error', 'Ocorreu um erro ao enviar o email');
    return redirect('/contact');
  }
}
