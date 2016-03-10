<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\TranslitHelper;

$link = Url::to([
    '/information/information-full',
    'id'    => $postData['id'],
    'title' => strtolower(TranslitHelper::translit($postData['title']))
]);

$imgSrc = Html::img("@web/{$postData['file']}");
?>
<div class="informationRow clear">
    <div class="informationRowImg">
        <a href="<?= $link ?>"><?= $imgSrc ?></a>
    </div>
    <div class="informationRowText">
        <a href="<?= $link ?>"><h5 class="fontLogo"><?= $postData['title'] ?></h5></a>

        <p>
            <?= htmlspecialchars_decode($postData['short_text']) ?>
            <a href="<?= $link ?>">Читать полностью</a>
        </p>
    </div>
</div>
<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
