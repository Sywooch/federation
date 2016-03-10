<?
use yii\helpers\Url;

// prepare masters array
$arrMasters = [];
if (! empty($masters)) {
    foreach ($masters as $master) {
        $arrMasters[$master['id']] = $master['name'];
    }
}

// prepare statuses array
$arrStatuses = [];
if (! empty($statuses)) {
    foreach ($statuses as $status) {
        $arrStatuses[$status['id_status']] = $status['status_name'];
    }
}

$orderId = $order['id'] + 50000;
echo "<h2 class='fontLogo modifyHeader'>Подробности заказа <span>#{$orderId}</span></h2>
    <div class='modifyCloseButton'></div>
    <div class='modifyCloseButtonHover'></div>";
?>
<form action="<?= Url::to(['/admin/orders/modify-accept']) ?>" id="orderModify" role="form">
    <input name="selectValueName" type="hidden" id="hiddenName"/>
    <input name="selectValueType" type="hidden" id="hiddenType"/>
    <input name="id" type="hidden" id="hiddenType" value="<?= $order['id'] ?>"/>

    <div class="orderModifyRow">
        <label class="labelAdd marginTop" style="margin-top: 23px;">Услуга:</label>

        <div id="listSelect" style="margin-left: 100px;">
            <div id="currentValue" class="listSelectCurrentValue modifySelect">
                <strong>Ремонт квартиры под ключ</strong><span></span>
            </div>
            <div id="sub" class="sub subModify">
                <?
                if (! empty($servicesLevel)) {
                    foreach ($servicesLevel as $slKey => $slValue) {
                        echo "<span class='subSpan' id='{$slKey}'>{$slValue['level']}</span>\n";
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

        <label class="labelAdd marginTop" for="header">Заголовок:</label>
        <input type="text" class="form-control" id="header" name="Orders[header]" value="<?= $order['header'] ?>">

        <label class="labelAdd marginTop" for="clientName">Имя клиента:</label>
        <input type="text" class="form-control" id="clientName" name="Orders[clientName]"
               value="<?= $order['client_name'] ?>">

        <label class="labelAdd marginTop" for="location">Адрес:</label>
        <input type="text" class="form-control" id="location" name="Orders[location]"
               value="<?= $order['location'] ?>">

        <label class="labelAdd marginTop" for="start">Начало:</label>
        <input type="text" class="form-control" id="start" name="Orders[start]" value="<?= $order['start'] ?>">

        <label class="labelAdd marginTop" for="tel">Телефон:</label>
        <input type="text" class="form-control" id="tel" name="Orders[tel]" value="<?= $order['tel'] ?>">

        <label class="labelAdd marginTop" for="email">Email:</label>
        <input type="text" class="form-control" id="email" name="Orders[email]" value="<?= $order['email'] ?>">

        <div class="linkFileDiv">
            <?
            for ($i = 1; $i <= 5; $i++) {
                ($i == 1) ? $j = '' : $j = $i;
                if (! is_null($order['file' . $j])) {
                    $link = Yii::$app->params['pathToRoot'] . '/' . $order['file' . $j];
                    echo "<a class='linkFile' href='{$link}' target='_blank'>Файл {$i}</a>";
                }
            }
            ?>
        </div>
    </div>

    <div class="orderModifyRow">
        <textarea class="form-control" name="more"><?= $order['text_order'] ?></textarea>

        <label class="labelAdd labelBig" for="masterResponsible">Выполняет мастер:</label>
        <select class="form-control" id="masterResponsible" name="Orders[masterResponsible]">
            <?
            if (! empty($masters)) {
                foreach ($masters as $master) {
                    ($master['id'] == $order['master_responsible']) ? $selected = ' selected' : $selected = '';
                    echo "<option value='{$master['id']}'{$selected}>{$master['name']}</option>";
                }
            }
            ?>
        </select>

        <label class="labelAdd labelBig" for="statuses">Статус заказа:</label>
        <select class="form-control" id="statuses" name="Orders[statuses]">
            <?
            if (! empty($statuses)) {
                foreach ($statuses as $status) {
                    ($status['id_status'] == $order['id_status']) ? $selected = ' selected' : $selected = '';
                    echo "<option value='{$status['id_status']}'{$selected}>{$status['status_name']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <button type="submit" class="youNeedButtonAdd fontLogo">Применить</button>

    <div class="learnShowModify youNeedButtonAdd fontLogo" id="learnShowModify">
        <span>Редактировать</span>
    </div>

    <div id="errorMsgOrders"><span></span></div>

    <div class="learnDeleteLink">
        <a href="<?= Url::to(['/admin/orders/modify-order-delete', 'id' => $order['id']]) ?>">Удалить этот заказ</a>
    </div>
</form>

<script type="text/javascript">
    var arrIndex;
    var currentValueName = '<?= $order['services_id'] ?>';
    var currentValueType = '<?= $order['type_services_label'] ?>';
    var currentValueSubContent;

    <? $js_array = json_encode($servicesLevel); echo "arrIndex = ". $js_array . ";\n"; ?>

    servicesLevelDropdown(arrIndex);
    setInnerDataAsCurrent(currentValueSubContent, currentValueName, currentValueType);

    // show or modify
    $(function () {
        var inputText = $("form#orderModify input[type='text']"),
            inputSelect = $("form#orderModify select"),
            inputTextarea = $("form#orderModify textarea"),
            divCurrentVal = $('div#currentValue'),
            buttonSubmit = $('button.youNeedButtonAdd'),
            errorMsg = $('div#errorMsgOrders span');

        inputText.addClass('blockInput');
        inputText.attr('readonly', 'readonly');
        inputSelect.addClass('blockInput');
        inputSelect.attr('disabled', 'true');
        inputTextarea.addClass('blockInput');
        inputTextarea.attr('readonly', 'readonly');
        divCurrentVal.addClass('blockInput');
        buttonSubmit.hide();
        $('div.learnDeleteLink').hide();

        $('div#learnShowModify').click(function () {
            inputText.removeClass('blockInput');
            inputText.removeAttr('readonly');
            inputSelect.removeClass('blockInput');
            inputSelect.removeAttr('disabled');
            inputTextarea.removeClass('blockInput');
            inputTextarea.removeAttr('readonly');
            divCurrentVal.removeClass('blockInput');
            $('div.overlay div.overlayContent').css({
                background: '#f7f7f5'
            });
            buttonSubmit.fadeIn(400);
            $('div.learnDeleteLink').fadeIn(400);
            $(this).fadeOut(400);
        });

        //check strlen
        function checkLength(selector, len, label) {
            if (selector.val() && selector.val().length > len) {
                var errorMsg = 'Слишком много символов в поле: "' + label + '". Максимум можно ' + len;

                buttonSubmit.attr('disabled', true).addClass('buttonDisabled');
                errorMsg.text(errorMsg);
                return 1;
            }
        }

        $(window).on('click mousemove keyup', function () {
            var wasBlock = 0;

            var arr = [
                [
                    $("textarea[name='more']"),
                    5000,
                    'Описание заказа'],
                [
                    $("input[name='Orders[header]']"),
                    500,
                    'Заголовок'],
                [
                    $("input[name='Orders[clientName]']"),
                    100,
                    'Имя клиента'],
                [
                    $("input[name='Orders[location]']"),
                    200,
                    'Адрес'],
                [
                    $("input[name='Orders[start]']"),
                    100,
                    'Начало'],
                [
                    $("input[name='Orders[tel]']"),
                    50,
                    'Телефон'],
                [
                    $("input[name='Orders[email]']"),
                    50,
                    'Email']
            ];

            for (var i in arr) {
                if (!wasBlock) wasBlock = checkLength(arr[i][0], arr[i][1], arr[i][2]);
            }

            if (!wasBlock) {
                buttonSubmit.removeAttr('disabled').removeClass('buttonDisabled');
                errorMsg.text('');
            }
        });
    });
</script>
