 <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname?>" action="/login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
     
      <div class="form__item  <?=isset($errors['email']) ? 'form__item--invalid' : ''?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= $user['email'] ?? "" ;?>" placeholder="Введите e-mail">
        <span class="form__error"><?=isset($errors['password']) ? 'Введите e-mail' : ''?></span>
      </div>
      <div class="form__item form__item--last <?=isset($errors['password']) ? 'form__item--invalid' : ''?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?= $user['password'] ?? "" ;?>" placeholder="Введите пароль">
        <span class="form__error"><?=isset($errors['password']) ? 'Введите пароль' : ''?></span>
      </div>
      <?php if (!empty($errors)):?>
      <span class="form__error form__error--bottom"><?=$errors['fail'] ?? 'Пожалуйста, исправьте ошибки в форме.'?></span>
      <?php endif;?>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>

</div>
