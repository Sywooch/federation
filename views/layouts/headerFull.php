<?
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="content">
    <div class="slogan fontLogo">
        <h1>Лучшие мастера<br/>
            <span>по строительству, ремонту и всем сопутствующим работам</span></h1>
    </div>
</div>
<div class="builder">
    <div class="builderHeadHead"></div>
    <div class="builderHeadBody"></div>
</div>
<div class="headerAdd">
    <div class="content">
        <div class="youNeed fontLogo"></div>
        <? $form = ActiveForm::begin(['action' => Url::to(['/site/add'])]); ?>
        <input name="selectValueName" type="hidden" id="hiddenName"/>
        <input name="selectValueType" type="hidden" id="hiddenType"/>

        <div id="listSelect" class="listSelectIndex">
            <div id="currentValue" class="listSelectCurrentValue clear">
                <strong>Строительство зданий и сооружений</strong><span></span>
            </div>
            <div id="sub" class="sub">
                <?
                if (! empty($servicesLevel)) {
                    $i = 1;
                    foreach ($servicesLevel as $slKey => $slValue) {
                        echo "<span class='subSpan' id='{$slKey}' data-margin='{$i}'>{$slValue['level']}</span>\n";
                        $i++;
                    }
                }
                ?>
            </div>

            <div id="subCurrentContent" class="subCurrentContent">
                <?
                if (! empty($servicesLevel)) {
                    foreach ($servicesLevel as $slKey => $slValue) {
                        echo "<div class='subCurrent' id='{$slKey}'>";
                        if (! empty($slValue)) {
                            foreach ($slValue['services'] as $servicesKeyCurrent => $servicesValueCurrent) {
                                echo "<span data-value='{$servicesKeyCurrent}'>{$servicesValueCurrent}</span>\n";
                            }
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <?= Html::submitButton('Добавить заказ', ['class' => 'youNeedButton fontLogo']); ?>
        <? ActiveForm::end(); ?>
        <div class="buttonAddHover"></div>
    </div>
</div>