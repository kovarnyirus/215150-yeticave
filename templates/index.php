<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $cat): ?>
            <li class="promo__item <?=htmlspecialchars($cat['html_class'])?>">
                <a class="promo__link" href="all-lots.html"><?=htmlspecialchars($cat['category_name'])?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">

        <?php foreach ($lots_list as $key => $value): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($value['lot_img']);?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= htmlspecialchars ($value['category_name']) ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id']?>"><?= htmlspecialchars ($value['name']) ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price(htmlspecialchars ($value['initial_price'])); ?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?= $date_end_list[$key]?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
