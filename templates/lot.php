
    <section class="lot-item container">
      <h2><?=$title?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="../<?=htmlspecialchars($good['img']);?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?=htmlspecialchars($good['category_name'])?></span></p>
          <p class="lot-item__description"><?=htmlspecialchars($good['lot_description'])?></p>
        </div>
        <div class="lot-item__right">          
        <?php if($is_auth == 1):?>
          <div class="lot-item__state">
          <?php $res = get_time_left($good['date_finish'])?>
            <div class="lot__timer timer <?php if ($res[0]<1): ?> timer--finishing<?php endif;?>">
                <?="$res[0] : $res[1]"?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?=$good['start_price']?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?=$good['start_price']+$good['step']?></span>
              </div>
            </div>
            <form class="lot-item__form" action="../lot.php?id=<?=$good['id']?>" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item form__item--invalid">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?=$good['start_price']+$good['step']?>">
              <span class="form__error"><?=$errors['cost'] ?? ''?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <?php endif;?>
          <div class="history">
            <h3>История ставок (<span><?=count($bets)?></span>)</h3>
            <table class="history__list">
              <?php foreach($bets as $bet): ?>
              <tr class="history__item">
                <td class="history__name"><?=htmlspecialchars($bet['user_name'])?></td>
                <td class="history__price"><?=$bet['price_bet']?></td>
                <td class="history__time"><?php $res = get_time_left($bet['date_bet']);?>
          <?php if($res[0]>1) { ?>
              <?=date_format(date_create($bet['date_bet']),'m.d.Y')?> в <?="$res[1]:$res[2]"?>
          <?php } elseif($res[0]==1) { ?>
              Вчера, в <?="$res[1]:$res[2]"?>
          <?php } elseif($res[1]>1) { ?>
              Сегодня, в <?="$res[1]:$res[2]"?>
          <?php  } elseif($res[1]==1) { ?>
              час назад
          <?php  } elseif($res[1]<1) { ?>
            <?=get_noun_plural_form($res[2],'минута','минуты','минут') ?> назад <?php } ?></td>
              </tr>
              <?php endforeach;?>
            </table>
          </div>
        </div>
      </div>
    </section>





</body>
</html>
