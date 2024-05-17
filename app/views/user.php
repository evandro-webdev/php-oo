<?php $this->layout('master', ['title' => $title]) ?>
<br>
<h1>Editar usuário</h1>
<br>
<form action="/user/update" method="post">
  <div class="mb-3">
    <label for="firstName" class="form-label">Nome</label>
    <input type="text" name="firstName" value="<?php echo $user->firstName ?>" class="form-control" id="firstName" placeholder="Digite seu primeiro nome">
  </div>
  <div class="mb-3">
    <label for="lastName" class="form-label">Sobrenome</label>
    <input type="text" name="lastName" value="<?php echo $user->lastName ?>" class="form-control" id="lastName" placeholder="Digite seu segundo nome">
  </div>
  <?php echo getToken() ?>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" value="<?php echo $user->email ?>" class="form-control" id="email" placeholder="nome@exemplo.com">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Senha</label>
    <input type="password" name="password" value="<?php echo $user->password ?>" class="form-control" id="password" placeholder="Digite sua senha">
  </div>

  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>