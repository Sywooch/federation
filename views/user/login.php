<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';

$this->params['breadcrumbs'][] = $this->title;

$templateTextField = "{label}{input}<div class='errorMessage'>{error}</div>";
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>
        <? $form = ActiveForm::begin([]); ?>

        <div id="listSelect" class="listSelect">
            <?= $form->field($model, 'username', ['template' => $templateTextField])
                ->label('Введите логин:', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'password', ['template' => $templateTextField])
                ->label('Пароль:', ['class' => 'labelAdd'])
                ->passwordInput() ?>

            <?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>",
            ])
                ->label('Запомнить меня')
                ->checkbox() ?>

            <?= Html::submitButton('Войти', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>