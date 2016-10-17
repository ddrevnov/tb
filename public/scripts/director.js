$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function sendAjax(data) {
        $.ajax({
            url: window.location['pathname'] + '/edit',
            data: data,
            type: 'POST',
            success: function (response) {

            }
        });
    }

//SMALL POPUP FOR NEW ADMINS
    $("#display_new_admins").click(function ()
    {
        $('#new_admins_popup').toggle();
    });

    $('#chDirectorNewAdmin').click(function () {
        var status = $('select').val();
        var string = window.location + '?status=' + status;
        window.location = string;
    });

//PAGINATE AND SORT FOR TABLES

    if ($("#employee-table").find("tr").size() > 1)
    {
        $("#employee-table").tablesorter();
    }

    if ($("#admins-table").find("tr").size() > 1)
    {
        $("#admins-table").tablesorter();
    }

    if ($("#clients-table").find("tr").size() > 1)
    {
        $("#clients-table").tablesorter();
    }

    if ($("#services-table").find("tr").size() > 1)
    {
        $("#services-table").tablesorter();
    }

    if ($("#category-table").find("tr").size() > 1)
    {
        $("#category-table").tablesorter();
    }

    if ($("#newsletter-table").find("tr").size() > 1)
    {
        $("#newsletter-table").tablesorter();
    }

    if ($("#employee-table").find("tr").size() > 1)
    {
        $("#employee-table").tablesorter();
    }

    if ($("#tariffs-table").find("tr").size() > 1)
    {
        $("#tariffs-table").tablesorter();
    }

    if ($("#orders-table").find("tr").size() > 1)
    {
        $("#orders-table").tablesorter();
    }
    
    if ($("#notice-table").find("tr").size() > 1)
    {
        $("#notice-table").tablesorter();
    }


// EDIT SHEDULE INFO
    // $('#edit_admin_shedule').on('click', function () {
    //     if (!$(this).hasClass('edit')) {
    //         $('.td-data').hide();
    //         $('.input-data').show().attr('value', function () {
    //             return $(this).prev().html();
    //         });
    //         $(this).addClass('edit');
    //     } else {


    //         var data = {};
    //         var i = 0;
    //         $('.worktime-tr').each(function () {
    //             data[i] = {from: $(this).find('.from').val(),
    //                 to: $(this).find('.to').val()};
    //             i++;
    //         });

    //         $.ajax({
    //             url: window.location['pathname'] + '/edit_worktimes',
    //             data: data,
    //             type: 'POST',
    //             success: function (response) {

    //             }
    //         });

    //         $('.td-data').show().text(function () {
    //             return $(this).next().val();
    //         });
    //         $('.input-data').hide();
    //         $(this).removeClass('edit');
    //     }

    //     return false;
    // });

    
});


