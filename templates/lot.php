<section class="lot-item container">
    <?php if (isset($lot)): ?>
    <h2><?=htmlspecialchars($lot['lot-name']);?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['img_url']?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
            <p class="lot-item__description"><?= $lot['description']?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost">10 999</span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="12 000">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $value):?>
                    <tr class="history__item">
                        <td class="history__name"><?= htmlspecialchars ($value['name']) ?></td>
                        <td class="history__price"><?= htmlspecialchars ($value['price']) ?> р</td>
                        <td class="history__time"><?= date('d.m.Y H:i:s ', $value['ts']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h1 style="color: black">Страница с таким товаром не найдена</h1>
    <?php endif; ?>
</section>
