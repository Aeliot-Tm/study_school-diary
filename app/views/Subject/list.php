<?php
/**
 * @var array $subjects
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
    <link rel="stylesheet" href="/css/subjects.css">
</header>
<body>
<div><?php require __DIR__.'/../Core/menu.php'; ?></div>
<h1>Subjects</h1>
<div class="top-actions"><a href="/subjects/create" class="btn btn-success">Create</a></div>
<table class="table subjects-table">
    <thead>
    <tr>
        <th>Name</th>
        <th class="table-actions"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subjects as $subject) { ?>
        <tr>
            <td><?php echo $subject['name']; ?></td>
            <td class="table-actions">
                <a href="/subjects/<?php echo $subject['id']; ?>/edit" class="btn btn-default">Edit</a>
                <a href="/subjects/<?php echo $subject['id']; ?>/delete" class="btn btn-default">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>