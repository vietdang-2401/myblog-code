<h1>Login</h1>

<form action="login" method="post">
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
      <label for="password">Password <span class="field-require">*</span></label>
    </div>
    <div class="form-input">
      <input type="password" id="password" name="password" value="">
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

  <button type="submit">Submit</button>
</form>