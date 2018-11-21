<?php
/**
 * @var array $users
 * @var array $subjects
 * @var \Form\AdminEnrollmentForm $form
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
<h1>Create enrollment</h1>
<form action="/enrollments/create" method="POST" class="enrollment-form">
    <?php include 'form_fields.php'; ?>
</form>
</body>
</html>