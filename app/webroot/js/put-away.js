$(function () {

    applyCss();

    if ($.fn.accordion) {
        $(".accordion").accordion({
            active: false,
            collapsible: true,
            heightStyle: 'content'
        });
    }

    //click any of the MCA0101 buttons and make sure Floor is deselected
    $('input[type="radio"]').click(function () {
        $('#Floor1').prop('checked', false);
        $('#Floor1').button("refresh");
        window.console && console.log("inside click mcXYYZZ");
    });

    // this attaches to the body element
    // so that when the child element appears
    // it will already be bound

    $('body').on('click', '.jmits-cols label', function () {

        console.log("you are on clicked");

        $('label').click(function () {
            console.log("clicked");
            $(this).children('input').prop('checked', true);
            //alert($(this).children('input').attr('name'));
            $('input[type="radio"]:checked').each(function () {
                console.log($(this).attr('name') + ' : ' + $(this).attr('value'));
            })

        })
        $('.jmits-cols label').not(this).each(function () {
            $(this).removeClass('active');
            $(this).children('input').removeProp('checked');
        })

    });

    $('.jmits-aisle label').click(function (e) {
        div = $('#columns_levels');
        submit_url = div.data('submit_url');
        aisle = $(this).find('input').val();
        //div.empty();
        div.load(submit_url + '/' + aisle, function(){
             applyCss();
        });
        console.log("aisle clicked" + submit_url + $(this).find('input').val());

    });
    $('.rack label').click(function (e) {
        $('.floor label').removeClass('active');
        $('.floor label').children('input').removeProp('checked');

    })

    $('.floor label').click(function () {
        $('.rack label').removeClass('active');
        $('.rack label').children('input').removeProp('checked');

    })
    $('label[for="Floor1"]').click(function () {

        $('input[type="radio"]:checked').each(function () {


            $(this).prop('checked', false);
            $(this).button("refresh");
            window.console && console.log($(this).prop('value'))
        });

        window.console && console.log("inside click floor")

    })

    $('label').click(function () {
        console.log("clicked");
        $(this).children('input').prop('checked', true);
        //alert($(this).children('input').attr('name'));
        $('input[type="radio"]:checked').each(function () {
            console.log($(this).attr('name') + ' : ' + $(this).attr('value'));
        })

    })

});


function applyCss() {
    $('.warehouse.row:even').each(function () {
        $(this).css('background', 'rgb(249,249,249)');
        $(this).css('padding-top', '16px');
    });

    $('.warehouse.row:odd').each(function () {
        //  $(this).css('background', 'red');
        $(this).css('padding-top', '16px');
    });

    console.log('applyCss');


}
