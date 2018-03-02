<section class="lot-item container">
    <?php if (isset($lot)): ?>
    <h2><?=htmlspecialchars($lot['name']);?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['lot_img']?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category_name']?></span></p>
            <p class="lot-item__description"><?= $lot['description']?></p>
        </div>
        <div class="lot-item__right">
            <?php if (isset($_SESSION['user']) and !($_SESSION['user']['id'] == $lot['user_id']) and !$bet_made ):?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?=$date_end_lots?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot_cost?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= $lot['step']?> р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="lot.php?id=<?=$lot['id']?>" method="post">
                    <p class="lot-item__form-item <?=$class_name?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="12 000">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif;?>
            <div class="history">
                <h3>История ставок (<span><?=count($bets)?></span>)</h3>
                <table class="history__list">
                    <?php if ($bets):?>
                        <?php foreach ($bets as $value):?>
                        <tr class="history__item">
                            <td class="history__name"><?= htmlspecialchars ($value['name']) ?></td>
                            <td class="history__price"><?= htmlspecialchars ($value['bet']) ?> р</td>
                            <td class="history__time"><?=htmlspecialchars ($value['bet_date']); ?></td>
                         </tr>
                        <?php endforeach; ?>
                    <?php endif;?>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h1 style="color: black">Страница с таким товаром не найдена</h1>
    <?php endif; ?>
</section>
