<section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$search?></span>»</h2>
        <?if(!empty($goods)):?>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach($goods as $good):?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="../<?=$good['img'];?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($good['category_name']);?></span>
                    <h3 class="lot__title"><a class="text-link" href="../lot.php?id=<?=$good['id']?>"><?=$good['title'];?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Старотовая цена</span>
                            <span class="lot__cost"><?=htmlspecialchars(format_string($good['start_price']));?><b class="rub">р</b></span>
                        </div>
                        <?php $res = get_time_left($good['date_finish'])?>
                        <div class="lot__timer timer <?php if ($res[0]<1): ?> timer--finishing<?php endif;?>">
                            <?="$res[0] : $res[1]"?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php if($page_counts>1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="yeticave/?search=<?$search?>&page=<?$page+1?>">Назад</a></li>
        <? foreach($pages as $page) { ?>
            <?php if($page == $_GET['page']) {?>
        <li class="pagination-item pagination-item-active"><a><?=$page?></a></li>
            <?php } else { ?>
        <li class="pagination-item"><a href="yeticave/?search=<?$search?>&page=<?$page?>"><?$page?></a></li>
            <?php } ?>
        <?php }?>
        <li class="pagination-item pagination-item-next"><a href="yeticave/?search=<?$search?>&page=<?$page+1?>">Вперед</a></li>
    </ul>
    <?php endif; ?>
    <?php else: ?>
        <p>Ничего не найдено</p>
    <?php endif; ?>