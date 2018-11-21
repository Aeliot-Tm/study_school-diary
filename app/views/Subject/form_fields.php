<?php
/**
 * @var \Form\SubjectForm $form
 */
$data = $form->getData();
?>
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?php echo $data['name'] ?>" id="name" class="form-control">
</div>
<div class="form-group">
    <button type="submit" name="save" class="btn btn-success">Save</button>
    <a href="/subjects" class="btn btn-default">Cancel</a>
</div>