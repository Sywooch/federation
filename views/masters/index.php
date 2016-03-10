<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\PageHelper;
use yii\helpers\TranslitHelper;

$this->title = 'Мастера Федерации Профессиональных Строителей' . PageHelper::pageString('page', 'Страница', 'toTitle');

$this->params['breadcrumbs'][] = 'Мастера Федерации';

$this::registerJsFile('@web/js/core_boxgallery.js');
$this::registerCssFile('@web/css/core.css');
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
    <div class='greyBg clear'>
        <div class="aboutHead">
            <h1 class="fontLogo">Мастера Федерации <?= PageHelper::pageString('page', 'Страница', 'toH1') ?></h1>
        </div>
    </div>
    <div class="greyBg clear">
        <div class="content sendEnter">
            <p><a href="<?= Url::to(['/masters/enter']); ?>">Отправить заявку</a> на вступление в Федерацию
                Профессиональных Строителей</p>
        </div>
    </div>
<?
$ii = 0;
if (! empty($masters)) {
    foreach ($masters as $m) {
        if (! $m['id']) {
            continue;
        }

        $m['history_short'] = htmlspecialchars_decode($m['history_short']);

        // change bg
        ($ii % 2 == 0) ? $classGray = 'greyBg ' : $classGray = '';
        $ii++;

        // for foto
        $fotoMaster = [];
        if (! empty($foto)) {
            foreach ($foto as $f) {
                if ($f['id_master'] == $m['id']) {
                    $fotoMaster[] = $f['foto_url'];
                }
            }
        }

        // for services
        $masterServices = [];
        $i              = 0;
        if (! empty($services)) {
            foreach ($services as $s) {
                if ($s['id_master'] == $m['id']) {
                    $masterServices[$i]['type'] = $s['name'];
                    $masterServices[$i]['name'] = $s['name_services'];
                    $i++;
                }
            }
        }

        // for comments
        $countComments      = 0;
        $goodComments       = 0;
        $badComment         = 0;
        $lastComment        = '';
        $lastCommentUser    = '';
        $lastCommentUserFio = '';
        $lastCommentSide    = '';
        if (! empty($comments)) {
            foreach ($comments as $c) {
                if ($c['id_master'] == $m['id']) {
                    if (! $lastComment) {
                        $lastComment        = $c['text'];
                        $lastCommentUser    = $c['username'];
                        $lastCommentUserFio = $c['fio'];
                        $lastCommentSide    = $c['side'];
                    }
                    $countComments++;
                    if ($c['side'] == 1) {
                        $goodComments++;
                    }
                }
            }
        }
        ($countComments) ? $resultComments = round($goodComments / $countComments * 5) : $resultComments = 0;
        $badComment = $countComments - $goodComments;

        $pathToRoot = Yii::$app->params['pathToRoot'];

        // for fist master set padding
        ($ii == 1) ? $firstMaster = ' paddingTop' : $firstMaster = '';

        // fink for read more
        $link = Url::to(['/masters/person', 'id' => $m['id'], 'name' => strtolower(TranslitHelper::translit($m['name']))]);

        $m['avatar'] ? $avatar = $m['avatar'] : $avatar = 'img/avatarDefault.jpg';

        // let's GO!
        echo "<div class='{$classGray}clear'>";
        echo "<div class='content'>";
        echo "<div class='masterHeader{$firstMaster} clear'>";

        // avatar
        echo "<div class='avatar'><a href='$link'>
            <img src='{$pathToRoot}/{$avatar}' alt='{$m['name']}' title='Мастер Федерации: {$m['name']}'/></a>
        </div>";

        // master Info
        echo "<div class='masterInfo'>";
        echo "<p><a href='$link'>{$m['name']}</a></p>";

        echo "<p>{$m['city']}</p>";

        // rating
        echo "<div id='rating' class='clear'>";
        echo "<div class='rating ratingShort rating_{$resultComments}'></div>";
        if ($goodComments) {
            echo "<div class='ratingUpDown ratingUp'><span>{$goodComments}</span></div>";
        }
        if ($badComment) {
            ($goodComments) ? $lonelyBadComment = 'ratingDown' : $lonelyBadComment = 'ratingDown ratingDownLonely';
            echo "<div class='ratingUpDown {$lonelyBadComment}'><span>{$badComment}</span></div>";
        }
        if (! $goodComments and ! $badComment) {
            echo "<div class='ratingNoneComments'><span>(нет отзывов)</span></div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div><div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>";

        // short history
        echo "<div class='masterShortDescription clear'>";
        echo "<div class='history'>
            <p class='masterShortHeader'>Краткая информация</p>
            <p>{$m['history_short']} <a class='servicesReadMore' href='$link'>(Читать полностью)</a></p>
        </div>";

        // services
        echo "<div class='services'><p class='masterShortHeader'>Услуги</p>";
        $tempTypeServices = '';

        $i = 0;
        $j = 0;
        if (! empty($masterServices)) {
            foreach ($masterServices as $msKKey => $msVal) {
                if ($i < 5) {
                    if ($msVal['type'] != $tempTypeServices) {
                        echo "<p class='typeServicesHeader'>{$msVal['type']}</p>";
                        $tempTypeServices = $msVal['type'];
                        $i++;
                    }
                    echo "<p class='nameServices'>{$msVal['name']}</p>";
                    $i++;
                    $j++;
                } else {
                    $sevicesCut = count($masterServices) - $j;
                    if ($sevicesCut) {
                        echo "<p class='moreServices'>
                            <a class='servicesReadMore' href='$link'>(Показать подробно, еще {$sevicesCut})</a>
                        </p>";
                    }
                    break;
                }
            }
        }
        echo "</div>";

        // photo
        echo "<div class='foto'><p class='masterShortHeader'>Фото работ</p>";
        if ($fotoMaster) {
            $fotoTitle = "{$m['name']}, фото работы";
            $i = 0;
            $countFoto = count($fotoMaster);
            foreach ($fotoMaster as $fm) {
                if ($i < 3) {
                    echo "<div class='fotoCurrent'>
                        <a href='{$pathToRoot}/{$fm}' rel='gallery{$m['id']}' title='{$fotoTitle}' class='lightbox'>
                            <img src='{$pathToRoot}/{$fm}' alt='{$pathToRoot}/{$fm}'/>
                            <span class='caption simple-caption'><p style='margin:0'>НАЖМИТЕ ДЛЯ УВЕЛИЧЕНИЯ</p></span>
                        </a>
                    </div>\n";
                    $i++;
                } else {
                    $countFotoMore = $countFoto - $i;
                    echo "<div class='fotoMore'><a class='servicesReadMore' href='$link'>Еще {$countFotoMore} фото</a></div>\n";
                    break;
                }
            }
        } else {
            echo "<div class='fotoMore'>Фото работ отсутствует</div>";
        }
        echo "</div>";

        // comments
        echo "<div class='comment'><p class='masterShortHeader'>Свежий отзыв:</p>";
        if ($lastComment and $lastCommentUser) {
            ($lastCommentSide) ? $class = 'ratingUp' : $class = 'ratingDown';
            echo "<p class='commentText'>{$lastComment}</p>";
            echo "<div class='commentWho commentWhoIndex'><span class='ratingUpDownPerson {$class}'></span>";
            echo "<p>Оставил пользователь: <strong>{$lastCommentUserFio}</strong> ({$lastCommentUser})</p></div>";
            echo "<p id='showMore'><a class='servicesReadMore' href='$link'>Показать подробную информацию</a></p>";
        } else {
            echo "<p class='commentMore'>У мастера пока нет отзывов</p>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='line'><img src='" . Yii::$app->params['pathToRoot'] . "/img/line.png' alt=''></div>";
        if ($ii != $mastersOnPage) {
            echo "<div class='shadow'></div>";
        }
    }
}
?>
<div class="content clear">
    <div class="paginationContainer content">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>

<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_01') ?>