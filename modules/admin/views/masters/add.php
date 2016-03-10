<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавление нового мастера';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления мастерами', 'url' => ['/admin/masters/index']];
$this->params['breadcrumbs'][] = $this->title;

$this::registerJsFile('@web/js/core_boxgallery.js');
$this::registerCssFile('@web/css/core.css');
$this::registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this::registerJsFile("@web/modules/" . $this->context->module->id . "/js/mastersReduction.js");

$templateInputField = "{label}{input}<div class='errorMessage errorMessageCenter'>{error}</div>";
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

        <? $form = ActiveForm::begin([
            'action'  => Url::to(['masters/add-success']),
            'options' => ['enctype' => 'multipart/form-data', 'target' => '_blank'],
        ]); ?>

        <div class="labelPlusInput" style="margin-top: 40px;">
            <?= $form->field($model, 'name', ['template' => $templateInputField])
                ->label('Имя мастера/организации:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'city', ['template' => $templateInputField])
                ->label('Удобное место работы:', ['class' => 'labelMasterReduction']) ?>
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
                ->label('Адрес регистрации:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput labelPlusTextarea">
            <?= $form->field($model, 'history_short', ['template' => $templateInputField])
                ->label('Краткий текст о мастере:', ['class' => 'labelMasterReduction'])
                ->textarea(['name' => 'history_short']) ?>
        </div>

        <div class="labelPlusInput labelPlusTextarea">
            <?= $form->field($model, 'history', ['template' => $templateInputField])
                ->label('Полный текст о мастере:', ['class' => 'labelMasterReduction'])
                ->textarea(['name' => 'history']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'expirience', ['template' => $templateInputField])
                ->label('<em>(укажите цифру, в годах)</em> Опыт:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'friends', ['template' => $templateInputField])
                ->label('<em>(например 5-10)</em> Бригада:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'status', ['template' => $templateInputField])
                ->label('<em>(Частное лицо, строительная компания...)</em> Статус:',
                    ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'age', ['template' => $templateInputField])
                ->label('<em>(Формат: dd.mm.yyyy, например: 12.05.1957)</em> Возраст:',
                    ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class="labelPlusInput">
            <?= $form->field($model, 'money', ['template' => $templateInputField])
                ->label('<em>(наличные, безнал)</em> Валюта:', ['class' => 'labelMasterReduction']) ?>
        </div>

        <div class='line' style="margin-top: 40px;"></div>
        <h4 class="secondHeader fontLogo">Аватар</h4>

        <div class='avatarMaster clear'>
            <div class="addAvatar">
                <?= $form->field($model, 'avatar', ['template' => $templateInputField])
                    ->fileInput()
                    ->label('Добавить фото (100x100px)') ?>
            </div>
        </div>

        <div class='line'><img src='<?= Yii::$app->params['pathToRoot'] ?>/img/line.png' alt=''></div>
        <div class='labelPlusCheckboxContainer'>
            <h4 class="secondHeader fontLogo">Услуги</h4>
            <?
            $tempTypeServices = '';
            if (! empty($services)) {
                foreach ($services as $service) {
                    if ($service['name'] != $tempTypeServices) {
                        echo "<p class='typeServicesHeader'>{$service['name']}</p>";
                        $tempTypeServices = $service['name'];
                    }

                    echo "<div class='labelPlusCheckbox'><input type='checkbox' name='services[{$service['id']}]'
                        value='{$service['id']}' id='{$service['id']}'/>
                    <label class='checkbox' for='{$service['id']}'>{$service['name_services']}</label></div>\n";
                }
            }
            ?>
        </div>
        <div id="showFullList" class="showHideFullList">--- Развернуть весь список услуг ---</div>
        <div id="hideFullList" class="showHideFullList">--- Свернуть список услуг ---</div>

        <h4 class="secondHeader fontLogo">Добавить фото работ</h4>

        <div class="addFotosDiv">
            <p>Размер фото 800x533px</p>
            <?
            for ($i = 1; $i <= 5; $i++) {
                echo $form->field($model, 'file' . $i, ['template' => "{input}"])
                    ->fileInput();
            }
            ?>
        </div>
        <div id="errorMsg"><span></span></div>
        <?= Html::submitButton('Применить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('//layouts/readInformation_02') ?>
