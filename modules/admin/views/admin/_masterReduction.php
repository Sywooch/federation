<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $master['name'] . ' - Редактирование';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления мастерами', 'url' => ['/admin/admin/masters-index']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор мастера для редактирования', 'url' => ['/admin/admin/masters']];
$this->params['breadcrumbs'][] = $this->title;

$this::registerJsFile ('@web/js/core_boxgallery.js');
$this::registerCssFile ('@web/css/core.css');
$this::registerJsFile ("@web/modules/" . $this->context->module->id . "/js/mastersReduction.js");
$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");

$model->name            = $master['name'];
$model->city            = $master['city'];
$model->tel             = $master['tel'];
$model->email           = $master['email'];
$model->location        = $master['location'];
$model->history_short   = htmlspecialchars_decode($master['history_short']);
$model->history         = htmlspecialchars_decode($master['history']);
$model->expirience      = $master['expirience'];
$model->friends         = $master['friends'];
$model->status          = $master['status'];
$model->age             = $master['age'];
$model->money           = $master['money'];

?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?=$master['name'] ?> - Редактирование</h1></div>

        <? $form = ActiveForm::begin([
            'action' => Url::to(['admin/master-reduction-success']),
            'options'=>['enctype'=>'multipart/form-data'],
        ]);?>

        <input name="id" type="hidden" id="idMaster" value="<?=$master['id'] ?>"/>

        <div class="labelPlusInput" style="margin-top: 40px;">
            <label class="labelMasterReduction" for="AdminMasters[name]">Имя мастера/организации:</label>
            <?= $form->field($model, 'name', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[city]">Удобное место работы:</label>
            <?= $form->field($model, 'city', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[tel]">Телефон:</label>
            <?= $form->field($model, 'tel', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[email]">Email:</label>
            <?= $form->field($model, 'email', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[location]">Адрес регистрации:</label>
            <?= $form->field($model, 'location', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput labelPlusTextarea">
            <label class="labelMasterReduction" for="history_short">Краткий текст о мастере:</label>
            <?= $form->field($model, 'history_short', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"])->textarea(['name'=>'history_short']) ?>
        </div>

        <div class="labelPlusInput labelPlusTextarea">
            <label class="labelMasterReduction" for="history">Полный текст о мастере:</label>
            <?= $form->field($model, 'history', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"])->textarea(['name'=>'history']) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[expirience]"><em>(укажите цифру, в годах)</em> Опыт:</label>
            <?= $form->field($model, 'expirience', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[friends]"><em>(например 5-10)</em> Бригада:</label>
            <?= $form->field($model, 'friends', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[status]"><em>(Частное лицо, строительная компания...)</em> Статус:</label>
            <?= $form->field($model, 'status', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[age]"><em>(Формат: dd.mm.yyyy, например: 12.05.1957)</em> Возраст:</label>
            <?= $form->field($model, 'age', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class="labelPlusInput">
            <label class="labelMasterReduction" for="AdminMasters[money]"><em>(наличные, безнал)</em> Валюта:</label>
            <?= $form->field($model, 'money', ['template' => "{input}<div class='errorMessage errorMessageCenter'>{error}</div>"]) ?>
        </div>

        <div class='line' style="margin-top: 40px;"></div>
        <h4 class="secondHeader fontLogo">Аватар</h4>
        <div class='avatarMaster clear'>
            <?="<img src='{$pathToRoot}/{$master['avatar']}' alt='{$master['name']}' title='Мастер Федерации: {$master['name']}'/>"?>
            <div class="addAvatar">
                <?= $form->field($model, 'avatar', ['template' => "<label for=\"AdminMasters[avatar]\">Заменить</label><br/>{input}"])
                        ->fileInput() ?>
            </div>
            <input name="avatarPrevious" type="hidden" id="hiddenName" value="<?=$master['avatar'] ?>"/>
        </div>

        <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
        <div class='labelPlusCheckboxContainer'>
            <h4 class="secondHeader fontLogo">Услуги</h4>
            <?
            $tempTypeServices = '';
            foreach ($services as $service) {
                if (!empty($masterServices)) {
                    foreach ($masterServices as $ms) {
                        if ($service['id'] == $ms['id_service']) {
                            $select = ' checked';
                            break;
                        } else
                            $select = '';
                    }
                }

                if ($service['name'] != $tempTypeServices) {
                    echo "<p class='typeServicesHeader'>{$service['name']}</p>";
                    $tempTypeServices = $service['name'];
                }
                
                echo "<div class='labelPlusCheckbox'><input type='checkbox' name='services[{$service['id']}]' value='{$service['id']}' id='{$service['id']}'{$select}/>
                    <label class='checkbox' for='{$service['id']}'>{$service['name_services']}</label></div>\n";
            }
            ?>
        </div>
        <div id="showFullList" class="showHideFullList">--- Развернуть весь список услуг ---</div>
        <div id="hideFullList" class="showHideFullList">--- Свернуть список услуг ---</div>


        <div class='line' style="margin-top: 30px;"></div>
        <div class='foto clear'>
            <h4 class="secondHeader fontLogo">Фото работ</h4>
            <?
            if (!empty($masterFotos)) {
                foreach ($masterFotos as $mf) {
                    $fotoTitle = "{$master['name']}, фото работы";
                    echo "<div class='fotoContainer clear' id='divFoto{$mf['id']}'>
                    <div class='fotoCurrent fotoCurrentMargin'>
                        <a href='{$pathToRoot}/{$mf['foto_url']}' rel='gallery{$master['id']}' title='{$fotoTitle}' class='lightbox'>
                            <img src='{$pathToRoot}/{$mf['foto_url']}' alt='{$pathToRoot}/{$mf['foto_url']}'/>
                            <span class='caption simple-caption'><p style='margin:0'>НАЖМИТЕ ДЛЯ УВЕЛИЧЕНИЯ</p></span>
                        </a>
                    </div>\n";

                    echo "<div class='fotoActionDiv'>
                        <div class='radio'>
                            <label><input type='radio' name='fotos[{$mf['id']}]' id='{$mf['id']}' value='0' checked>Оставить фото</label>
                        </div>
                        <div class='radio'>
                            <label><input type='radio' name='fotos[{$mf['id']}]' id='{$mf['id']}' value='1'>Удалить фото</label>
                        </div>
                    </div>
                </div>";
                }
            } else {
                echo "<p class='commentMore'>У мастера не добавлены фото работ</p>";
            }
        echo "</div>";

        if (count($masterFotos) > 3) {
            echo "<div id='showFullListFotos' class='showHideFullList'>--- Показать все фото ---</div>
            <div id='hideFullListFotos' class='showHideFullList'>--- Свернуть фото ---</div>";
        }
            ?>
        
        <h4 class="secondHeader fontLogo">Добавить фото работ</h4>
        <div class="addFotosDiv">
            <?
            for ($i = 1; $i <= 5; $i++) {
                echo $form->field($model, 'file' . $i, ['template' => "{input}"])
                    ->fileInput();
            }
            ?>

        </div>


        <?
        echo "<div class='masterComments comment commentLine clear'>
            <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
            <h4 class='secondHeader fontLogo'>Отзывы</h4>\n";


            if (!empty($masterComments)) {
                foreach ($masterComments as $c) {
                    ($c['side']) ? $class = 'ratingUp' : $class = 'ratingDown';
                    echo "<div class='commentWho' id='divComment{$c['id_comment']}'>
                        <span class='ratingUpDownPerson {$class}'></span>
                        <p>Оставил пользователь: <strong>{$c['fio']}</strong> ({$c['username']})</p>
                    </div>

                    <div class='commentActionDiv'>
                        <div class='radio'>
                            <label>
                                <input type='radio' name='comment[{$c['id_comment']}]' id='{$c['id_comment']}' value='0' checked>Оставить отзыв
                            </label>
                        </div>
                        <div class='radio'>
                            <label>
                                <input type='radio' name='comment[{$c['id_comment']}]' id='{$c['id_comment']}' value='1'>Удалить отзыв
                            </label>
                        </div>
                    </div>

                    <p class='commentText' id='divComment{$c['id_comment']}'>{$c['text']}</p>";
                }
            } else {
                echo "<p class='commentMore'>У мастера пока нет отзывов</p>";
            }
            echo "</div>";

        if ($masterComments) {
            echo "<div id='showFullListComments' class='showHideFullList'>--- Развернуть весь список отзывов ---</div>
            <div id='hideFullListComments' class='showHideFullList'>--- Свернуть список отзывов ---</div>";
        }
        ?>

            <div id="errorMsg"><span></span></div>

        <?= Html::submitButton('Применить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
            <div class="deleteCurrentMaster">
                <a href="<?= Url::to (['/admin/admin/delete-master', 'id' => $master['id']]) ?>">Удалить мастера</a>
            </div>
        <? ActiveForm::end(); ?>
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('//layouts/readInformation_02') ?>