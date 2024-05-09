<?php $this->layout('master', ['title' => $title]) ?>

<h1>User</h1>

<form action="/user/update/12" method="post">
  <input type="text" name="firstName" value="Evandro">
  <input type="text" name="lastName" value="Mateus">
  <input type="text" name="email" value="evandro@gmail.com">
  <input type="password" name="password" value="12345">

  <button type="submit">Atualizar</button>
</form>