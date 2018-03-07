<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $cat): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=htmlspecialchars($cat['category_name'])?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($bets_list as $bet): ?>

                <?php
            $class = '';
            $last_bet = sql_get_last_bet($db_connect, [$bet['lot_id']]);
            if ($bet['fk_winner_id'] == $user_id and $last_bet[0]['bet_id'] == $bet['last_bet']){
                $class = 'rates__item--win';
            } elseif (strtotime( "now" ) > strtotime($bet['date_end'])){
                $class = 'rates__item--end';
            }
                ?>
            <tr class="rates__item <?=htmlspecialchars($class)?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?=htmlspecialchars($bet['lot_img'])?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <div>
                    <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($bet['id'])?>"><?=htmlspecialchars($bet['name'])?></a>
                    </h3>
                    <?= $bet['fk_winner_id'] == $user_id ? '<p>' . htmlspecialchars($bet['user_contacts']) . '</p>' : ''?>
                    </div>
                </td>
                <td class="rates__category">
                    <?=htmlspecialchars($bet['category_name'])?>
                </td>
                <?php
                $class = '';
                if($bet['fk_winner_id'] == $user_id and $last_bet[0]['bet_id'] == $bet['last_bet']){
                    $time_bets = 'Ставка выграла';
                    $class = 'timer--win';
                }elseif (strtotime( "now" ) > strtotime($bet['date_end'])){
                    $time_bets = 'Торги окончены';
                    $class = 'timer--end';
                } else {
                    $time_bets = date ('G.i.s', strtotime($bet['bet_date']));
                    $class = 'timer--finishing';
                }
                ?>
                <td class="rates__timer">
                    <div class="timer <?=$class?>">
                        <?=htmlspecialchars($time_bets)?>
                    </div>
                </td>
                <td class="rates__price">
                    <?=htmlspecialchars($bet['bet'])?> р
                </td>
                <td class="rates__time">
                    <?=htmlspecialchars(date ('G часов i минут назад', (strtotime( "now" ) - strtotime($bet['bet_date']))))?></div>
                </td>
            </tr>

            <?php endforeach; ?>
        </table>
    </section>
</main>
