<?php
use yii\helpers\Url;

$this->title = 'Панель управления пользователями';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?=$this->title ?></h1></div>

            <div class="adminMastersList">
                <p>Выберите дейсвтие:</p>
                <ul>
                    <li><a href='<?=Url::to(['admin/all-users'])?>'>Удалить пользователей</a></li>
                    <li><a href='<?=Url::to(['admin/export-users'])?>'>Экспорт данных пользователей в Excel</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>