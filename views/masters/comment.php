<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $name . ' - оставить отзыв';

$this->params['breadcrumbs'][] = ['label' => 'Мастера Федерации', 'url' => ['masters/all']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['/masters/person', 'id' => $id, 'name' => $name]];
$this->params['breadcrumbs'][] = 'Оставить отзыв';
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

        <? $form = ActiveForm::begin([
            'action' => Url::to(['/masters/comment', 'id' => $id, 'name' => $name])
        ]) ?>
        <div id="listSelect" class="listSelect">
            <?= $form->field($model, 'more', ['template' => "{label}{input}<div class='errorMessage'>{error}</div>"])
                ->label('Напишите Ваш отзыв здесь:', ['class' => 'labelAdd'])
                ->textarea(['name' => 'more']) ?>

            <?= $form->field($model, 'side', ['template' => "<div>{label}{input}</div>"])
                ->label('В целом, работой мастера Вы довольны?', ['class' => 'labelAdd'])
                ->radioList([
                    '1' => 'Да',
                    '0' => 'Нет'
                ]) ?>

            <?= $form->field($model, 'captcha')
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv">
                            <div class="captchaImg">{image}</div>
                            <div class="captchaInput">{input}</div>
                        </div>',
                ])
                ->label("Введите симовлы на картинке<em> (чтобы поменять изображение нажмите на него)</em>:",
                    ['class' => 'labelAdd']) ?>
        </div>
        <?= Html::submitButton('Отправить отзыв', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>