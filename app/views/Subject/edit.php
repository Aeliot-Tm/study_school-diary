<?php
/**
 * @var array $subject
 * @var \Form\SubjectForm $form
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
<h1>Edit subject</h1>
<form action="/subjects/<?php echo $subject['id']; ?>/edit" method="POST" class="subject-form">
    <?php include 'form_fields.php'; ?>
</form>
</body>
</html>