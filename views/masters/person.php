<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\PageHelper;

$this->title = $master[0]['name'] . PageHelper::pageString('page', 'Страница', 'toTitle');

$this->params['breadcrumbs'][] = ['label' => 'Мастера Федерации', 'url' => ['masters/all']];
$this->params['breadcrumbs'][] = $this->title;

$this::registerJsFile ('@web/js/core_boxgallery.js');
$this::registerJsFile ('@web/js/gallery_scroll.js');
$this::registerCssFile ('@web/css/core.css');
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class='greyBg marginBottomMinus clear'>
    <div class="aboutHead fontLogo">
        <h1><?= $master[0]['name'] . PageHelper::pageString('page', 'Страница комментариев -', 'toH1') ?></h1>
    </div>
</div>
<?
// for foto
$fotoMaster = [];
if (! empty($foto)) {
    foreach ($foto as $f) {
        if ($f['id_master'] == $master[0]['id'])
            $fotoMaster[] = $f['foto_url'];
    }
}

// for comments
$countComments = count($commentsAll);
$goodComments  = 0;

if (! empty($commentsAll)) {
    foreach ($commentsAll as $c) {
        if ($c['side'] == 1) $goodComments++;
    }
}

($countComments) ? $resultComments = round($goodComments / $countComments * 5) : $resultComments = 0;
$badComment = $countComments - $goodComments;

// age
$ageMs = time() - strtotime($master[0]['age']);
$age   = round($ageMs / 60 / 60 / 24 / 365.25, 0, PHP_ROUND_HALF_DOWN);

$age = abs($age);
$t1  = $age % 10;
$t2  = $age % 100;
$ageYearName = ($t1 == 1 && $t2 != 11 ? 'года': ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >=20) ? 'лет' : 'лет'));

// experience
$master[0]['expirience'] = abs($master[0]['expirience']);
$t1 = $master[0]['expirience'] % 10;
$t2 = $master[0]['expirience'] % 100;
$expirienceYearName = ($t1 == 1 && $t2 != 11 ? 'год': ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >=20) ? 'года' : 'лет'));

$master[0]['history'] = htmlspecialchars_decode($master[0]['history']);
$pathToRoot = Yii::$app->params['pathToRoot'];

$master[0]['avatar'] ? $avatar = $master[0]['avatar'] : $avatar = 'img/avatarDefault.jpg';

echo "<div class='greyBg clear'>
    <div class='content'>
        <div class='masterHeader clear'>
            <div class='avatar'>
                <img src='{$pathToRoot}/{$avatar}' alt='{$master[0]['name']}'
                    title='Мастер Федерации: {$master[0]['name']}'/>
            </div>
            <div class='masterInfo'>
                <p>{$master[0]['status']}</p>
                <p>{$master[0]['city']}</p>
                <div id='ratingPerson' class='clear'>
                <div class='rating ratingPerson rating_{$resultComments}'></div>\n";
                if ($goodComments)
                    echo "<div class='ratingUpDownPerson ratingUp'>
                        <span>{$goodComments}</span>
                    </div>";
                if ($badComment) {
                    ($goodComments) ? $lonelyBadComment = '' : $lonelyBadComment = ' ratingDownLonely';
                    echo "<div class='ratingUpDownPerson ratingDown{$lonelyBadComment}'>
                        <span>{$badComment}</span>
                    </div>";
                }
                if (!$goodComments and !$badComment)
                    echo "<div class='ratingNoneComments ratingNoneCommentsPerson'><span>(нет отзывов)</span></div>";
                echo "</div>";
            echo "</div>";
        echo "</div>
        <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>";

echo "<div class='masterShortDescription clear'>
    <div class='history'>
        <div class='historyBlock'><p class='masterShortHeader'>Работа и оплата</p>\n";
            if ($master[0]['friends'])
                echo "<p><strong>Бригада:</strong> {$master[0]['friends']} чел.</p>\n";
            if ($master[0]['status'])
                echo "<p><strong>Форма работы:</strong> {$master[0]['status']}</p>\n";
            if ($master[0]['money'])
                echo "<p><strong>Форма оплаты:</strong> {$master[0]['money']}</p>\n";
            if ($master[0]['expirience'])
                echo "<p><strong>Стаж:</strong> более {$master[0]['expirience']} {$expirienceYearName}</p>\n";
            if ($master[0]['age'])
                echo "<p><strong>Возраст главного мастера:</strong> {$age} {$ageYearName}</p>\n";
        echo "</div>\n";
        if ($master[0]['city']) {
            echo "<div class='historyBlock'>
                <p class='masterShortHeader'>Удобное место работы</p>
                <p>{$master[0]['city']}</p>
            </div>";
        }
        echo "<div class='historyBlock'>
            <p class='masterShortHeader'>О себе</p>
            <p>{$master[0]['history']}</p>
        </div>
    </div>
    <div class='services'><p class='masterShortHeader'>Виды работ</p>\n";
        $tempTypeServices = '';
        if (! empty($services)) {
            foreach ($services as $msVal) {
                if ($msVal['name'] != $tempTypeServices) {
                    echo "<p class='typeServicesHeader'>{$msVal['name']}</p>\n";
                    $tempTypeServices = $msVal['name'];
                }
                echo "<p class='nameServices'>{$msVal['name_services']}</p>\n";
            }
        }
    echo "</div>";

    echo "<div class='foto'>
        <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
        <p class='masterShortHeader masterShortHeaderLine'>Фото работ</p>";
        if ($foto) {
            echo "<div class='view'><ul>";
            foreach ($foto as $fm) {
                echo "<li>
                    <div class='fotoCurrent' id='pearsonPhoto'>
                        <a href='{$pathToRoot}/{$fm['foto_url']}' rel='gallery'
                            title='{$master[0]['name']}, фото работы' class='lightbox'>
                            <img src='{$pathToRoot}/{$fm['foto_url']}' alt=''/>
                            <span class='caption simple-caption'><p style='margin:0'>НАЖМИТЕ ДЛЯ УВЕЛИЧЕНИЯ</p></span>
                        </a>
                    </div>
                </li>";
            }
                echo "</ul>
            </div><div id='showButtons'>
            <div id='show'>
                <div id='prev' class='prevNext'></div>
                <div id='next' class='prevNext'></div>
            </div></div>";
        } else
            echo "<div class='fotoMore'>Фото работ отсутствует</div>";
    echo "</div>";

echo "<div class='comment commentLine'>
    <div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>
    <p class='masterShortHeader masterShortHeaderLine'>Отзывы:</p>\n";
    if (Yii::$app->user->isGuest) {
        $link      = Url::to(['/user/registration']);
        $linkEnter = Url::to(['/user/login']);

        echo "<p class='addComment'>Чтобы оставить свой отзыв, пройдите простую процедуру
            <a href='$link'>регистрации</a> или <a href='$linkEnter'>войдите на сайт</a></p>";
    } else {
        $link = Url::to(['/masters/comment', 'id' => $master[0]['id'], 'name' => $master[0]['name']]);

        echo "<a class='addComment fontLogo' href='{$link}'>Оставить отзыв об этом мастере</a>";
    }

    if ($comments) {
        foreach ($comments as $c) {
            ($c['side']) ? $class = 'ratingUp' : $class = 'ratingDown' ;
            echo "<div class='commentWho' id='{$c['id_comment']}'>
                <span class='ratingUpDownPerson {$class}'></span>
                <p>Оставил пользователь: <strong>{$c['fio']}</strong> ({$c['username']})</p>
            </div>
            <p class='commentText'>{$c['text']}</p>";
        }
    } else
        echo "<p class='commentMore'>У мастера пока нет отзывов</p>";
            echo "</div>
        </div>
    </div>
</div>
<div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>";
?>
<div class="content clear">
    <div class="paginationContainer content">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>

<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>