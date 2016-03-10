<?php
use yii\helpers\Url;

$this->title = $name . ' - Отзыв успешно отправлен';

$this->params['breadcrumbs'][] = ['label' => 'Мастера Федерации', 'url' => ['/masters/all']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['/masters/person', 'id' => $id, 'name' => $name]];
$this->params['breadcrumbs'][] =
    ['label' => 'Оставить отзыв', 'url' => ['/masters/comment', 'id' => $id, 'name' => $name]];
$this->params['breadcrumbs'][] = 'Отзыв успешно отправлен';
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1>Спасибо!</h1></div>
        <div class="addSuccessImg"></div>
        <div class="aboutText" id="success">
            <p class="addSuccess">Отзыв о мастере отправлен успешно!</p>
            <p>В ближайшее время мы ознакомимся с Вашим отзывом. <br/> Нам очень важно Ваше мнение. </p>
            <p>Посмотреть Ваш отзыв можно на странице мастера, он уже добавлен:</p>
            <p><a class="fontLogo" href="<?= Url::to(['/masters/person', 'id' => $id, 'name' => $name]) ?>">Ваш
                    отзыв</a></p>
            <p>Вернуться на главную можно по ссылке ниже:</p>
            <p><a class="fontLogo" href="<?= Url::to(['/site/index']) ?>">Главная</a></p>
            <p><strong>Хорошего Вам дня!</strong></p>
        </div>
    </div>
</div>
<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>