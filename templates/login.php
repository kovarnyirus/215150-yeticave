<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="all-lots.html">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Разное</a>
            </li>
        </ul>
    </nav>
    <form class="form container <?php echo (isset($errors) ? 'form--invalid' : ''); ?>" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <?php $class_name = isset($errors['email']) ? 'form__item--invalid' : '';
        $error_message = isset($errors['email']) ? $errors['email'] : 'Введите e-mail' ;
        $value = isset($form['email']) ? $form['email'] : ""; ?>
        <div class="form__item <?= $class_name ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"  value="<?= $value; ?>">
            <span class="form__error"><?= $error_message?></span>
        </div>
        <?php $class_name = isset($errors['password']) ? 'form__item--invalid' : '';
        $error_message = isset($errors['password']) ? $errors['password'] : 'Введите пароль';
        $value = isset($form['password']) ? $form['password'] : ""; ?>
        <div class="form__item form__item--last <?= $class_name ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль"  value="<?= $value; ?>">
            <span class="form__error"><?= $error_message?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
