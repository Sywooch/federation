<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление нового объявления';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления раздела Муж на час', 'url' => ['/admin/hour/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");

$templateInputField = "{label}{input}<div class='errorMessage errorMessageCenter'>{error}</div>";
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1>Добавление нового объявления в раздел Муж на час</h1></div>

        <?
        if ($errorMsg) {
            echo "<div class='errorMsg'>{$errorMsg}</div>";
        }
        ?>

        <? $form = ActiveForm::begin([
            'action'  => Url::to(['hour/add']),
            'options' => ['target' => '_blank'],
        ]); ?>

        <div class="labelPlusInput" style="margin-top: 30px;">
            <?= $form->field($model, 'header', ['template' => $templateInputField])
                ->label('Заголовок:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput labelPlusTextarea">
            <?= $form->field($model, 'text', ['template' => $templateInputField])
                ->textarea(['name' => 'text'])
                ->label('Текст объявления:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput" style="margin-top: 40px;">
            <?= $form->field($model, 'name', ['template' => $templateInputField])
                ->label('Имя мастера:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'tel', ['template' => $templateInputField])
                ->label('Телефон:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'email', ['template' => $templateInputField])
                ->label('Email:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'location', ['template' => $templateInputField])
                ->label('Адрес:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <?= Html::submitButton('Добавить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>