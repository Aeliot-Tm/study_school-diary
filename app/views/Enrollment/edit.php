<?php
/**
 * @var array $enrollment
 * @var array $subjects
 * @var array $users
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
<h1>Edit enrollment</h1>
<form action="/enrollments/<?php echo $enrollment['id']; ?>/edit" method="POST" class="enrollment-form">
    <?php include 'form_fields.php'; ?>
</form>
</body>
</html>