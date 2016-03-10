<h2 style="color: #b32020;">Клиент добавил заказ #<?= $idOrder ?></h2>
<hr/>
<?
$arr = [
    'Категория:'   => $typeNameServices['type']['name'],
    'Тип заказа:'  => $typeNameServices['name']['name_services'],
    'Заголовок:'   => $post['Index']['header'],
    'Подробности:' => $post['more'],
    'Сроки:'       => $post['Index']['dateToStartWorking']
];

$arrClient = [
    'Адрес:'   => $post['Index']['location'],
    'Имя:'     => $post['Index']['clientName'],
    'Телефон:' => $post['Index']['clientTel'],
    'Email:'   => $post['Index']['clientEmail']
];

// style field in mail
$styleDiv  = 'margin: 0px 20px; line-height: 30px';
$styleKey  = 'color: #2268b0; display: block; float: left;';
$styleSpan = 'display: block; margin-left: 130px; font-style: italic;';

$date = date('d.m.Y H:i:s');


foreach ($arr as $arrKey => $arrVal) {
    if (! $arrVal) {
        $arrVal = '-';
    }
    echo "<div style='{$styleDiv}'><strong style='{$styleKey}'>{$arrKey}</strong> <span style='{$styleSpan}'>{$arrVal}</span></div><br/>";
}

echo '<hr/>';
echo '<hr/>';

foreach ($arrClient as $arrKey => $arrVal) {
    if (! $arrVal) {
        $arrVal = '-';
    }
    echo "<div style='{$styleDiv}'><strong style='{$styleKey}'>{$arrKey}</strong> <span style='{$styleSpan}'>{$arrVal}</span></div><br/>";
}

echo '<hr/>';
echo "<p style='font-size: 12px; color: lightslategray'><em>Заказ был добавлен: $date</em></p>";
?>
<br/>
