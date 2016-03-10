<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Оставить отзыв';

$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->isGuest) {
    $defaultName =
    $defaultEmail = '';
    $readonly    = false;
} else {
    $defaultName  = Yii::$app->user->identity->fio;
    $defaultEmail = Yii::$app->user->identity->email;
    $readonly     = 'readonly';
}

$templateTextField = "{label}{input}<div class='errorMessage'>{error}</div>";
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

        <? $form = ActiveForm::begin([
            'action' => Url::to(['/site/send-comment'])
        ]); ?>
        <div id="listSelect" class="listSelect">
            <?= $form->field($model, 'about', ['template' => "{label}{input}"])
                ->label('О чем Ваш отзыв:', ['class' => 'labelAdd'])
                ->dropDownList([
                    'about_company' => 'О Федерации',
                    'about_work'    => 'О заказе',
                    'about_masters' => 'О мастерах',
                    'about_other'   => 'Другая тема...'
                ]) ?>

            <?= $form->field($model, 'more', ['template' => $templateTextField])
                ->label('Напишите Ваш отзыв здесь:', ['class' => 'labelAdd'])
                ->textarea(['name' => 'more']) ?>

            <?= $form->field($model, 'clientName', ['template' => $templateTextField])
                ->label('Представьтесь, пожалуйста:', ['class' => 'labelAdd'])
                ->textInput(['value' => $defaultName, 'readonly' => $readonly]) ?>

            <?= $form->field($model, 'clientEmail', ['template' => $templateTextField])
                ->label('Ваш E-mail (электронная почта):', ['class' => 'labelAdd'])
                ->textInput(['value' => $defaultEmail, 'readonly' => $readonly]) ?>

            <?= $form->field($model, 'captcha')
                ->label('Введите симовлы на картинке<em>(чтобы поменять изображение нажмите на него)</em>:',
                    ['class' => 'labelAdd'])
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv"><div class="captchaImg">{image}</div>
                        <div class="captchaInput">{input}</div></div>',
                ]) ?>
        </div>

        <?= Html::submitButton('Отправить отзыв', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>
