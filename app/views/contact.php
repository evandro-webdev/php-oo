<?php $this->layout('master', ['title' => $title]) ?>
<br>
<h1>Contato</h1>
<br>
<?php echo flash('sent_success', 'msg-success') ?>
<?php echo flash('sent_error', 'msg-failed') ?>

<form action="/contact" method="post">
  <div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <?php echo flash('name', 'msg-failed') ?>
    <input type="text" name="name" value="" class="form-control" id="name" placeholder="Digite seu nome">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <?php echo flash('email', 'msg-failed') ?>
    <input type="email" name="email" value="" class="form-control" id="email" placeholder="nome@exemplo.com">
  </div>
  <div class="mb-3">
    <label for="subject" class="form-label">Assunto</label>
    <?php echo flash('subject', 'msg-failed') ?>
    <input type="subject" name="subject" value="" class="form-control" id="subject" placeholder="Assunto">
  </div>
  <div class="mb-3">
    <label for="message" class="form-label">Mensagem</label>
    <?php echo flash('message', 'msg-failed') ?>
    <textarea name="message" class="form-control" id="message" placeholder="Digite sua mensagem"></textarea>
  </div>
  <?php echo getToken() ?>

  <button type="submit" class="btn btn-primary">Enviar</button>
</form>