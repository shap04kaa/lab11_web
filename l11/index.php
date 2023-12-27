<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №11</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="header">
    <div class="wrap">
        <!-- Выбор типа верстки -->
        <div>
            <a href="?html_type=TABLE&content=<?php echo $_GET['content'] ?? 'n/a'; ?>">Табличная верстка</a>
            <a href="?html_type=DIV&content=<?php echo $_GET['content'] ?? 'n/a'; ?>">Блочная верстка</a>
        </div>
    </div>
</header>

<main>
    <!-- Блок с ссылками на разные разделы таблицы умножения -->
    <div class="sidebar" id="product_menu">
        <?php
        // Генерация ссылок для разделов таблицы умножения
        renderContentLink('n/a', 'Вся таблица умножения');
        for ($i = 2; $i <= 9; $i++) {
            renderContentLink($i, "На $i");
        }
        ?>
    </div>

    <section class="content">
        <?php
        // Проверка выбранного типа верстки и генерация соответствующего контента
        if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE') {
            // Генерация таблицы умножения
            if (!isset($_GET['content']) || $_GET['content'] == 'n/a') {
                for ($i = 2; $i <= 9; $i++) {
                    renderMultiplicationTable($i);
                }
            } else {
                renderMultiplicationTable($_GET['content']);
            }
        } else {
            // Генерация блочной таблицы умножения
            if (!isset($_GET['content']) || $_GET['content'] == 'n/a') {
                for ($i = 2; $i <= 9; $i++) {
                    renderDivMultiplicationTable($i);
                }
            } else {
                renderDivMultiplicationTable($_GET['content']);
            }
        }
        ?>
    </section>
</main>

<footer class="footer" id="footer">
    <div class="wrap">
        <!-- Блок с датой и выбранными параметрами верстки и контента -->
        <div style="text-align: center">
            <li class="footer-info_item" style="color: black"><?= getHtmlTypeText() ?></li> <br>
            <li class="footer-info_item" style="color: black"><?= getContentText() ?></li> <br>
            <?= date('d.m.Y // H:i:s') ?>
        </div>
    </div>
</footer>

</body>
</html>

<?php

// Функция для генерации ссылок на разделы таблицы умножения
function renderContentLink($value, $label)
{
    $isActive = (!isset($_GET['content']) && $value == 'n/a') || (isset($_GET['content']) && $_GET['content'] == $value);
    $url = "?content=$value&html_type=" . ($_GET['html_type'] ?? '');
    echo "<a href='$url'" . ($isActive ? " class='selected'" : '') . ">$label</a>";
}

// Функция для генерации таблицы умножения
function renderMultiplicationTable($n)
{
    echo '<table class="tvRow">';
    renderRowTable($n);
    echo '</table>';
}

// Функция для генерации блочных элементов таблицы умножения
function renderDivMultiplicationTable($n)
{
    echo '<div class="bvRow">';
    renderRow($n);
    echo '</div>';
}

// Функция для генерации строки таблицы умножения
function renderRow($n)
{
    for ($i = 2; $i <= 9; $i++) {
        renderNumAsLink($n);
        echo ' x ';
        renderNumAsLink($i);
        echo ' = ';
        renderNumAsLink($i * $n);
        echo '<br>';
    }
}

// Функция для генерации строки таблицы умножения внутри тега <tr><td></td><td></td></tr>
function renderRowTable($n)
{
    for ($i = 2; $i <= 9; $i++) {
        echo '<tr><td>';
        renderNumAsLink($n);
        echo ' x ';
        renderNumAsLink($i);
        echo '</td><td>';
        renderNumAsLink($i * $n);
        echo '</td></tr>';
    }
}

// Функция для генерации ссылки на число или вывода числа, если оно не больше 9
function renderNumAsLink($x)
{
    if ($x <= 9) {
        echo '<a href="?content=' . $x . '&html_type=' . ($_GET['html_type'] ?? 'TABLE') . '">' . $x . '</a>';
    } else {
        echo $x;
    }
}

// Функция для получения текстового представления выбранного типа верстки
function getHtmlTypeText()
{
    if (!isset($_GET['html_type']))
        return 'Верстка не выбрана';
    else if ($_GET['html_type'] == "TABLE")
        return 'Табличная верстка';
    else
        return 'Блочная верстка';
}

// Функция для получения текстового представления выбранного контента
function getContentText()
{
    if (!isset($_GET['content']) || $_GET['content'] == 'n/a')
        return 'Вся таблица умножения';
    else
        return 'Таблица умножения на ' . $_GET['content'];
}
?>