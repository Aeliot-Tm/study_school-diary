<?php
/**
 * @var \Form\UserForm $form
 */
$data = $form->getData();
?>
<div class="form-group">
    <label for="login">Login</label>
    <input type="text" name="login" value="<?php echo $data['login'] ?>" id="login" class="form-control">
</div>
<div class="form-group">
    <label for="plain_password">Password</label>
    <input type="password" name="plain_password"
           value="<?php echo $data['plain_password'] ?? ''; ?>"
           id="plain_password" class="form-control">
</div>
<div class="form-group">
    <label for="plain_password_confirm">Password confirm</label>
    <input type="password" name="plain_password_confirm"
           value="<?php echo $data['plain_password_confirm'] ?? ''; ?>"
           id="plain_password_confirm" class="form-control">
</div>
<div class="form-group">
    <label for="roles">Roles</label>
    <select name="roles[]" id="roles" multiple class="form-control">
        <option value=""></option>
        <?php foreach (\Enum\Role::getAll() as $role) { ?>
            <option value="<?php echo $role ?>"
                    <?php if (in_array($role, $data['roles'])) { ?>selected<?php } ?>>
                <?php echo $role ?>
            </option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <button type="submit" name="save" class="btn btn-success">Save</button>
    <a href="/users" class="btn btn-default">Cancel</a>
</div>