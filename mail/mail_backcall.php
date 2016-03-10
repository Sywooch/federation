<h2 style="color: #b32020;">Обратный звонок</h2>
<hr/>
<?
echo "<p>Поступила заявка на обратный звонок. Клиент хочет, чтобы ему перезвонили </p>
<p style='font-size: 22px; color: #2268b0;'>{$post['weCallYou']} в {$post['hour']}:{$post['minutes']}</span> </p>
<p style='font-size: 22px; color: #b32020;'><strong>{$post['phone']}</strong></p>";

$date = date('d.m.Y H:i:s');

echo '<hr/>';
echo "<p style='font-size: 12px; color: lightslategray'><em>Дата отправления: $date</em></p>";
?>
<br/>
