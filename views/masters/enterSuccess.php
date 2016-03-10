<?php
use yii\helpers\Url;

$this->title = 'Ваша заявка успешно отправлена';

$this->params['breadcrumbs'][] = ['label' => 'Заявка на вступление в Федерацию', 'url' => ['/masters/enter']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1>Спасибо!</h1></div>
        <div class="addSuccessImg"></div>
        <div class="aboutText" id="success">

            <p class="addSuccess">Ваша заявка успешно отправлена!</p>

            <p>В ближайшее время мы с Вами свяжемся. <br/>
                А пока, можете посмотреть интересный материал в разделе:</p>

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