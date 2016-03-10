<h2 style="color: #b32020;">Заявка на вступление в Федерацию</h2>
<hr/>
<?
$arr       = [
    'О себе:' => $post['more']
];
$arrClient = [
    'Имя:'     => $post['Masters']['clientName'],
    'Телефон:' => $post['Masters']['clientTel'],
    'Email:'   => $post['Masters']['clientEmail']
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
echo "<p style='font-size: 12px; color: lightslategray'><em>Дата отправления: $date</em></p>";
?>
<br/>
