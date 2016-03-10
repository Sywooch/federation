<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавить/Редактировать статью';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления статьями', 'url' => ['/admin/information/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
$this::registerJsFile("@web/js/nic_edit/nicEdit.js", ['position' => $this::POS_HEAD]);
$this::registerJsFile("@web/modules/admin/js/informationAddImg.js");

$countImg = 20;

$templateInputField = "{label}{input}<div class='errorMessage'>{error}</div>";
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<script type="text/javascript">
    bkLib.onDomLoaded(function () {
        nicEditors.allTextAreas()
    });
</script>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>
        <? $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'target'  => '_blank'
            ]
        ]) ?>
        <div id="listSelect" class="listSelect createInformation">

            <?= $form->field($model, 'title', ['template' => $templateInputField])
                ->label('Заголовок:', ['class' => 'labelAdd']) ?>

            <p class="instruction">
                Картинки вставляем с помощью символов<br/>
                <strong>:::1</strong><br/>
                по порядку. После, обязательно ставим выравнивание<br/>
                <strong>l</strong> left - слева, <br/>
                <strong>r</strong> right - справа,<br/>
                <strong>c</strong> center - по центру<br/>
                Пример: Нужно вставить первую картинку по центру: пишем <strong>:::1c</strong><br/>
                Нужно вставить вторую загружаемую картинку слева в тексте: <strong>:::2l</strong><br/>
                Нужно вставить третью загружаемую картинку справа в тексте: <strong>:::3r</strong>
            </p>

            <?= $form->field($model, 'short', ['template' => $templateInputField])
                ->label('Короткое описание:', ['class' => 'labelAdd'])
                ->textarea(['name' => 'short']) ?>

            <?= $form->field($model, 'full', ['template' => $templateInputField])
                ->label('Полное описание:', ['class' => 'labelAdd'])
                ->textarea(['name' => 'full']) ?>

            <?
            // if it's reduction mode
            if (! empty($currentInform)) {
                echo "<div class='imgBefore'><p class='imgBeforeHeader'>Ранее использовались следующие картинки:</p>";
                $pathToRoot = Yii::$app->params['pathToRoot'];
                for ($j = 0; $j <= $countImg; $j++) {
                    if ($j == 0) {
                        $i      = '';
                        $forWho = 'превью';
                    } else {
                        $i      = $j;
                        $forWho = ':::';
                    }
                    if ($currentInform['file' . $i]) {
                        $link = $pathToRoot . '/' . $currentInform['file' . $i];
                        echo "<div><span>Для <strong>{$forWho}{$i}</strong> был файл: <a href='{$link}'
                            target='_blank'>--Ссылка--</a></span>
                        <input type='checkbox' name='deletePhoto{$i}' id='deletePhoto{$i}'/>
                        <label for='deletePhoto{$i}'>Удалить</label></div>";
                    }
                }
                echo "<p>Вы можете либо удалить их,  если не хотите учитывать, отметив чекбокс \"Удалить\",<br/>
                    либо просто переназначить, при этом отмечать галочкой \"Удалить\" не обязательно. <br/>
                    Если хотите сохранить ранее добавленную картинку, не переназначайте ее
                    и не отмечайте галочкой \"Удалить\".</p></div>
                <p class='imgBeforeHeader'>Переназначить фото можно ниже:</p>";
            }
            ?>
            <?= $form->field($model, 'file',
                ['template' => $templateInputField])
                ->label('Превью 220x136px:', ['class' => 'forFile'])
                ->fileInput() ?>
            <?
            echo "<div id='allFiles'>";
            for ($i = 1; $i <= $countImg; $i++) {
                echo $form->field($model, 'file' . $i, ['template' => $templateInputField])
                    ->label("<span>:::{$i}</span>", ['class' => 'forFile'])
                    ->fileInput();
            }
            echo "</div>\n";
            echo "<div class='showHideFullList' id='showAllFiles'>Показать все файлы</div>";
            echo "<div class='showHideFullList'  id='hideAllFiles'>Свернуть все файлы</div>";
            ?>

            <?= $form->field($model, 'mode', ['template' => $templateInputField])
                ->label("После нажатия кнопки Вы хотите:", ['class' => 'labelAdd labelAddHeader'])
                ->radioList([
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
