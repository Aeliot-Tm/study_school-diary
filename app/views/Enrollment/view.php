<?php
/**
 * @var array $enrollment
 */
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <?php include __DIR__.'/../Core/styles.html'; ?>
</header>
<body>
<h1>Enrollment</h1>
<p><?php echo $enrollment['user_name'] ?>
    enrolled to <?php echo $enrollment['subject_name'] ?>
    as <?php echo $enrollment['role'] ?>. </p>
<div>
    <a href="/enrollments" class="btn btn-default">Back to the list</a>
</div>
</body>
</html>