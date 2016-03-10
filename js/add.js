$(function () {
    var speed = 400;
    var i = 2;

    $('a.addInputFile').click(function () {
        switch (i) {
            case 2:
                $('div.field-index-file2').fadeIn(speed);
                i++;
                break;
            case 3:
                $('div.field-index-file3').fadeIn(speed);
                i++;
                break;
            case 4:
                $('div.field-index-file4').fadeIn(speed);
                i++;
                break;
            case 5:
                $('div.field-index-file5').fadeIn(speed);
                $(this).hide();
                i++;
                break;
        }
    })
});