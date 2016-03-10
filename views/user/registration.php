<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация нового пользователя';

$this->params['breadcrumbs'][] = $this->title;

$templateTextField = "{label}{input}<div class='errorMessage'>{error}</div>";
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>
        <div id="listSelect" class="listSelect">
            <? $form = ActiveForm::begin([]); ?>
            <?= $form->field($model, 'username', ['template' => $templateTextField])
                ->label('Введите логин <em>(должен быть уникальным, будет использоваться для входа):</em>',
                    ['class' => 'labelAdd']) ?>
            <?
            if ($errorMsg) {
                echo "<div style='margin: 20px 0 0 20px; color: #b32020;'>{$errorMsg}</div>";
            }
            ?>

            <?= $form->field($model, 'fio', ['template' => $templateTextField])
                ->label('Ваше имя (публикуется):', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'email', ['template' => $templateTextField])
                ->label('Ваш E-mail (электронная почта):', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'password', ['template' => $templateTextField])
                ->label('Пароль:', ['class' => 'labelAdd'])
                ->passwordInput() ?>

            <?= $form->field($model, 'confirm', ['template' => $templateTextField])
                ->label('Повторите пароль:', ['class' => 'labelAdd'])
                ->passwordInput() ?>

            <?= $form->field($model, 'captcha')
                ->label('Введите симовлы на картинке<em>(чтобы поменять изображение нажмите на него)</em>:',
                    ['class' => 'labelAdd'])
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv"><div class="captchaImg">{image}</div>
                        <div class="captchaInput">{input}</div></div>',
                ]) ?>

            <?= Html::submitButton('Регистрация', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>
