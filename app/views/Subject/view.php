<?php
/**
 * @var array $subject
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
</header>
<body>
<h1>Subject: <?php echo $subject['name'] ?></h1>
<div>
    <a href="/subjects" class="btn btn-default">Back to the list</a>
</div>
</body>
</html>