<?
use yii\helpers\Url;

if ($typeHeader == 'full') {
    $classGradient   = 'headerDgGradient';
    $classBgCity     = 'headerBgCity';
    $classMenu       = 'menuButton';
    $classBottomLine = 'line';
    $spanClass       = 'spanNewFull';
    $addContent      = $this->render('headerFull', ['servicesLevel' => $servicesLevel]);

} elseif ($typeHeader == 'lite') {
    $classGradient   = 'headerDgGradientLite';
    $classBgCity     = 'headerBgCityLite';
    $classMenu       = 'menuButtonAdd';
    $classBottomLine = 'shadow';
    $spanClass       = 'spanNewAdd';
}

$menuArray = [
    'О Федерации' => Url::to(['/site/about']),
    'Мастера'     => Url::to(['/masters/all']),
    'Муж на час'  => Url::to(['/site/hour']),
    'Статьи'      => Url::to(['/information/index']),
    'Контакты'    => Url::to(['/site/contact'])
];
?>
<div class="<?= $classGradient ?>">
    <div class="<?= $classBgCity ?>">
        <div class="content">
            <a href="<?= Url::to(['/site/index']) ?>">
                <div class="logo">
                    <img src="<?= Yii::$app->params['pathToRoot'] ?>/img/logo020.png" alt="На главную">
                </div>
            </a>

            <div id="headerContact">
                <a href="<?= Url::to(['/site/contact']) ?>"><span class="fontLogo">+7 978 031 54 98</span>
                    <span>info@fpbuilders.ru</span></a>
            </div>
        </div>
        <div class="line lineButtonMenu"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
        <div class="buttonMenu" id="buttonMenu"></div>
        <div class="line lineButtonMenu"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
        <div class="menu">
            <div class="hideMenu">СКРЫТЬ МЕНЮ</div>
            <div class="menuBg">
                <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
                <div class="content">
                    <?
                    if (! empty($menuArray)) {
                        foreach ($menuArray as $maKey => $maVal) {
                            ($maVal === Url::to(['/site/hour'])) ?
                                $new = "<span class='spanNew {$spanClass}'>новое!</span>"
                                : $new = '';
                            echo "<a href='{$maVal}'><div class='{$classMenu} fontLogo'>{$maKey}{$new}</div></a>\n";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
        </div>
        <?
        if ($addContent) {
            echo $addContent;
        }
        ?>
    </div>
</div>

<div class="<?= $classBottomLine ?>"></div>
