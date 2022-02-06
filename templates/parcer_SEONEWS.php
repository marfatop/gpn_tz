<?php

?>
<section>
    <!--    <h2>Шаблон --><? //=__FILE__?><!--</h2>-->
    <h2><?= $data->contents->channel->title; ?></h2>
    <div>Сcылка: <a href="<?= $data->contents->channel->link; ?>"
                    target="_blank"><?= $data->contents->channel->title; ?></a></div>
    <!--    <div>Описание: --><? //=$data->contents->channel->description;?><!-- </div>-->
    <div class="container main">
        <div class="main__item">
            <h3>Посты:</h3>
            <div>Количество постов: <?= $data->counter ?></div>
            <div>Среднее кол-во слов в посте: <?= $data->counteraveragewords ?></div>
        </div>
        <div class="main__item">
            <div style="display: flex; flex-direction: column ">
                <h3>10 популярных слов:</h3>
                <? foreach ($data->topwords as $topwords => $counter): ?>
                    <span><?= $topwords ?> (<?= $counter ?>);</span>
                <? endforeach; ?>
            </div>
        </div>
        <div class="main__item">
            <h3>Слова:</h3>
            <p>Среднее кол-во гласных в посте: <?= $data->letters['glasnye'] ?></p>
            <p>Среднее кол-во гласных в посте: <?= $data->letters['soglasnye'] ?></p>
        </div>
        <div class="main__item">
            <h3>Дата:</h3>
            <div>Дата последней публикации: <?= $data->lasttimeadd ?></div>
            <div>Дата cледующей публикации: <?= $data->nexttimeadd ?></div>
        </div>
    </div>

            <div class="container main">
                <? foreach ($data->category as $index => $category): ?>
                    <div class="main__item">
                        <h2><?= $index; ?> (<?= count($category) ?>)</h2>
                        <ul>
                            <? foreach ($category as $index => $item): ?>
                                <li><?= $item->title->__toString(); ?> </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                <? endforeach; ?>
        </div>

</section>

