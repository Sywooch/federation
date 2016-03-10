var speed = 300;

$(function () {
    $(document.body).on('click', "a[rel='leanModalBackCall']", function () {
        $("div#overlayBackCall").fadeIn(speed);

        $("div#BackCallContent").load(linkBackCall);
    });
});

// click anywhere hide modal
$(document).mouseup(function (e) {

    var container = $(".overlayContentBackCall");
    var target = e.target;

    if (
        !container.is(target)
        && !$(target).is("a[rel='leanModalBackCall']")
        && container.has(target).length === 0
    ) {
        $('div#overlayBackCall').fadeOut(speed);
        $('div#BackCallContent').html('');
    } else if (container.has(target).length !== 0 && $(target).is(".modifyCloseButton")) {
        $('div#overlayBackCall').fadeOut(speed);
        $('div#BackCallContent').html('');
    }
});