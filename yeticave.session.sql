use yeticave;
SELECT *,lots.id as lots_id, categories.category_name lots.title, user.user_name FROM bets
INNER JOIN lots ON bets.lot_id=lots.id
INNER JOIN categories ON categories.lot_id=lots.id
INNER JOIN user ON bets.user_id=user.id
WHERE lot_id=4
ORDER BY date_bet DESC;