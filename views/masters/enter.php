<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заявка на вступление в Федерацию';

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
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo" style="margin-bottom: 30px;"><h1><?= $this->title ?></h1></div>
        <? $form = ActiveForm::begin(); ?>
        <div id="listSelect" class="listSelect">
            <label class="labelAdd" for="Masters[clientName]">Представьтесь, пожалуйста:</label>
            <?= $form->field($model, 'clientName', ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textInput(['value' => $defaultName, 'readonly' => $readonly]) ?>

            <label class="labelAdd" for="Masters[clientTel]">Телефон:</label>
            <?= $form->field($model, 'clientTel', ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textInput() ?>

            <label class="labelAdd" for="Masters[clientEmail]">Ваш E-mail (электронная почта):</label>
            <?= $form->field($model, 'clientEmail',
                ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textInput(['value' => $defaultEmail, 'readonly' => $readonly]) ?>

            <label class="labelAdd" for="more">Расскажите о себе, своем опыте и профессиональной области:</label>
            <?= $form->field($model, 'more', ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textarea(['name' => 'more']) ?>

            <label class="labelAdd" for="Masters[captcha]">Введите симовлы на картинке <em>(чтобы поменять
                    изображение нажмите на него)</em>:</label>
            <?= $form->field($model, 'captcha')
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv">
                            <div class="captchaImg">{image}</div>
                            <div class="captchaInput">{input}</div>
                        </div>',
                ])
                ->label(false) ?>
        </div>
        <?= Html::submitButton('Отправить заявку', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>