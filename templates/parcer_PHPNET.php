<?php

?>
<section>
    <h2>Шаблон <?=__FILE__?></h2>
    <div>Название: <?=$data->contents->channel->title;?></div>
    <div>Сcылка: <a href="<?=$data->contents->channel->link;?>" target="_blank"><?=$data->contents->channel->title;?></a></div>
    <div>Описание: <?=$data->contents->channel->description;?> </div>
    <div>
        Количество постов: <?=$data->counter?>
    </div>
    <div>
        Среднее кол-во слов в посте: <?=$data->counteraveragewords?>
    </div>
    <div>
        <ul>
        <? foreach ($data->titles as $title):?>
        <li><?=$title;?></li>
        <?endforeach;?>
        </ul>
    </div>
    <? foreach ($data->contents->item as $item): ?>
        <p><?=$item->title;?></p>
        <p><?=$item->description;?></p>
    <? endforeach; ?>
    <pre>
        <? var_dump($data->contents->item);?>
    </pre>
</section>

