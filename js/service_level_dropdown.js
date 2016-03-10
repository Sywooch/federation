function servicesLevelDropdown(arrIndex) {
    if (typeof arrIndex == "object") {
        $(function () {
            var speed = 300;
            var idArray = [];
            // arrIndex was import from PHP
            for (var id in arrIndex) {
                idArray[id] = id;
            }

            // config for selected value
            $('div.listSelectCurrentValue').click(function () {
                $('div#sub').fadeToggle(speed);
                $('div.listSelectCurrentValue').toggleClass('active'); // switch style
                $('div.subCurrent').fadeOut(speed); // hide subContent in any case
                $('div#sub span').removeClass('subActive'); // remove hover effect
            });

            // set event for mousemove on selected menu row and show the list of needed options
            for (var arr in idArray) {
                $('div#sub span#' + idArray[arr]).mouseenter(function (e) {
                    $('div#sub span').removeClass('subActive');
                    $($(this)).addClass('subActive');

                    var id = e.currentTarget.id;
                    $('div#subCurrentContent').show(); // show div with subCurrentContent
                    $('div#subCurrentContent div.subCurrent').hide(); // hide all
                    $('div#subCurrentContent div#' + id).fadeIn(speed); // show only needed
                });
            }

            // click event for the selected option
            $('div.subCurrent span').click(function (e) {
                var selectValue = e.target.attributes[0].value;
                var selectParent = e.target.parentNode.id;
                var selectText = e.target.innerText;
                var selectString = selectParent + '|' + selectValue;

                // set value for hidden inputs
                $("input[name=selectValueName]").val(selectValue);
                $("input[name=selectValueType]").val(selectParent);

                // set chosen value as currentValue
                $('div#listSelect div#currentValue strong')[0].innerText = selectText;

                // hide the drop down menu
                $('#sub').fadeOut(speed);
                $('div#subCurrentContent').fadeOut(speed);
                $('div.listSelectCurrentValue').removeClass('active');
                $('div#sub span').removeClass('subActive');
            });

            // click anywhere for hiding the drop down menu
            $(document).click(function (e) {
                var target = e.target;
                if (!$(target).is('#sub') && !$(target).is('div.listSelectCurrentValue')
                    && !$(target).parents().is('#sub') && !$(target).parents().is('div.listSelectCurrentValue')) {
                    $('#sub').fadeOut(speed);
                    $('div#subCurrentContent').fadeOut(speed);
                    $('div.listSelectCurrentValue').removeClass('active');
                    $('div#sub span').removeClass('subActive');
                }
            });
        });
    }
}

function setInnerDataAsCurrent(currentValueSubContent, currentValueName, currentValueType) {
    var spanFromCurrentSubList;

    document.getElementById('hiddenName').value = currentValueName;
    document.getElementById('hiddenType').value = currentValueType;

    spanFromCurrentSubList = document.getElementsByTagName('div')[currentValueType].getElementsByTagName('span');
    for (var a in spanFromCurrentSubList) {
        a = parseInt(a);
        if (!isNaN(a)) {
            var b = spanFromCurrentSubList[a].getAttribute('data-value');
            if (b == currentValueName) {
                currentValueSubContent = spanFromCurrentSubList[a].innerText;
                break;
            }
        }
    }
    document.getElementById('currentValue').childNodes[1].innerText = currentValueSubContent;
}

function mediaServicesLevelMenu() {
    $(function () {
        if ($(this).width() < 500) {
            $('div#listSelect div#sub span').on('mouseenter', function () {
                var i = $(this).attr('data-margin'),
                    marginTop = i * 40;

                $('div#subCurrentContent').css({
                    'margin-top': marginTop
                });
            });
        }
    });
}
