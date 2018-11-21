<?php
/**
 * @var array $users
 * @var array $subjects
 * @var \Form\AdminEnrollmentForm $form
 */
$data = $form->getData();
?>
<div class="form-group">
    <label for="user">User</label>
    <select name="user_id" id="user" class="form-control">
        <option value=""></option>
        <?php foreach ($users as $userId => $userName) { ?>
            <option value="<?php echo $userId ?>"
                    <?php if ($userId == $data['user_id']) { ?>selected<?php } ?>>
                <?php echo $userName ?>
            </option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="subject">Subject</label>
    <select name="subject_id" id="subject" class="form-control">
        <option value=""></option>
        <?php foreach ($subjects as $subjectId => $subjectName) { ?>
            <option value="<?php echo $subjectId ?>"
                    <?php if ($subjectId == $data['subject_id']) { ?>selected<?php } ?>>
                <?php echo $subjectName ?>
            </option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="role">Role: <?php echo $data['role']; ?></label>
    <select name="role" id="role" class="form-control">
        <option value=""></option>
        <?php foreach (\Enum\Role::getForEnrollment() as $role) { ?>
            <option value="<?php echo $role ?>"
                    <?php if ($role === $data['role']) { ?>selected<?php } ?>>
                <?php echo $role ?>
            </option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <button type="submit" name="save" class="btn btn-success">Save</button>
    <a href="/enrollments" class="btn btn-default">Cancel</a>
</div>