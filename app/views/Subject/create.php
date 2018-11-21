<?php
/**
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
<h1>Create subject</h1>
<form action="/subjects/create" method="POST" class="subject-form">
    <?php include 'form_fields.php'; ?>
</form>
</body>
</html>