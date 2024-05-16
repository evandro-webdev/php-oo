<?php $this->layout('master', ['title' => $title]) ?>

<br>
<h4><?php echo $pagination->getTotal() ?></h4>
<h1>Usuários</h1>
<br>

<h4>Mostrando <?php echo $pagination->getPerPage() ?> usuários</h4>


<ul class="list-group">
  <?php foreach ($users as $user) {
    echo "<li class='list-group-item'>{$user->firstName}</li>";
  } ?>
</ul>

<br>

<?php echo $pagination->links() ?>