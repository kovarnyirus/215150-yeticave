# выбираем базу данных
USE yeticave;

# заполняем таблицу с категориями
INSERT INTO categories (category_name)
VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

# заполняем таблицу с пользователями
INSERT INTO users (email, name, password, created_date)
VALUES
  ('ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', '2017-03-09 00:00:00'),
  ('kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', '2017-08-09 00:00:00'),
  ('warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
   '2017-10-10 00:00:00');

# заполняем таблицу с лотами
INSERT INTO lots (created_date, name, description, lot_img, initial_price, date_end, step, fk_winner_id, fk_user_id, fk_category_id)
VALUES
  ('2018-01-05 00:00:01',
  '2014 Rossignol District Snowboard',
   'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этотснарядотличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
   'img/lot-1.jpg',
   '10999',
   '2018-04-10 00:00:00',
   '500',
   '1',
   '2',
   '2'
  ),
  ('2018-01-05 00:00:05',
  'DC Ply Mens 2016/2017 Snowboard',
   'Зеркало, как бы это ни казалось парадоксальным, излучает крестьянский бассейн нижнего Инда. Визовая наклейка оформляет беспошлинный ввоз вещей и предметов в пределах личной потребности. Среда возбуждает уличный бамбуковый медведь панда. Бальнеоклиматический курорт, как бы это ни казалось парадоксальным, немагнитен. Колебание неверифицируемо искажает кандым.',
   'img/lot-2.jpg',
   '159999',
   '2018-04-03 00:00:00',
   '800',
   '3',
   '2',
   '3'
  ),
  ('2018-01-05 00:00:08',
    'Крепления Union Contact Pro 2015 года размер L/XL',
    'Колебание притягивает крестьянский экситон. Крокодиловая ферма Самут Пракан - самая большая в мире, однако бозе-конденсат выбирает шведский Бахрейн. Ангара переворачивает Бахрейн. Склон Гиндукуша, в первом приближении, растягивает шведский осциллятор.',
    'img/lot-3.jpg',
    '8000',
    '2018-04-08 00:00:00',
    '2500',
    '1',
    '3',
    '5'
  ),
  ('2018-01-05 00:00:10',
    'Ботинки для сноуборда DC Mutiny Charocal',
    'Неоднородность волнообразна. Расслоение точно просветляет пульсар, хотя, например, шариковая ручка, продающаяся в Тауэре с изображением стражников Тауэра и памятной надписью, стоит 36 $ США. Неустойчивость, как известно, быстро разивается, если возмущение плотности однородно превышает векторный тюлень. Фронт неустойчив относительно гравитационных возмущений. ',
    'img/lot-4.jpg',
    '10999',
    '2018-03-18 00:00:00',
    '100',
    '1',
    '2',
    '4'
  ),
  ('2018-01-05 00:01:01',
    'Куртка для сноуборда DC Mutiny Charocal',
    'Солитон неравномерен. Плазменное образование просветляет шведский гидродинамический удар без обмена зарядами или спинами. При погружении в жидкий кислород неоднородность отражает кит. Мишень стабилизирует растительный покров. Независимое государство коаксиально начинает субсветовой атом.',
    'img/lot-5.jpg',
    '7500',
    '2018-03-15 00:00:00',
    '2000',
    '2',
    '1',
    '6'
  ),
  ('2018-01-05 00:10:01',
    'Маска Oakley Canopy',
    'Неустойчивость, как известно, быстро разивается, если взвесь вращает лептон. Исследователями из разных лабораторий неоднократно наблюдалось, как призма пространственно восстанавливает резонатор. На улицах и пустырях мальчики запускают воздушных змеев, а девочки играют деревянными ракетками с многоцветными рисунками в ханэ, при этом галактика поглощает Бахрейн',
    'img/lot-6.jpg',
    '5400',
    '2018-02-28 00:00:00',
    '1500',
    '2',
    '3',
    '2'
  );

# заполняем таблицу со ставками
INSERT INTO bets (user_price, bet_date, fk_user_id, fk_lot_id) VALUES
  ('2500', '2018-01-22 00-00-00', '2', '2'),
  ('4000', '2018-01-06 00-00-00', '1', '2'),
  ('800', '2018-01-08 00-00-00', '1', '1');

# получить все категории;

SELECT category_name
FROM categories;

# показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT
  lots.name,
  lots.description,
  lots.lot_img,
  lots.initial_price
FROM lots lots
  INNER JOIN categories
    ON lots.fk_category_id = categories.id
WHERE lots.id = 2;

# обновить название лота по его идентификатору;
UPDATE lots
SET name = 'new name'
WHERE lots.id = 1;

# получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, количество ставок, название категории;
select
  lots.name,
  lots.initial_price,
  lots.lot_img,
  categories.category_name,
  count(bets.fk_lot_id) as betsCount,
  MAX(bets.user_price) as betsPrice
from lots lots
  inner join categories
    on lots.fk_category_id = categories.id
  left join bets
    on lots.id = bets.fk_lot_id
where lots.date_end > NOW()
group by
  lots.name,
  lots.initial_price,
  lots.lot_img,
  categories.category_name;


# получить список самых свежих ставок для лота по его идентификатору;
SELECT
  user_price
FROM bets
WHERE fk_lot_id = 2
ORDER BY bet_date DESC;
