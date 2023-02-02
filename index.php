<?php

include('helpers.php');

print renderTemplate('layout.php', [
    "title"   => 'Завдання та проекти | Дошка',
    "user"    => 'Сергей',
    "project" => renderTemplate('projectbar.php', ["nameProject" => 'Назва Проекту'])
        . renderTemplate('projectbar.php', ["nameProject" => 'Назва Проекту']),
    "content" => renderTemplate('main.php', [
        "card" =>
            renderTemplate('card.php', [
                "header" => 'Зробити Головну',
                "text"   => 'Выучить PHP',
            ])
            . renderTemplate('card.php', [
                "header" => 'Зробити Головну',
                "text"   => 'Выучить PHP 2',
            ]),
    ]),

]);


