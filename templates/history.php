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
    <div class="container">
        <section class="lots">
            <h2>История просмотров</span></h2>
            <ul class="lots__list">
                <?foreach ($history_lot as $key => $val):?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $val['lot_img'];?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $val['category_name'];?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$val['id']?>"> <?= $val['name'];?> </a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= $val['initial_price'];?><b class="rub">р</b></span>
                            </div>
                            <div class="lot__timer timer">
                                <?=$date_end_list[$key]?>
                            </div>
                        </div>
                    </div>
                </li>
                <?endforeach;?>
            </ul>
        </section>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
            <li class="pagination-item pagination-item-active"><a>1</a></li>
            <li class="pagination-item"><a href="#">2</a></li>
            <li class="pagination-item"><a href="#">3</a></li>
            <li class="pagination-item"><a href="#">4</a></li>
            <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
    </div>
</main>
