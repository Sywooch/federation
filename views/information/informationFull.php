<?php
use yii\helpers\Html;

$this->title = $currentPost['title'];

$this->params['breadcrumbs'][] = ['label' => 'Полезная информация', 'url' => ['/information/index']];
$this->params['breadcrumbs'][] = $this->title;

// insert images
$countImgs    = 20;
$patterns     = [];
$replacements = [];

for ($i = 1; $i <= $countImgs; $i++) {
    $patterns[$i]     = "/:::$i([lcr])/u";
    $replacements[$i] = Html::img("@web/{$currentPost['file' . $i]}", [
        'class' => 'allImg $1Float',
        'alt'   => $currentPost['title'],
        'title' => $currentPost['title']
    ]);
}

$fullText = preg_replace($patterns, $replacements, $currentPost['full_text']);
?>
<?= $this->render('//layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class="greyBg clear">
        <div class="content">
            <div class="aboutHead fontLogo"><h1><?= $currentPost['title'] ?></h1></div>
            <div class="informationFullText informationRowText clear">
                <?= htmlspecialchars_decode($fullText) ?>
            </div>
        </div>
    </div>
    <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
    <div class="shadow"></div>
<?= $this->render('//layouts/readInformation_02') ?>