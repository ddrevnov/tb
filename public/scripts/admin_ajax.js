//Tempory Alert
function tempAlert()
{
    var el = $("<div id='tablePreloader'></div>");
    setTimeout(function () {
        $('#tablePreloader').remove();
    }, 3000);
    $('body').append(el);
}


$(document).on('click', '#aboutus_edit', function () {

    if (!$(this).hasClass('edit')) {
        $('.admin-settings__text').hide();
        $('#text-area__text').show().val(function () {
            return $(this).prev().html();
        });
        $(this).addClass('edit');
    } else {

        var data = {
            about_us: $('#text-area__text').val()
        };

        $.ajax({
            url: '/office/aboutusedit',
            data: data,
            type: 'POST',
            dataType: 'Json',
            success: function () {

            }
        });
        tempAlert();
        $('.admin-settings__text').show().text(function () {
            return $(this).next().val();
        });
        $('#text-area__text').hide();
        $(this).removeClass('edit');
    }

    return false;
});

$(document).on('click', '#schedule_edit', function () {

    if (!$(this).hasClass('edit')) {
        $('.td-data').hide();
        $('.input-data').show().attr('value', function () {
            return $(this).prev().html();
        });
        $(this).addClass('edit');
    } else {


        var data = new Object();
        var i = 0;
        $('.worktime-tr').each(function () {
            data[i] = {from: $(this).find('.from').val(),
                to: $(this).find('.to').val()};
            i++;
        });

        $.ajax({
            url: '/office/scheduleedit',
            data: data,
            type: 'POST',
            dataType: 'Json',
            success: function () {

            }
        });

        tempAlert();
        $('.td-data').show().text(function () {
            return $(this).next().val();
        });
        $('.input-data').hide();
        $(this).removeClass('edit');
    }

    return false;
});


$('#bank_details_edit').on('click', function () {

    if (!$(this).hasClass('edit')) {
        $('.td-data').hide();
        $('.input-data').show().attr('value', function () {
            return $(this).prev().html();
        });
        $(this).addClass('edit');
    } else {

        var data = {
            account_owner: $('#account_owner').val(),
            account_number: $('#account_number').val(),
            bank_code: $('#bank_code').val(),
            bank_name: $('#bank_name').val(),
            iban: $('#iban').val(),
            bic: $('#bic').val()
        };

        $.ajax({
            url: '/office/bankdetailsedit',
            data: data,
            type: 'POST',
            dataType: 'Json',
            success: function () {

            }
        });

        tempAlert();
        $('.td-data').show().text(function () {
            return $(this).next().val();
        });
        $('.input-data').hide();
        $(this).removeClass('edit');
    }

    return false;
});