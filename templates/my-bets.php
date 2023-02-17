<section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <? foreach($goods as $good) {?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?=$good['img']?>" width="54" height="40" alt="<?=$good['category_name']?>">
            </div>
            
            <h3 class="rates__title"><a href="lot.php?id=<?$good['lot_id']?>"><?=$good['title']?></a></h3>
          </td>
          <td class="rates__category">
            <?$good['category_name']?>
          </td>
          <td class="rates__timer <?php if($res[2]<=0) {  ?>   
          <?php if ($good['winner_id']==$user_id) { ?>
            timer--finishing          
          <?php  } else { ?>
            timer--end
          <?php }} ?>">
          <?php $res = get_time_left($good['date_finish'])?>
            <div class="lot__timer timer <?php if ($res[1]<1): ?> timer--finishing<?php endif;?>">
            <?="$res[0] : $res[1] : $res[2]"?>
            </div><!-- 07:13:34 -->
          </td>
          <td class="rates__price">
            <?=$good['price_bet']?> р
          </td>
          <td class="rates__time">
          <?php $res = get_time_left($good['date_bet']);?>
          <?php if($res[0]>1) { ?>
              <?=date_format(date_create($good['date_bet']),'m.d.Y')?> в <?="$res[1]:$res[2]"?>
          <?php } elseif($res[0]==1) { ?>
              Вчера, в <?="$res[1]:$res[2]"?>
          <?php } elseif($res[1]>1) { ?>
              Сегодня, в <?="$res[1]:$res[2]"?>
          <?php  } elseif($res[1]==1) { ?>
              час назад
          <?php  } elseif($res[1]<1) { ?>
            <?=get_noun_plural_form($res[2],'минута','минуты','минут')?> назад
          <?php } elseif($res[2]<=0) {  ?>   
          <?php if ($good['winner_id']==$user_id) { ?>
            ставка выигарна          
          <?php  } else { ?>
            торги окончены
          <?php } ?>
          </td>
        </tr>
          <?php } } ?>
      </table>
    </section>