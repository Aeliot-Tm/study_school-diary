<?php
/**
 * @var array $user
 * @var \Form\UserForm $form
 */
$data = $form->getData();
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
    <link rel="stylesheet" href="/css/users.css">
</header>
<body>
<h1>Edit user</h1>
<form action="/users/<?php echo $user['id']; ?>/edit" method="POST" class="user-form">
    <?php include 'form_fields.php'; ?>
</form>
</body>
</html>