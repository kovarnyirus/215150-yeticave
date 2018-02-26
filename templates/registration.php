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
    <form class="form form--add-lot container <?php print (isset($errors) ? 'form--invalid' : ''); ?>" enctype="multipart/form-data" action="registration.php" method="post"> <!-- form--invalid -->
        <h2>Регистрация</h2>
        <?php $class_name = isset($errors['email']) ? 'form__item--invalid' : '';
        $value = isset($user['email']) ? $user['email'] : ""; ?>
        <div class="form__item <?=$class_name?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?=$value?>">
            <span class="form__error">Введите e-mail</span>
        </div>
        <?php $class_name = isset($errors['password']) ? 'form__item--invalid' : '';?>
        <div class="form__item <?=$class_name?> ">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" required>
            <span class="form__error">Введите пароль</span>
        </div>

        <?php $class_name = isset($errors['name']) ? 'form__item--invalid' : '';
        $value = isset($user['name']) ? $user['name'] : ""; ?>
        <div class="form__item <?=$class_name?>"> <!-- form__item--invalid -->
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите Имя" value="<?=$value?>" required>
            <span class="form__error">Введите Имя</span>
        </div>

        <?php $class_name = isset($errors['contacts']) ? 'form__item--invalid' : '';
        $value = isset($user['contacts']) ? $user['contacts'] : ""; ?>
        <div class="form__item form__item--wide <?=$class_name?>">
            <label for="contacts">Контактные данные</label>
            <textarea id="contacts" name="contacts" placeholder="Контактные данные" required><?= $value ?></textarea>
            <span class="form__error">Контактные данные</span>
        </div>

        <div class="form__item form__item--file"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="avatar" id="avatar" value="">
                <label for="avatar">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <?php if (isset($errors)): ?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
            <ul>
                <?php foreach ($errors as $err => $val): ?>
                    <li><strong><?= $dict[$err]; ?>:</strong> <?= $val; ?></li>
                <?php endforeach; ?>
            </ul>
            </div>
        <?php endif; ?>
        <button type="submit" class="button">Регистрация</button>
    </form>
</main>
