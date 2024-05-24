<?php $this->layout('master', ['title' => $title]) ?>
<br>
<h1>Editar usuário</h1>
<br>
<?php flash('created') ?>

<form action="/user/update/<?php echo $user->id ?>" method="post">
  <div class="mb-3">
    <label for="firstName" class="form-label">Nome</label>
    <?php echo flash('firstName', 'msg-failed') ?>
    <input type="text" name="firstName" value="<?php echo $user->firstName ?>" class="form-control" id="firstName" placeholder="Digite seu primeiro nome">
  </div>
  <div class="mb-3">
    <label for="lastName" class="form-label">Sobrenome</label>
    <?php echo flash('lastName', 'msg-failed') ?>
    <input type="text" name="lastName" value="<?php echo $user->lastName ?>" class="form-control" id="lastName" placeholder="Digite seu segundo nome">
  </div>
  <?php echo flash('email', 'msg-failed') ?>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" value="<?php echo $user->email ?>" class="form-control" id="email" placeholder="nome@exemplo.com">
  </div>
  <?php echo flash('password', 'msg-failed') ?>
  <div class="mb-3">
    <label for="password" class="form-label">Senha</label>
    <input type="password" name="password" value="<?php echo $user->password ?>" class="form-control" id="password" placeholder="Digite sua senha">
  </div>
  <?php echo getToken() ?>

  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>