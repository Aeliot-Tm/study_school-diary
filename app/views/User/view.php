<?php
/**
 * @var array $user
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
</header>
<body>
<h1>User: <?php echo $user['login'] ?></h1>
<div>
    <p>
        Has roles: <?php echo implode(', ', $user['roles']); ?>
    </p>
    <a href="/users" class="btn btn-default">Back to the list</a>
</div>
</body>
</html>