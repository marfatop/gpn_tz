<?php

include "lib/parcer.php";
require_once 'config.php';
require_once "controllers/controller.php";

$key='SEONEWS';
$key2='INTERNETRU';

$controller=new controller();

$controller->setData($key);
$template=$controller->getTemplate();

$controller->setData($key2);
$template2=$controller->getTemplate();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание:</title>
    <link rel="stylesheet" href="style.css">
    <div>
    <ul>
        <li>Необходимо реализовать парсеры rss-лент(любые). Парсер должен наследоваться от абстрактного класса.</li>
        <li>Реализовать 2 или более парсеров.</li>
        <li>Каждый парсер, должен получать xml разными способами.</li>
        <li>Вывести результат для каждого парсера:</li>
    </ul>
    </div>
    <div>
        <ul>
            <li>Вывод сделать в виде колонок используя display: flex</li>
            <li>Подсчитать и вывести количество постов</li>
            <li>Подсчитать и вывести среднее количество слов в посте</li>
            <li>Вывести список категорий постов</li>
            <li>Подсчитать и вывести какое количество постов в каждой категории и отсортировать по ним</li>
            <li>Вывести 10 популярных слов во всех постах и их количество</li>
            <li>Вывести дату последнего поста и сколько прошло времени с последнего поста</li>
            <li>Вывести предполагаемое время следующего поста</li>
            <li>Подсчитать среднее количество гласных и согласных во всех постах</li>
        </ul>
    </div>
</head>
<body>
<div class="container">
    <div class="parcer">
        <?=$template?>
        <?=$template2?>

    </div>
</div>

</body>
</html>