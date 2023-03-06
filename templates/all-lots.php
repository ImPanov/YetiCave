    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach($goods as $good):?>
                <?php $res = get_time_left($good['date_finish'])?>
                
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="../<?=$good['img'];?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($good['category_name']);?></span>
                    <h3 class="lot__title"><a class="text-link" href="../lot.php?id=<?=$good['id']?>"><?=$good['title'];?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=htmlspecialchars(format_string($good['start_price']));?><b class="rub">р</b></span>
                        </div>
                        
                        <div class="lot__timer timer <?php if ($res[1]<1): ?> timer--finishing<?php endif;?>">
                            <?="$res[0] : $res[1] : $res[2]"?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>