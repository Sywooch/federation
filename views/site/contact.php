<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Контакты';

$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->isGuest) {
    $defaultName =
    $defaultEmail = '';
    $readonly    = false;
} else {
    $defaultName  = Yii::$app->user->identity->fio;
    $defaultEmail = Yii::$app->user->identity->email;
    $readonly     = 'readonly';
}
?>
<?= $this->render('/layouts/headerIndex', ['typeHeader' => 'lite']) ?>
<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1><?= $this->title ?></h1></div>

        <div class="contactRow">
            <h5 class="fontLogo">Телефоны администрации:</h5>

            <div class="contactImg contactImgTel"></div>
            <div class="contactText">
                <p><strong>+7 978 031 54 98</strong></p>
            </div>
        </div>

        <div class="contactRow">
            <h5 class="fontLogo">Адрес:</h5>

            <div class="contactImg contactImgLocation"></div>
            <div class="contactText">
                <p>Наш офис находится по адресу: <br/>
                    <strong>г. Симферополь, ул. Ким, 56. Офис 1</strong><br/>
                    (Евпаторийское шоссе, напротив Fozzi, Meganom)</p>
            </div>
        </div>

        <div class="contactRow">
            <h5 class="fontLogo">Email:</h5>

            <div class="contactImg contactImgEmail"></div>
            <div class="contactText">
                <p>info@fpbuilders.ru</p>
            </div>
        </div>

        <div class="contactRow" style="margin-bottom: 60px;">
            <h5 class="fontLogo">График работы:</h5>

            <div class="contactImg contactImgTime"></div>
            <div class="contactText">
                <p>Понедельник - Пятница, с 9:00 до 19:00</p>
            </div>
        </div>
        <!--
        <div class="contactRow">
            <h5 class="fontLogo">Skype:</h5>
            <div class="contactImg contactImgSkype"></div>
            <div class="contactText">
                <p><strong>f_team</strong></p>
            </div>
        </div>

        <div class="contactRow">
            <h5 class="fontLogo">Социальные сети:</h5>
            <a href=""><div class="contactImgSocial contactImgVk"></div></a>
            <a href=""><div class="contactImgSocial contactImgFb"></div></a>
            <a href=""><div class="contactImgSocial contactImgTwitter"></div></a>
            <a href=""><div class="contactImgSocial contactImgGoogle"></div></a>
        </div>-->
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>

<div class="greyBg clear">
    <div class="content sendEnter">
        <p>Желаете стать мастером <strong>Федерации Профессиональных Строителей?</strong> <br/>
            <a href="<?= Url::to(['/masters/enter']); ?>">Заполните заявку</a>, мы готовы обсудить этот вопрос.</p>
    </div>
</div>

<div class="line" id="hideLineMap"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="content" id="map">
    <div class="aboutHead fontLogo"><h1>Карта проезда</h1></div>
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3991.8558047849315!2d34.0816640565609!3d44.97073323195447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40eadd855656c4a3%3A0xd5b64cbf3fed6caf!2zNTYg0YPQuy4g0JrQmNCc0LAsINCh0LjQvNGE0LXRgNC-0L_QvtC70Yw!5e0!3m2!1sru!2sua!4v1438708331964"
            width="1000" height="700" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</div>

<div class="line"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<div class="greyBg clear">
    <div class="content">
        <div class="aboutHead fontLogo"><h1>Напишите нам!</h1></div>

        <? $form = ActiveForm::begin(); ?>
        <div id="listSelectContacts" class="listSelect">

            <label class="labelAdd" for="about">О чем Ваш вопрос:</label>
            <?= $form->field($model, 'about', ['template' => "{input}"])
                ->dropDownList([
                    'about_company' => 'О Федерации',
                    'about_work'    => 'О заказе',
                    'about_masters' => 'О мастерах',
                    'about_other'   => 'Другая тема...'
                ]) ?>

            <label class="labelAdd" for="more">Напишите Ваш вопрос здесь:</label>
            <?= $form->field($model, 'more', ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textarea(['name' => 'more']) ?>

            <label class="labelAdd" for="Index[clientName]">Представьтесь, пожалуйста:</label>
            <?= $form->field($model, 'clientName', ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textInput(['value' => $defaultName, 'readonly' => $readonly]) ?>

            <label class="labelAdd" for="Index[clientEmail]">Ваш E-mail (электронная почта):</label>
            <?= $form->field($model, 'clientEmail',
                ['template' => "{input}<div class='errorMessage'>{error}</div>"])
                ->textInput(['value' => $defaultEmail, 'readonly' => $readonly]) ?>

            <label class="labelAdd" for="Index[captcha]">Введите симовлы на картинке <em>(чтобы поменять изображение
                    нажмите на него)</em>:</label>
            <?= $form->field($model, 'captcha')
                ->widget(\yii\captcha\Captcha::classname(), [
                    'template' =>
                        '<div class="captchaDiv"><div class="captchaImg">{image}</div>
                        <div class="captchaInput">{input}</div></div>',
                ])
                ->label(false) ?>
        </div>

        <?= Html::submitButton('Отправить', ['class' => 'youNeedButtonAdd fontLogo']) ?>
        <? ActiveForm::end(); ?>
    </div>
</div>

<div class="line" id="hideLine"><img src="<?= Yii::$app->params['pathToRoot'] ?>/img/line.png" alt=""></div>
<div class="shadow"></div>

<?= $this->render('/layouts/readInformation_02') ?>