<?php
use yii\helpers\Url;

$this->title = 'Админпанель';

$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

            <div class="adminMastersList">
                <p>Выберите раздел для добавления, удаления, редактирования информации:</p>
                <ul>
                    <li><a href="<?= Url::to(['orders/all']) ?>">Заказы</a></li>
                    <li><a href="<?= Url::to(['masters/index']) ?>">Мастера</a></li>
                    <li><a href="<?= Url::to(['hour/index']) ?>">Муж на час</a></li>
                    <li><a href="<?= Url::to(['information/index']) ?>">Статьи</a></li>
                    <li><a href="<?= Url::to(['users/index']) ?>">Пользователи</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>

<?= $this->render('//layouts/readInformation_02') ?>

