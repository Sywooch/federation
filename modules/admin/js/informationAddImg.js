var speed = 400;

$(function () {
    var selector = $('div#hideAllFiles');
    selector.hide();

    $('div#showAllFiles').click(function () {
        $('div#allFiles').css({
            height: 'auto'
        });
        $('div#showAllFiles').hide(speed);
        $('div#hideAllFiles').show(speed);
    });

    selector.click(function () {
        $('div#allFiles').animate({
            height: '200px'
        }, 700);
        $('div#showAllFiles').show(speed);
        $('div#hideAllFiles').hide(speed);
    });
});