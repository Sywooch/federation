var speed = 300;
var div = 'div.labelPlusCheckboxContainer';

$(function () {
    // slideUp/slideDown list with services
    $('div#showFullList').click(function () {
        $('div.labelPlusCheckboxContainer').css({
            height: 'auto'
        });
        $('div#showFullList').hide(speed);
        $('div#hideFullList').show(speed);
    });
    $('div#hideFullList').click(function () {
        $('div.labelPlusCheckboxContainer').animate({
            height: '200px'
        }, 700);
        $('div#showFullList').show(speed);
        $('div#hideFullList').hide(speed);
    });

    // slideUp/slideDown list with fotos
    $('div#showFullListFotos').click(function () {
        $('div.foto').css({
            height: 'auto'
        });
        $('div#showFullListFotos').hide(speed);
        $('div#hideFullListFotos').show(speed);
    });
    $('div#hideFullListFotos').click(function () {
        $('div.foto').animate({
            height: '340px'
        }, 700);
        $('div#showFullListFotos').show(speed);
        $('div#hideFullListFotos').hide(speed);
    });

    // slideUp/slideDown list with comments
    $('div#showFullListComments').click(function () {
        $('div.masterComments').css({
            height: 'auto'
        });
        $('div#showFullListComments').hide(speed);
        $('div#hideFullListComments').show(speed);
    });
    $('div#hideFullListComments').click(function () {
        $('div.masterComments').animate({
            height: '300px'
        }, 700);
        $('div#showFullListComments').show(speed);
        $('div#hideFullListComments').hide(speed);
    });

    // show/hide select deleting foto
    $("div.fotoActionDiv input[value='1']").click(function (e) {
        var id = 'div#divFoto' + e.target.id + ' div.fotoCurrent';
        $(id).animate({opacity: '0.3'}, speed);
    });
    $("div.fotoActionDiv input[value='0']").click(function (e) {
        var id = 'div#divFoto' + e.target.id + ' div.fotoCurrent';
        $(id).animate({opacity: '1'}, speed);
    });

    // show/hide select deleting comment
    $("div.commentActionDiv input[value='1']").click(function (e) {
        var id = 'p#divComment' + e.target.id;
        var idDiv = 'div#divComment' + e.target.id;
        $(id).animate({opacity: '0.3'}, speed);
        $(idDiv).animate({opacity: '0.3'}, speed);
    });
    $("div.commentActionDiv input[value='0']").click(function (e) {
        var id = 'p#divComment' + e.target.id;
        var idDiv = 'div#divComment' + e.target.id;
        $(id).animate({opacity: '1'}, speed);
        $(idDiv).animate({opacity: '1'}, speed);
    });

    $('div.deleteCurrentMaster a').click(function () {
        return confirm("Вы подтверждаете удаление?");
    });
});