<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <? $this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow']); ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="<?= Yii::$app->params['pathToRoot'] ?>/favicon.png"/>
    <?php $this->head() ?>
</head>
<body>
<? $this->beginBody() ?>
<div class="lineTop clear">
    <div class="content">
        <a href="<?= Url::to(['/site/send-comment']) ?>">
            <div class="link floatLeft">
                <div class="lineTopImg lineTopImgSecond"></div>
                ОСТАВИТЬ ОТЗЫВ
            </div>
        </a>

        <?
        if (Yii::$app->user->isGuest) {
            $link         = Url::to(['/user/login']);
            $registration = Url::to(['/user/registration']);

            echo "<a href=\"{$link}\">
                <div class=\"link floatRight\"><div class=\"lineTopImg lineTopImgFifth\"></div>ВОЙТИ</div>
            </a>";
            echo "<a href=\"{$registration}\">
                <div class=\"link floatRight\"><div class=\"lineTopImg lineTopImgForth\"></div>РЕГИСТРАЦИЯ</div>
            </a>";

        } else {
            $logout   = Url::to(['/user/logout']);
            $userName = Yii::$app->user->identity->username;

            echo "<a href=\"{$logout}\" data-method='post'>";
            echo "<div class=\"link floatRight\"><div class=\"lineTopImg lineTopImgSixth\"></div>ВЫЙТИ</div>";
            echo "</a>";
            echo "<div class=\"link floatRight\">
                <div class=\"lineTopImg lineTopImgThird\"></div>ВЫ ВОШЛИ КАК <strong>{$userName}</strong>
            </div>";

            if (Yii::$app->user->identity->role > 1) {
                $adminLink = Url::to(['/admin/admin/index']);

                echo "<a href=\"{$adminLink}\">
                    <div class=\"link floatRight\"><div class=\"lineTopImg lineTopImgForth\"></div>АДМИНПАНЕЛЬ</div>
                </a>";
            }
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

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>

<div class="grayLinking clear">
    <div class="content">
        <?
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
                'Заказать звонок' => 'index',
                'Задать вопрос'   => 'index',
                'Оставить отзыв'  => Url::to(['/site/send-comment'])
            ]
        ];
        if (! empty($linkingArray)) {
            foreach ($linkingArray as $la) {
                echo "<div class='linkingRow'>";
                echo "<ul>";
                foreach ($la as $lKey => $lValue) {
                    echo "<a href='{$lValue}'><li><span>{$lKey}</span></li></a>";
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
            <!--<img src="<? //=Yii::$app->params['pathToRoot'] ?>/img/rambler.png" alt="rambler"/>
                <img src="<? //=Yii::$app->params['pathToRoot'] ?>/img/liveinternet.png" alt="liveinternet"/>-->
        </div>
    </div>
</div>

<script type="text/javascript">
    var linkBackCall = '<?=Url::to(['/site/back-call'])?>';
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

<div id="navUp">
    <img src="<?= Yii::$app->params['pathToRoot'] ?>/img/to_top.png"/>
    <p>ВВЕРХ</p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>