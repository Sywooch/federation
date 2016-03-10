<?php
use yii\helpers\Url;

$this->title = 'Заказ успешно отправлен';

$this->params['breadcrumbs'][] = ['label' => 'Добавление заказа', 'url' => ['site/add']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1>Поздравляем!</h1></div>
            <div class="addSuccessImg"></div>
            <div class="aboutText" id="success">
                <p class="addSuccess">Заказ успешно отправлен!</p>

                <p>Ожидайте звонка менеджера для подтверждения заказа. Обычно, это занимает 15-20 минут. За это время,
                    предлагаем Вам ознакомиться с нашими полезными материалами в разделе:</p>

                <p><a class="fontLogo" href="<?= Url::to(['/information/index']) ?>">Информация</a></p>

                <p>Вернуться на главную можно по ссылке ниже:</p>

                <p><a class="fontLogo" href="<?= Url::to(['/site/index']) ?>">Главная</a></p>

                <p><strong>Хорошего Вам дня!</strong></p>
            </div>
        </div>
    </div>
    <div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>

