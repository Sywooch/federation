<?php
use yii\helpers\Url;

$this::registerJsFile('@web/js/service_level_dropdown.js', ['position' => $this::POS_HEAD]);

$this->title = 'Федерация Профессиональных Строителей';
?>
<script type="text/javascript">
    var arrIndex;
    <? $js_array = json_encode($servicesLevel); echo "arrIndex = ". $js_array . ";"; ?>
    servicesLevelDropdown(arrIndex);
    mediaServicesLevelMenu();
</script>

<?= $this->render('/layouts/headerIndex', ['servicesLevel' => $servicesLevel, 'typeHeader' => 'full']) ?>

<div class="content clear" id="stepOfWork">
    <div class="stepOfWorkRow">
        <div class="stepImg stepImgAdd"></div>
        <div class="stepHead">
            <p class="fontLogo">Добавьте заявку</p>

            <p>Это занимает не более 2 минут</p>
        </div>
        <div class="stepText">Просто выберите нужный Вам тип работ и нажмите “Добавить заказ”, заполнив <br/>
            контактную форму
        </div>
    </div>
    <div class="stepOfWorkRow">
        <div class="stepImg stepImgCall"></div>
        <div class="stepHead">
            <p class="fontLogo">Ожидайте звонка</p>

            <p>Вам позвонят в течение 15 минут</p>
        </div>
        <div class="stepText">Наши специалисты свяжутся с Вами для уточнения деталей и объема требуемых работ, для
            выбора лучшего мастера
        </div>
    </div>
    <div class="stepOfWorkRow">
        <div class="stepImg stepImgJob"></div>
        <div class="stepHead">
            <p class="fontLogo">Мастер едет к Вам</p>

            <p>Теперь дело за мастером-профессионалом!</p>
        </div>
        <div class="stepText">В согласованное время он прибудет к Вам и выполнит всю необходимую работу. Мастер
            знает свое дело
        </div>
    </div>
</div>

<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutIndexHead fontLogo"><h2><a href="<?= Url::to(['/site/about']) ?>">О Федерации</a></h2>
        </div>
        <a href="<?= Url::to(['/site/about']) ?>">
            <div class="aboutImg">
                <img src="img/aboutBulders.png" alt="О Федерации">
            </div>
        </a>

        <div class="aboutText">
            <p><span>"Федерация Профессиональных Строителей"</span> создана и успешно функционирует с одной целью -
                обеспечить наивысший сервис каждому, кто стал на тропу ремонта или стройки.</p>

            <ul>
                <li>Если Вас пугает перспектива поиска профессиональных строителей - мы поможем!</li>
                <li>Если Вы откладываете ремонт, не зная, когда сможете его завершить - мы поможем!</li>
                <li>И наконец, Вы попросту не знаете с чего начать - Вы обратились точно по адресу!</li>
            </ul>

            <h4 class="fontLogo">Почему мы?</h4>

            <p>Ремонт. Стройка. Закупка стойтельных материалов. Эти вещи мало кого обходили стороной. И, если Вы не
                стремитесь зарабатывать строительством на хлеб, то, скорее всего, с такими вещами хочется закончить
                как можно скорее, или оттянуть начало.</p>

            <p><span>"Федерация Профессиональных Строителей"</span> - это объединение профессионалов, которое
                создано с целью облегчить этот процесс и позволить Вам наслждаться не только результатом, но и
                процессом.
                Как? <a href="<?= Url::to(['/site/about']) ?>">(Читать полностью)</a></p>
        </div>
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>

<div class="content clear">
    <div class="aboutIndexHead fontLogo"><h2><a href="<?= Url::to(['/site/about']) ?>">Как это работает?</a></h2>
    </div>

    <div class="aboutText howItWorkText">
        <div class="howItWorkImg">
            <img src="img/two_builder.png" alt="Как это работает?">
        </div>
        <p><span class="spanNumber">1 </span> Все, что от Вас требуется, это <a
                href="<?= Url::to(['/site/add']) ?>">заполнить онлайн заявку,</a> максимально подробно описав
            желаемую работу. Как только наши менеджеры ее обработают, с Вами свяжутся мастера федерации и поборятся
            за Ваш заказ.</p>

        <p>Федерация не продоставляет контактные данные заказчика посторонним лицам. Следовательно, каждый из
            обратившихся к Вам специалистов уже прошел предварительную аттестацию в федерации. Также Вы сможете
            ознакомиться с портфолио этого, и <a href="<?= Url::to(['/masters/all']) ?>">любого другого мастера</a>
            на сайте объединения.</p>

        <p>В случае, если с Вами связался мастер, который представился членом федерации, а его портфолио Вы не
            находите, рекомендуем обратиться в <a href="<?= Url::to(['/site/contact']) ?>">администрацию
                професииональных строителей</a>, т.к. от этого зависит качество исполнения заказа, и нашей репутации
            в целом.</p>

        <p><span class="spanNumber">2 </span> Также Вы можете выбрать любого исполнителя из всего <a
                href="<?= Url::to(['/masters/all']) ?>">списка портфолио мастеров,</a> заранее ознакомившись с
            качеством его исполнения и отзывами предыдущих заказчиков</p>

        <h4 class="fontLogo">Решение споров</h4>

        <p>Строительство и ремонт - это очень специфическая сфера, где доверие между исполнителем и заказчиком
            занимает не последнее место.</p>

        <p>В случае, если на строительной площадке возникают конфликтные ситуации, Федерация гарантирует
            непосредственное участие в разрешении споров. Вплоть до исключения мастера из объединения.</p>

        <p>Для решения споров обращайтесь напрямую: </p>

        <p><span><strong>Tel:</strong> <em>+7 978 031 54 98</em></span> <br/>
            <span><strong>Email:</strong> <em>info@fpbuilders.ru</em></span></p>
    </div>
</div>

<div class="line" id="hideLine"><img src="img/line.png" alt=""></div>

<div class="greyBg clear" id="services">
    <div class="content">
        <div class="aboutIndexHead fontLogo"><h2><a href="<?= Url::to(['/site/add']) ?>">Услуги Федерации</a></h2>
        </div>
        <div class="servicesRow" id="servicesRow1">
            <div class="servicesImg servicesImg1"></div>
            <div class="servicesText">Строительство домов и коттеджей</div>
        </div>
        <div class="servicesRow" id="servicesRow2">
            <div class="servicesImg servicesImg2"></div>
            <div class="servicesText">Ремонт квартир, домов</div>
        </div>
        <div class="servicesRow" id="servicesRow3">
            <div class="servicesImg servicesImg3"></div>
            <div class="servicesText">Услуги электрика</div>
        </div>
        <div class="servicesRow" id="servicesRow4">
            <div class="servicesImg servicesImg4"></div>
            <div class="servicesText">Услуги сантехника</div>
        </div>
        <div class="servicesRow" id="servicesRow5">
            <div class="servicesImg servicesImg5"></div>
            <div class="servicesText">Остекление, окна, балконы</div>
        </div>
        <div class="servicesRow" id="servicesRow6">
            <div class="servicesImg servicesImg6"></div>
            <div class="servicesText">Услуги плотника</div>
        </div>
        <div class="servicesRow" id="servicesRow7">
            <div class="servicesImg servicesImg7"></div>
            <div class="servicesText">Грузчики и грузоперевозки</div>
        </div>
        <div class="servicesRow marginBottom" id="servicesRow8">
            <div class="servicesImg servicesImg8"></div>
            <div class="servicesText">Кровельные работы</div>
        </div>
    </div>
</div>

<div class="line" id="hideLine"><img src="img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>

