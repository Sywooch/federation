<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Выбор мастеров для отправки сообщения';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления мастерами', 'url' => ['/admin/masters/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this->registerCssFile("@web/js/data_tables/media/css/jquery.dataTables.css");
$this::registerJsFile('@web/js/data_tables/media/js/jquery.dataTables.js');
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
        fadeInContent('table');
        $('#tableOrdersToday').DataTable({
            "columns": [
                {
                    "width": "20px"
                },
                null,
                null,
                {
                    "orderable": false,
                    "width": "20px"
                }
            ],

            "order": [[1, 'asc']],
            "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Все"]],
            "pageLength": -1
        });
    });
</script>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>
        <div class="adminMastersList">
            <p>Отметьте мастеров, которым хотите отправить сообщение:</p>
            <? $form = ActiveForm::begin([
                'action' => Url::to(['/admin/masters/send-message-success'])
            ]); ?>

            <div class="labelPlusInput labelPlusTextarea">
                <?= $form->field($model, 'messageForMasters', ['template' => "{label}{input}"])
                    ->textarea(['name' => 'messageForMasters'])
                    ->label('Введите сообщение:', ['class' => 'labelSendMessage']) ?>
            </div>

            <div id="selectAll"><span>Отметить / снять всех</span></div>

            <table class="tableOrders hover order-column stripe hidden" id="tableOrdersToday">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя / Название организации</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?
                if (! empty($masters)) {
                    foreach ($masters as $master) {
                        if (! $master['id']) {
                            continue;
                        }
                        $link = Url::to(['masters/reduction', 'id' => $master['id']]);
                        echo "<tr>
                            <td>{$master['id']}</td>
                            <td>{$master['name']}</td>
                            <td>{$master['status']}</td>
                            <td><input type='checkbox' name='{$master['id']}'
                                        value='{$master['id']}' id='{$master['id']}'/></td>
                        </tr>";
                    }
                }
                ?>
                </tbody>
            </table>
            <?= Html::submitButton('Отправить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>

<script type="text/javascript">
    $(function () {
        var i = 1;
        $('div#selectAll span').click(function () {
            var checkBoxes = $("input[type='checkbox']");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        })
    });
</script>
