<?php
use yii\helpers\RussianDateHelper;
use yii\helpers\Url;

echo "<h2 class='fontLogo modifyHeader'>Заказать звонок</h2>
    <div class='modifyCloseButton'></div>
    <div class='modifyCloseButtonHover'></div>";

$hoursArr   = [10, 11, 12, 13, 14, 15, 16, 17, 18];
$minutesArr = ['00', '15', '30', '45'];

$dateToday   = date('w');
$currentTime = date('G');
?>
<form action="<?= Url::to(['/site/back-call-send']) ?>">
    <div class="backCallTextContainer">
        <?
        // let's check today
        if ($dateToday == '0' or $dateToday == '6' or ($dateToday == '5' and $currentTime >= 18)) {
            // weekend or friday, after 18:00
            switch ($dateToday) {
                case '0':
                    $plusDay = 1;
                    break; // saturday
                case '6':
                    $plusDay = 2;
                    break; // sunday
                case '5':
                    $plusDay = 3;
                    break; // friday, after 18:00
            }

            $weCallYou = RussianDateHelper::getRussianDate(date('j.m', strtotime('+' . $plusDay . ' day')));

            echo "К сожалению, мы сейчас не работаем :( <br/>
            Давайте мы перезвоним Вам {$weCallYou} в ";

            echo "<select class='form-control' id='hour' name='hour'>";
            if (! empty($hoursArr)) {
                foreach ($hoursArr as $hour) {
                    echo "<option value='{$hour}'>$hour</option>";
                }
            }
            echo "</select> ч. ";

            echo "<select class='form-control' id='minutes' name='minutes'>";
            if (! empty($minutesArr)) {
                foreach ($minutesArr as $m) {
                    echo "<option value='{$m}'>$m</option>";
                }
            }
            echo "</select> мин.?";
        } else {
            // weekday
            $weCallYou = RussianDateHelper::getRussianDate(date('j.m'));

            $timeToCall = $currentTime + 1;

            if ($timeToCall <= 18) {
                // good time
                if ($timeToCall < 10) {
                    $timeToCall = 10;
                } // if too early

                echo "Перезвонить мне сегодня в ";

                echo "<select class='form-control' id='hour' name='hour'>";
                if (! empty($hoursArr)) {
                    foreach ($hoursArr as $hour) {
                        ($timeToCall == $hour) ? $selected = ' selected' : $selected = '';

                        if ($hour < $timeToCall) {
                            continue;
                        } // time passed

                        echo "<option value='{$hour}'{$selected}>$hour</option>";
                    }
                }
                echo "</select> ч. ";

                echo "<select class='form-control' id='minutes' name='minutes'>";
                if (! empty($minutesArr)) {
                    foreach ($minutesArr as $m) {
                        echo "<option value='{$m}'>$m</option>";
                    }
                }
                echo "</select> мин.";
            } else {
                // too later
                $weCallYou = RussianDateHelper::getRussianDate(date('j.m', strtotime('+1 day')));

                echo "К сожалению, сегодня уже поздно, мы работаем до 18:00 :( <br/>
            Давайте мы перезвоним Вам {$weCallYou} в ";

                echo "<select class='form-control' id='hour' name='hour'>";
                if (! empty($hoursArr)) {
                    foreach ($hoursArr as $hour) {
                        echo "<option value='{$hour}'>$hour</option>";
                    }
                }
                echo "</select> ч. ";

                echo "<select class='form-control' id='minutes' name='minutes'>";
                if (! empty($minutesArr)) {
                    foreach ($minutesArr as $m) {
                        echo "<option value='{$m}'>$m</option>";
                    }
                }
                echo "</select> мин.?";
            }
        }
        ?>
        <input type="text" name="phone" value="+7"/>
        <input type="hidden" name="weCallYou" value="<?= $weCallYou ?>"/>
    </div>
    <button type="submit" class="youNeedButton backCallButton fontLogo">Жду звонка!</button>
</form>
