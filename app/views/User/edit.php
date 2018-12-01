<?php
/**
 * @var \Core\Form\Form $form
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
<div class="errors-bl">
    <?php foreach ($form->getErrors() as $error) { ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php } ?>
</div>
<form method="POST" class="user-form">
    <?php foreach ($form->getFields() as $field) { ?>
        <div class="form-group">
            <?php echo $field; ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <button type="submit" name="save" class="btn btn-success">Save</button>
        <a href="/users" class="btn btn-default">Cancel</a>
    </div>
</form>
</body>
</html>