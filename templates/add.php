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

    <form class="form form--add-lot container <?php print (isset($errors) ? 'form--invalid' : ''); ?>" method="post" enctype="multipart/form-data" action="add.php"
          method="post"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $class_name = isset($errors['lot-name']) ? 'form__item--invalid' : '';
            $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""; ?>
            <div class="form__item <?= $class_name; ?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                       value="<?= $value; ?>">
                <span class="form__error">Введите наименование лота</span>
            </div>

            <?php $class_name;
            if (isset($lot['category'])){
                if($lot['category'] == 'Выберите категорию'){
                    $class_name = 'form__item--invalid';
                }else $class_name = $lot['category'];
            }else $class_name = '';
            $value = isset($lot['category']) ? 'selected' :''; ?>
            <div class="form__item <?= $class_name; ?>">
                <label for="category">Категория</label>
                <select id="category" name="category">
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $key => $val): ?>
                        <?php if ($val['category_name'] == $lot['category']): ?>
                            <option selected ='selected'><?=$val;?></option>
                        <?php else: ?>
                            <option><?=$val;?></option>
                    <?php endif ?>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>

        <?php $class_name = isset($errors['description']) ? 'form__item--invalid' : '';
        $value = isset($lot['description']) ? $lot['description'] : ""; ?>
        <div class="form__item form__item--wide <?= $class_name; ?>">
            <label for="message">Описание</label>
            <textarea id="description" name="description" placeholder="Напишите описание лота"><?= $value ?></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>

        <?php $class_name = isset($lot['lot_img']) ? 'form__item--uploaded' : '';
        $img = isset($lot['lot_img']) ? $lot['lot_img'] : ""; ?>
        <div class="form__item form__item--file <?= $class_name;?> "> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?=$img;?>" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" name="lot_img" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <?php $class_name = isset($errors['lot-rate']) ? 'form__item--invalid' : '';
            $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : ""; ?>
            <div class="form__item form__item--small <?= $class_name ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите начальную цену</span>
            </div>

            <?php $class_name = isset($errors['lot-step']) ? 'form__item--invalid' : '';
            $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""; ?>
            <div class="form__item form__item--small <?= $class_name ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>

            <?php $class_name = isset($errors['lot-date']) ? 'form__item--invalid' : '';
            $value = isset($lot['lot-date']) ? $lot['lot-date'] : ''; ?>
            <div class="form__item <?= $class_name ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?= $value; ?>">
                <span class="form__error">Введите дату завершения торгов</span>
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
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
