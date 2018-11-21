<?php
/**
 * @var array $users
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
    <link rel="stylesheet" href="/css/users.css">
</header>
<body>
<div><?php require __DIR__.'/../Core/menu.php'; ?></div>
<h1>Users</h1>
<div class="top-actions"><a href="/users/create" class="btn btn-success">Create</a></div>
<table class="table users-table">
    <thead>
    <tr>
        <th>Login</th>
        <th>Roles</th>
        <th class="table-actions"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user['login']; ?></td>
            <td><?php echo implode(', ', $user['roles']); ?></td>
            <td class="table-actions">
                <a href="/users/<?php echo $user['id']; ?>/edit" class="btn btn-default">Edit</a>
                <a href="/users/<?php echo $user['id']; ?>/delete" class="btn btn-default">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>