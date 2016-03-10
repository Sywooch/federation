<?php
use yii\widgets\LinkPager;
use yii\helpers\PageHelper;

$this->title = 'Полезная информация' . PageHelper::pageString('page', 'Страница', 'toTitle');

$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo">
                <h1><?= 'Полезная информация' . PageHelper::pageString('page', 'Страница', 'toH1') ?></h1>
            </div>
            <?
            if (! empty($allPosts)) {
                foreach ($allPosts as $ap) {
                    echo $this->render('/layouts/information/short.php', ['postData' => $ap]);
                }
            }
            ?>
        </div>
    </div>

    <div class="content clear">
        <div class="paginationContainer content">
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>

    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>