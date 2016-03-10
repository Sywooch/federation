function r(val) {
    console.log(val);
}

function fadeInContent(selector) {
    $(selector).fadeIn(500).removeClass('hidden');
}

$(function () {
    // scroll
    var scrollSelector = 'div#navUp';

    $(scrollSelector).hide();

    $(window).scroll(function () {

        if ($(this).scrollTop() > 100)
            $(scrollSelector).fadeIn();
        else
            $(scrollSelector).fadeOut();

    });

    $('div#navUp').click(function () {
            $('html, body').animate({scrollTop: '0px'}, 1000);
        }
    );

    // backcall button
    $(window).load(function () {
        var selector = 'div#backCall div.backCallImgBg',
            selector2 = 'div#backCall div.backCallImgBg2',
            selector3 = 'div#backCall div.backCallImgBg3';

        move(selector);
        move2(selector2);
        move3(selector3);
    });

    // Menu
    $('div#buttonMenu').click(function () {
        $('div.menu').fadeIn(200);
        $('div.opacityBgBlack').fadeIn(200);
    });

    $('div.hideMenu').click(function () {
        $('div.menu').fadeOut(200);
        $('div.opacityBgBlack').hide();
    });

    $('div.opacityBgBlack').click(function () {
        $('div.menu').fadeOut(200);
        $('div.opacityBgBlack').hide();
    });
});


function move(selector) {
    var phoneSelector = 'div.backCallImg',
        returnFunction = 'backPosition',

        moveSize = '+=55',
        moveBorderRadius = '+=25',
        moveMargin = '0px',
        moveOpacity = 0,
        moveDelay = 2000,
        moveDuration = 700,

        hoverClass = 'hvr-buzz-out',
        hoverDuration = '0.75s',
        hoverType = 'linear',
        hoverIterCount = '1';

    cssForPhone(phoneSelector, hoverClass, hoverDuration, hoverType, hoverIterCount);

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, moveDuration, moveDelay);
}

function backPosition(selector) {
    var phoneSelector = 'div.backCallImg',
        returnFunction = 'move',

        moveSize = '60',
        moveBorderRadius = '45',
        moveMargin = '27px',
        moveOpacity = '1',

        hoverClass = '',
        hoverDuration = '',
        hoverType = '',
        hoverIterCount = '';

    cssForPhone(phoneSelector, hoverClass, hoverDuration, hoverType, hoverIterCount);

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, 0, 0);
}


function move2(selector) {
    var returnFunction = 'backPosition2',
        moveSize = '+=55',
        moveBorderRadius = '+=25',
        moveMargin = '0px',
        moveOpacity = 0,
        moveDelay = 2200,
        moveDuration = 700;

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, moveDuration, moveDelay);
}

function backPosition2(selector) {
    var returnFunction = 'move2',
        moveSize = '60',
        moveBorderRadius = '45',
        moveMargin = '27px',
        moveOpacity = 1;

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, 0, 0);
}


function move3(selector) {
    var returnFunction = 'move3_2',
        moveSize = '+=35',
        moveBorderRadius = '+=25',
        moveMargin = '9px',
        moveOpacity = 0.3,
        moveDelay = 2300,
        moveDuration = 1300;

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, moveDuration, moveDelay);
}

function move3_2(selector) {
    var returnFunction = 'backPosition3',
        moveSize = '+=55',
        moveBorderRadius = '+=25',
        moveMargin = '-20px',
        moveDelay = 3000,
        moveDuration = 1300,
        moveOpacity = 0;

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, moveDuration, moveDelay);
}

function backPosition3(selector) {
    var returnFunction = 'move3',
        moveSize = '60',
        moveBorderRadius = '45',
        moveMargin = '27px',
        moveOpacity = 0.3;

    getAniamtion(selector, moveSize, moveBorderRadius, moveOpacity, moveMargin, returnFunction, 0, 0);
}


function cssForPhone(phoneSelector, hoverClass, duration, type, iterationCount) {
    $(phoneSelector).css({
        '-webkit-animation-name': hoverClass,
        'animation-name': hoverClass,
        '-webkit-animation-duration': duration,
        'animation-duration': duration,
        '-webkit-animation-timing-function': type,
        'animation-timing-function': type,
        '-webkit-animation-iteration-count': iterationCount,
        'animation-iteration-count': iterationCount
    });
}

function getAniamtion(selector, size, borderRadius, opacity, margin, returnFunction, duration, delay) {
    $(selector).delay(delay).animate({
            'height': size,
            'width': size,
            '-moz-border-radius': borderRadius,
            '-webkit-border-radius': borderRadius,
            'border-radius': borderRadius,
            'opacity': opacity,
            'margin-top': margin,
            'margin-left': margin
        },
        {
            'duration': duration,
            complete: function () {
                window[returnFunction](selector);
            },
            stop: function () {
            }
        });
}