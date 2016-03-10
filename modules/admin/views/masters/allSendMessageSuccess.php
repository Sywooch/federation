<?php
use yii\helpers\Url;

$this->title = 'Сообщение мастерам отправлено';

$this->params['breadcrumbs'][] = ['label' => 'Админпанель', 'url' => ['/admin/admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления мастерами', 'url' => ['/admin/masters/index']];
$this->params['breadcrumbs'][] = ['label' => 'Отправить сообщение мастерам', 'url' => ['/admin/masters/send-message']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/modules/" . $this->context->module->id . "/css/style.css");
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>

    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

            <div class="sendMessageDiv">
                <h5>Вы отправили сообщение:</h5>

                <p><em>"<?= $message ?>"</em></p>

                <h5>Следующим мастерам:</h5>
                <?
                if (! empty($emails)) {
                    foreach ($emails as $e) {
                        echo "<p><span>{$e['name']}</span> - <em>{$e['email']}</em></p>";
                    }
                }
                ?>
                <p><a href="<?= Url::to(['/admin/masters/send-message']) ?>" class="sendMore">Отправить еще
                        сообщение</a></p>
            </div>

        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>