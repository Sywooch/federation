<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавить статью';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления статьями', 'url' => ['/admin/admin/information-index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this::registerJsFile ("@web/js/nic_edit/nicEdit.js", ['position' => $this::POS_HEAD]);

?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

<script type="text/javascript">
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?=$this->title ?></h1></div>

        <? $form = ActiveForm::begin([
            'options' => [
                'enctype'=>'multipart/form-data',
                'target'  => '_blank'
            ],

        ]);?>
        <div id="listSelect" class="listSelect createInformation">

            <label class="labelAdd" for="AdminInformation[title]">Заголовок:</label>
            <?= $form->field($model, 'title', ['template' => "{input}<div class='errorMessage'>{error}</div>"]) ?>

            <p style="color: #7c7a7a; margin-left: 10px;">
                Вставляем любые html теги. <br/>
                Картинки вставляем с помощью символов<br/>
                <strong style="font-size: 24px;">:::1</strong><br/>
                по порядку. После них ставим выравнивание<br/>
                <strong style="font-size: 24px;">l, r, c</strong> (слева, справа, по центру) <br/>
                Пример: Нужно вставить первую картинку поцентру: пишем <strong style="font-size: 24px;">:::1c</strong><br/>
                Нужно вставить вторую загружаемую картинку слева в тексте: <strong style="font-size: 24px;">:::2l</strong><br/>
                Нужно вставить третью загружаемую картинку справа в тексте: <strong style="font-size: 24px;">:::3r</strong>
            </p>

            <label class="labelAdd" for="short">Короткое описание:</label>
            <?= $form->field($model, 'short', ['template' => "{input}"])->textarea(['name'=>'short']) ?>

            <label class="labelAdd" for="full">Полное описание:</label>
            <?= $form->field($model, 'full', ['template' => "{input}"])->textarea(['name'=>'full']) ?>

            <?= $form->field($model, 'file', ['template' => "<label class='forFile' for=\"AdminInformation[file]\">Превью 220x136px: </label>{input}"])->fileInput() ?>

            <?= $form->field($model, 'file1', ['template' => "<label class='forFile' for=\"AdminInformation[file1]\"><span>:::1</span> Первая: </label>{input}"])->fileInput() ?>

            <?= $form->field($model, 'file2', ['template' => "<label class='forFile' for=\"AdminInformation[file2]\"><span>:::2</span> Вторая: </label>{input}"])->fileInput() ?>

            <?= $form->field($model, 'file3', ['template' => "<label class='forFile' for=\"AdminInformation[file3]\"><span>:::3</span> Третья: </label>{input}"])->fileInput() ?>

            <?= $form->field($model, 'file4', ['template' => "<label class='forFile' for=\"AdminInformation[file4]\"><span>:::4</span> Червертая: </label>{input}"])->fileInput() ?>

            <?= $form->field($model, 'file5', ['template' => "<label class='forFile' for=\"AdminInformation[file5]\"><span>:::5</span> Пятая: </label>{input}"])->fileInput() ?>

            <label class="labelAdd" for="mode">После нажатия кнопки Вы хотите:</label>

            <?= $form->field($model, 'mode', [
                'template' => "<div>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->radioList([
                '1' => 'Предварительно посмотреть что получается',
                '2' => 'Добавить в базу данных статью'
            ]) ?>
        </div>
        <div id="errorMsg"><span></span></div>
        <?= Html::submitButton('Добавить статью', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('//layouts/readInformation_02') ?>