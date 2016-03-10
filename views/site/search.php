<?php
use yii\helpers\Url;
use yii\helpers\PageHelper;

$this->title = 'Муж на час' . PageHelper::pageString('page', 'Страница', 'toTitle');

$this->params['breadcrumbs'][] = $this->title;

$link = Url::to(['/masters/all']);
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>

<div class='greyBg clear' style="padding-bottom: 30px;">
    <div class="aboutHead fontLogo">
        <h1><?= 'Муж на час' . PageHelper::pageString('page', 'Страница', 'toH1') ?></h1>
    </div>
</div>

<div class="greyBg clear">
    <div class="content warningHourMain">
        <p class='warningHour' style="padding-bottom: 20px;">В связи с участившимимся просьбами, мы решили ввести
            новую услугу <strong>"МУЖ НА ЧАС"</strong></p>

        <p class='warningHour'><span>ВАЖНО:</span> Не все исполнители, представленные в этом разделе, являются
            членами федерации. Следовательно, Федерация не несет ответственности за качество исполнения. Это лишь
            попытка помочь Вам найти мастера, не обращаясь к другим источником. При этом Вы всегда можете обратиться
            к <a href='<?= $link ?>'>СПЕЦИАЛИСТАМ</a>, которые прошли проверку качества.</p>
    </div>
</div>
<div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
<div class="shadow"></div>
<?
$i = 0;
if (! empty($hours)) {
    foreach ($hours as $hour) {
        $i++;
        ($i % 2 == 0) ? $class = 'greyBg ' : $class = '';

        $timestamp   = strtotime($hour['date_hour']);
        $currentDate = date("d.m.Y H:i", $timestamp);

        echo "<div class='{$class}clear'>
                <div class='content'>
                    <div class='hourContent clear'>\n";

        echo "<h4 class='fontLogo'><span>#{$hour['id']}</span>{$hour['header']}</h4>
                        <p class='date'>{$currentDate}</p>";

        echo "<div class='hourText'>
                            <p>{$hour['text']}</p>
                        </div>\n";

        echo "<div class='hourInfo'>
                            <p><span>Имя:</span>{$hour['name_man']}</p>
                            <p><span>Телефон: </span>{$hour['tel']}</p>
                            <p><span>Email:</span>{$hour['email']}</p>
                            <p><span>Где работаем:</span>{$hour['location']}</p>
                        </div>\n";

        echo "</div>
                    <p class='warningHour'><span>Внимание!</span> Мастер не является аттестованным членом Федерации Профессиональных Строителей.
                    <br/> Администрация не несет ответственности за качество предоставляемых услуг мастеров в этом разделе. Аттестованные мастера находятся в разделе <a href='{$link}'>Мастера.</a></p>
                    <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
                </div>
            </div>";
    }
}
?>
<div class="greyBg clear">
    <div class="content sendEnter">
        <p>Желаете стать мастером <strong>Федерации Профессиональных Строителей?</strong> <br/>
            <a href="<?= Url::to(['/masters/enter']); ?>">Заполните заявку</a>, мы готовы обсудить этот вопрос.</p>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_01') ?>