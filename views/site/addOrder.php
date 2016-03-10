<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление заказа';

$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/add.js');
$this::registerJsFile('@web/js/service_level_dropdown.js', ['position' => $this::POS_HEAD]);

if (Yii::$app->user->isGuest) {
    $defaultName =
    $defaultEmail = '';
    $readonly    = false;
} else {
    $defaultName  = Yii::$app->user->identity->fio;
    $defaultEmail = Yii::$app->user->identity->email;
    $readonly     = 'readonly';
}

$templateTextField    = "{label}{input}<div class='errorMessage'>{error}</div>";
$templateWithoutLabel = "{input}<div class='errorMessage'>{error}</div>";
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<script type="text/javascript">
    //showSelects();
</script>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

        <? $form = ActiveForm::begin([
            'action'  => Url::to(['/site/add-success']),
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <div id="listSelect" class="listSelect">
            <div class="listSelectIndex">
                <input name="selectValueName" type="hidden" id="hiddenName"/>
                <input name="selectValueType" type="hidden" id="hiddenType"/>
                <label class="labelAdd">Вид работ:</label>

                <div id="currentValue" class="listSelectCurrentValue listSelectCurrentValueAdd clear">
                    <strong>Ремонт квартиры под ключ</strong><span></span>
                </div>
                <div id="sub" class="subAdd">
                    <?
                    if (! empty($servicesLevel)) {
                        $i = 1;
                        foreach ($servicesLevel as $slKey => $slValue) {
                            echo "<span class='subSpan' id='{$slKey}' data-margin='{$i}'>{$slValue['level']}</span>";
                            $i++;
                        }
                    }
                    ?>
                </div>

                <div id="subCurrentContent" class="subCurrentContentAdd">
                    <?
                    if (! empty($servicesLevel)) {
                        foreach ($servicesLevel as $slKey => $slValue) {
                            echo "<div class='subCurrent' id='{$slKey}'>";
                            if (! empty($slValue)) {
                                foreach ($slValue['services'] as $servicesKeyCurrent => $servicesValueCurrent) {
                                    echo "<span data-value='{$servicesKeyCurrent}'>{$servicesValueCurrent}</span>";
                                }
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <?= $form->field($model, 'header', ['template' => $templateTextField])
                ->label('Заголовок: <em>(Кратко, например "Нужен ремонт фасада")</em>',
                    ['class' => 'labelAdd marginTop']) ?>

            <?= $form->field($model, 'more', ['template' => $templateTextField])
                ->label('Укажите подробную информацию о Вашем заказе:', ['class' => 'labelAdd'])
                ->textarea(['name' => 'more']) ?>

            <?= $form->field($model, 'file', ['template' => $templateTextField])
                ->label('Прикрепить файлы (если нужно):')
                ->fileInput() ?>

            <?= $form->field($model, 'file2', ['template' => $templateWithoutLabel])
                ->fileInput() ?>

            <?= $form->field($model, 'file3', ['template' => $templateWithoutLabel])
                ->fileInput() ?>

            <?= $form->field($model, 'file4', ['template' => $templateWithoutLabel])
                ->fileInput() ?>

            <?= $form->field($model, 'file5', ['template' => $templateWithoutLabel])
                ->fileInput() ?>

            <a class="addInputFile">Еще файл</a>

            <?= $form->field($model, 'dateToStartWorking', ['template' => $templateTextField])
                ->label('Когда можно приступить к работе:', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'location', ['template' => $templateTextField])
                ->label('Адрес:', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'clientName', ['template' => $templateTextField])
                ->label('Представьтесь, пожалуйста:', ['class' => 'labelAdd'])
                ->textInput(['value' => $defaultName, 'readonly' => $readonly]) ?>

            <?= $form->field($model, 'clientTel', ['template' => $templateTextField])
                ->label('Контактный телефон:', ['class' => 'labelAdd']) ?>

            <?= $form->field($model, 'clientEmail', ['template' => $templateTextField])
                ->label('Ваш E-mail (электронная почта):', ['class' => 'labelAdd'])
                ->textInput(['value' => $defaultEmail, 'readonly' => $readonly]) ?>

            <?= $form->field($model, 'captcha')
                ->label('Введите симовлы на картинке<em>(чтобы поменять изображение нажмите на него)</em>:',
                    ['class' => 'labelAdd'])
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv"><div class="captchaImg">{image}</div>
                            <div class="captchaInput">{input}</div>
                        </div>',
                ]) ?>
        </div>

        <?= Html::submitButton('Отправить заказ', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>

<script type="text/javascript">
    var arrIndex;
    <? $js_array = json_encode($servicesLevel); echo "arrIndex = ". $js_array . ";\n"; ?>

    var currentValueSubContent = 'Строительство зданий и сооружений';
    var currentValueName = '1';
    var currentValueType = 'complex_work';
    <?
    if ($post['selectValueName'])
        {echo "currentValueName = '". $post['selectValueName'] . "';\n";}
    if ($post['selectValueType'])
        {echo "currentValueType = '". $post['selectValueType'] . "';\n";}
    ?>

    servicesLevelDropdown(arrIndex);
    setInnerDataAsCurrent(currentValueSubContent, currentValueName, currentValueType);
    mediaServicesLevelMenu();
</script>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>
