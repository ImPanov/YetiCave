use yeticave;

INSERT INTO categories(category_name,character_code) VALUES('Доски и лыжи', 'boards');
INSERT INTO categories(category_name,character_code) VALUES('attachment', 'Крепление');
INSERT INTO categories(category_name,character_code) VALUES('Ботинки','boots');
INSERT INTO categories(category_name,character_code) VALUES('Одежда','clothes');
INSERT INTO categories(category_name,character_code) VALUES('Инструменты','tools');
INSERT INTO categories(category_name,character_code) VALUES('Разное','others');

INSERT INTO users(
        user_name,
        user_password,
        email,
        contacts) 
    VALUES(
        'ilya',
        '31122003597qwer',
        'panpviliy@gmail.com',
        '89221443699');
INSERT INTO users(
        user_name,
        user_password,
        email,
        contacts) 
    VALUES(
        'vika',
        'i3112v1302',
        'vvika@gmail.com',
        '89326060229');

INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id) 
    VALUES(
        '2014 Rossignol District Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-1.jpg',
        10999,
        '2023-02-04',
        300,
        1,
        2,
        1
    );
INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id) 
    VALUES(
        'DC Ply Mens 2016/2017 Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-2.jpg',
        15999,
        '2023-02-14',
        1000,
        2,
        1,
        1
    );
INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id) 
    VALUES(
        'Крепления Union Contact Pro 2015 года размер L/XL',
        'Хорошие крепления.',
        'img/lot-3.jpg',
        8000,
        '2023-02-18',
        200,
        2,
        1,
        2
    );
INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id) 
    VALUES(
        'Крепления Union Contact Pro 2015 года размер L/XL',
        'Хорошие крепления.',
        'img/lot-4.jpg',
        10999,
        '2023-01-28',
        600,
        2,
        1,
        2
    );
INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id)
    VALUES(
        'Куртка для сноуборда DC Mutiny Charocal',
        'Тёплая прочная куртка',
        'img/lot-5.jpg',
        7500,
        '2023-02-09',
        500,
        1,
        2,
        4
    );
INSERT INTO lots(
        title,
        lot_description,
        img,
        start_price,
        date_finish,
        step,
        user_id,
        winner_id,
        category_id)
    VALUES(
        '2014 Rossignol District Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-6.jpg',
        5400,
        '2023-02-19',
        100,
        1,
        2,
        6
    );

INSERT INTO bets(price_bet,user_id,lot_id) VALUES(7000,1,2);
INSERT INTO bets(price_bet,user_id,lot_id) VALUES(5900,2,4);

SELECT * FROM categories;
SELECT * FROM lots 
WHERE date_creation < CURRENT_TIMESTAMP;
SELECT *,categories.category_name FROM lots INNER JOIN categories ON categories.id=lots.category_id;
UPDATE lots SET title = "Маска Oakley Canopy" , lot_description="Классная маска" WHERE id = 6;
SELECT *,lots.id as lots_id, categories.category_name lots.title, user.user_name FROM bets
INNER JOIN lots ON bets.lot_id=lots.id
INNER JOIN categories ON categories.lot_id=lots.id
INNER JOIN user ON bets.user_id=user.id
WHERE lot_id=4
ORDER BY date_bet DESC;