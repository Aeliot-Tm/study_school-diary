<?php
/**
 * @var array $enrollments
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
    <link rel="stylesheet" href="/css/enrollments.css">
</header>
<body>
<div><?php require __DIR__.'/../Core/menu.php'; ?></div>
<h1>Enrollments</h1>
<div class="top-actions"><a href="/enrollments/create" class="btn btn-success">Create</a></div>
<table class="table enrollments-table">
    <thead>
    <tr>
        <th>User Name</th>
        <th>Subject</th>
        <th>Role</th>
        <th class="table-actions"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($enrollments as $enrollment) { ?>
        <tr>
            <td><?php echo $enrollment['user_name']; ?></td>
            <td><?php echo $enrollment['subject_name']; ?></td>
            <td><?php echo $enrollment['role']; ?></td>
            <td class="table-actions">
                <a href="/enrollments/<?php echo $enrollment['id']; ?>/edit" class="btn btn-default">Edit</a>
                <a href="/enrollments/<?php echo $enrollment['id']; ?>/delete" class="btn btn-default">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>