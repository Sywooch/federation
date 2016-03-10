<?
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\RobotsHelper;

AppAsset::register($this);

// footer links
$linkingArray = [
    1 => [
        'Главная'     => Url::to(['/site/index']),
        'О Федерации' => Url::to(['/site/about']),
        'Мастера'     => Url::to(['/masters/all'])
    ],
    2 => [
        'Полезная информация' => Url::to(['/information/index']),
        'Муж на час'          => Url::to(['/site/hour']),
        'Контакты'            => Url::to(['/site/contact'])
    ],
    3 => [
        'Оставить отзыв' => Url::to(['/site/send-comment'])
    ]
];
?>
<? $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?
    $this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
    $this->registerMetaTag(['name' => 'title', 'content' => $this->title]);

    // for set noindex, follow, go to RobotsHelper::checkUrl and add excludes url
    (RobotsHelper::checkUrl(Url::current()))
        ? $this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow'])
        : $this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow']);

    //$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['keywords']]);
    ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= Yii::$app->params['pathToRoot'] ?>/favicon.png"/>
    <? $this->head() ?>
</head>
<body>
<? $this->beginBody() ?>
<div class="opacityBgBlack"></div>
<div class="lineTop clear">
    <div class="content">
        <a href="<?= Url::to(['/site/send-comment']) ?>">
            <div class="link floatLeft" id="sendComment">
                <div class="lineTopImg lineTopImgSecond"></div>
                ОСТАВИТЬ ОТЗЫВ
            </div>
        </a>
        <?
        if (Yii::$app->user->isGuest) {
            $link         = Url::to(['/user/login']);
            $registration = Url::to(['/user/registration']);

            echo "<a href=\"{$link}\">
            <div class=\"link floatRight\" id=\"login\"><div class=\"lineTopImg lineTopImgFifth\"></div>ВОЙТИ</div>
        </a>";
            echo "<a href=\"{$registration}\">
            <div class=\"link floatRight\" id=\"registration\">
                <div class=\"lineTopImg lineTopImgForth\"></div>
                РЕГИСТРАЦИЯ
            </div>
        </a>";
            $linkingArray[3]['Войти']       = $link;
            $linkingArray[3]['Регистрация'] = $registration;
        } else {
            $logout   = Url::to(['/user/logout']);
            $userName = Yii::$app->user->identity->username;

            echo "<a href=\"{$logout}\" data-method=\"post\">";
            echo "<div class=\"link floatRight\" id=\"login\">
                <div class=\"lineTopImg lineTopImgSixth\"></div>
                ВЫЙТИ
            </div>";
            echo "</a>";
            echo "<div class=\"link floatRight\" id=\"registration\">
                <div class=\"lineTopImg lineTopImgThird\"></div>ВЫ ВОШЛИ КАК <strong>{$userName}</strong></div>";

            if (Yii::$app->user->identity->role > 1) {
                $adminLink = Url::to(['/admin/admin/index']);

                echo "<a href=\"{$adminLink}\">
                <div class=\"link floatRight\"><div class=\"lineTopImg lineTopImgForth\"></div>АДМИНПАНЕЛЬ</div>
            </a>";
                $linkingArray[3]['Админпанель'] = $adminLink;
            }

            $linkingArray[3]['Выйти'] = $logout;
        }
        ?>
    </div>
</div>
<?= Breadcrumbs::widget([
    'links'        => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'itemTemplate' => "<li>{link} <span>|</span> </li>\n",
    'homeLink'     => [
        'label' => 'Главная',
        'url'   => Yii::$app->homeUrl,
    ],
]) ?>

<?= $content ?>

<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>

<div class="grayLinking clear">
    <div class="content">
        <?
        if (! empty($linkingArray)) {
            foreach ($linkingArray as $la) {
                echo "<div class='linkingRow'>";
                echo "<ul>";
                if (! empty($la)) {
                    foreach ($la as $lKey => $lValue) {
                        $lKey == 'Выйти' ? $dataMethod4Logout = " data-method='post'" : $dataMethod4Logout = '';
                        echo "<a href='{$lValue}'{$dataMethod4Logout}><li><span>{$lKey}</span></li></a>";
                    }
                }
                echo "</ul>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>

<div class="shadow"></div>

<div class="grayFooter">
    <div class="content">
        <div class="footerCopyright">
            <p>&copy; “Федерация Профессиональных Строителей” | <?= date('Y') ?></p>
            <p>Сайт не является публичной офертой, определяемой Статьей 437 ГК РФ</p>
        </div>
        <div class="icons">
            <!-- Yandex.Metrika informer -->
            <!-- <a href="https://metrika.yandex.ru/stat/?id=32282279&amp;from=informer"
               target="_blank" rel="nofollow"><img
                    src="https://informer.yandex.ru/informer/32282279/3_0_FFFFFFFF_EEEEEEFF_0_pageviews"
                    style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика"
                    title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)"
                    onclick="try{Ya.Metrika.informer({i:this,id:32282279,lang:'ru'});return false}catch(e){}"/></a>
            --><!-- /Yandex.Metrika informer -->

            <!-- Yandex.Metrika counter -->
            <!-- <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function () {
                        try {
                            w.yaCounter32282279 = new Ya.Metrika({
                                id: 32282279,
                                clickmap: true,
                                trackLinks: true,
                                accurateTrackBounce: true,
                                webvisor: true
                            });
                        } catch (e) {
                        }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () {
                            n.parentNode.insertBefore(s, n);
                        };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else {
                        f();
                    }
                })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript>
                <div><img src="/https://mc.yandex.ru/watch/32282279" style="position:absolute; left:-9999px;"
                          alt=""/></div>
            </noscript>
            --><!-- /Yandex.Metrika counter -->
        </div>
    </div>
</div>

<script type="text/javascript">
    var linkBackCall = '<?= Url::to(['/site/back-call']) ?>';
</script>

<div id="backCall">
    <a rel="leanModalBackCall">
        <div class="backCallImgContainer">
            <div class="backCallImg hvr-buzz-out"></div>
        </div>
        <div class="backCallImgContainer backCallImgBg"></div>
        <div class="backCallImgContainer backCallImgBg2"></div>
        <div class="backCallImgBg3"></div>
        <div class="text">
            <span>ПЕРЕЗВОНИМ<br/>СЕЙЧАС!</span>
        </div>
    </a>
</div>

<div class="overlayBackCall" id="overlayBackCall">
    <div class="overlayContentBackCall">
        <div id="BackCallContent"></div>
    </div>
</div>
<div id="navUpContainer">
    <div id="navUp">
        <img src="<?= Yii::$app->params['pathToRoot'] ?>/img/to_top.png"/>
        <p>ВВЕРХ</p>
    </div>
</div>
<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>