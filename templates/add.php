<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $cat): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=$cat['category_name']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <form class="form form--add-lot container <?php print (isset($errors) ? 'form--invalid' : ''); ?>" method="post" enctype="multipart/form-data" action="add.php"
          method="post"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $class_name = isset($errors['name']) ? 'form__item--invalid' : '';
            $value = isset($lot['name']) ? $lot['name'] : ""; ?>
            <div class="form__item <?= $class_name; ?>"> <!-- form__item--invalid -->
                <label for="name">Наименование</label>
                <input id="name" type="text" name="name" placeholder="Введите наименование лота"
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
                    <?php foreach ($categories as $key => $cat): ?>
                        <?php if ($cat['category_name'] == $lot['category']): ?>
                            <option selected ='selected'><?=$cat['category_name'];?></option>
                        <?php else: ?>
                            <option><?=$cat['category_name'];?></option>
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
            <?php $class_name = isset($errors['initial_price']) ? 'form__item--invalid' : '';
            $value = isset($lot['initial_price']) ? $lot['initial_price'] : ""; ?>
            <div class="form__item form__item--small <?= $class_name ?>">
                <label for="initial_price">Начальная цена</label>
                <input id="initial_price" type="number" name="initial_price" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите начальную цену</span>
            </div>

            <?php $class_name = isset($errors['step']) ? 'form__item--invalid' : '';
            $value = isset($lot['step']) ? $lot['step'] : ""; ?>
            <div class="form__item form__item--small <?= $class_name ?>">
                <label for="step">Шаг ставки</label>
                <input id="step" type="number" name="step" placeholder="0" value="<?= $value; ?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>

            <?php $class_name = isset($errors['date_end']) ? 'form__item--invalid' : '';
            $value = isset($lot['date_end']) ? $lot['date_end'] : ''; ?>
            <div class="form__item <?= $class_name ?>">
                <label for="date_end">Дата окончания торгов</label>
                <input class="form__input-date" id="date_end" type="date" name="date_end" value="<?= $value; ?>">
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
