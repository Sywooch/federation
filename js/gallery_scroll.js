$(function () {
    var viewUL = $('div.view')
            .css('overflow', 'hidden')
            .children('ul'), //выберем ul и скроем прокрутки
        imgs = viewUL.find('img'),
        imgW = 332, //ширина картинки можно 400. Получить ее можно просто imgs[0].width() или img.first().width - то же самое. Но не делать так: imgs.css('width') - вернется '400px'
        imgsLen = imgs.length, //сколкько картинок всего
        totalImgsW = imgW * imgsLen, //сколько всего картинок будет
        current = 1; // номер картинки; //коллекция картинок

    //сделаем видимыми кнопки
    // покажи кнопки, найди button и повесь на низ onClick
    $('#show').show().find('div').on('click', function () {

        // за направление, куда листать, у нас отвечают id кнопок prev и next
        // узнаем какая кнопка была нажата. direction выводит prev и next
        var direction = $(this).attr('id');
        var position = imgW; // определяем позицию. Первая по умолчанию 400 = imgW

        // нужно выбрать current, т.е. какая картинка. ++current потому что нужно будет уже измененное значение current
        if (direction === 'next') {
            ++current;
        } else {
            --current;
        }

        // но если долго кликать по клавише вперед, можно уйти далеко в бесконечность. Поэтому мы здесь себе пишем условие
        // придаем цикличность
        var imgLenTwo = imgsLen - 1;
        if (current === 0) {
            current = imgsLen - 2; // на последнего
            direction = 'next'; // и direction переводим в next
            position = totalImgsW - imgW * 3;
        } else if (current == imgLenTwo) { // условно, если там 5, то
            current = 1; // прокручиваем в начало

            //позицию нужно обнулить
            position = 0;
        }

        doIt(viewUL, position, direction); // начинаем что-то делать
    });

    //функция doIt будет принимать container, позицию и direction
    function doIt(container, position, direction) {
        var sigh; //это либо вперед, либо назад
        if (direction && position !== 0) {
            sigh = (direction === 'next') ? '-=' : '+=';
        }
        container.animate({
            'margin-left': sigh ? (sigh + position) : position
        });
    }
});