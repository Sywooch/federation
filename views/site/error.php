<?php
$this->title = $name;

$this->params['breadcrumbs'][] = 'Ошибка: ' . $name;
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content" style="text-align: center; color: crimson; height: 500px;">
        <div class="aboutHead fontLogo" style="padding-top: 150px;"><h1>
                Ошибка...</h1><? //= Html::encode($this->title) ?></div>
        <p style="margin-top: 70px;">Если Вы ожидали другой результат, свяжитесь с администрацией сайта</p>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>