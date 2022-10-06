<form action="" method="post">

    <div class="form-field">
        <div class="form-label">
            <label for="email">Email <span class="field-require">*</span></label>
        </div>
        <div class="form-input">
            <input type="email" id="email" name="email" value="<?= $user->email ?? '' ?>">
        </div>
    </div>

    <div class="form-field">
        <div class="form-label">
            <label for="name">Full name <span class="field-require">*</span></label>
        </div>
        <div class="form-input">
            <input type="text" id="name" name="name" value="<?= $user->name ?? '' ?>">
        </div>
    </div>

    <div class="form-field">
        <div class="form-label">
            <label for="password">Password <span class="field-require">*</span></label>
        </div>
        <div class="form-input">
            <input type="password" id="password" name="password" value="">
        </div>
    </div>

    <div class="form-field">
        <div class="form-label">
            <label for="confirm-password">Confirm password <span class="field-require">*</span></label>
        </div>
        <div class="form-input">
            <input type="password" id="confirm-password" name="confirm-password" value="">
        </div>
    </div>

    <div class="form-field">
        <div class="form-error">
            <?php
            if (!isset($errors)) {
            } else
            if (count($errors) > 0) {
                echo $errors[0];
            } else {
                echo "Successful!";
            }
            ?>
        </div>
    </div>

    <div class="form-field">
        <input type="submit" value="Sign up">
    </div>

</form>