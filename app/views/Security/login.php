<?php
/**
 * @var \Form\UserForm $form
 */
$data = $form->getData();
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
</header>
<body>
<h1>Login</h1>
<form action="/login" method="POST" class="user-form">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" name="login" value="<?php echo $data['login'] ?>" id="login" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password"
               value="<?php echo $data['password']; ?>"
               id="password" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" name="save" class="btn btn-success">Login</button>
    </div>
</form>
</body>
</html>