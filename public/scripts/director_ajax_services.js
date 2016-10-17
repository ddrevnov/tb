
refreshCategoryEvents();
refreshServicesEvents();

//Tempory Alert
function tempAlert() {
    $('#tablePreloader').hide();
}

//PAGINATED
function refreshCategoryEvents() {
    $('#category-table').each(function () {
        var currentPage = 0;
        var numPerPage = 15;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertBefore($table).find('span.page-number:first').addClass('active');
    });

    $("#category-table").tablesorter();
}
;
function refreshServicesEvents() {
    $('#services-table').each(function () {
        var currentPage = 0;
        var numPerPage = 15;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertBefore($table).find('span.page-number:first').addClass('active');
    });

    $("#services-table").tablesorter();
}
;


//REPLACE CATEGORIE ON SERVICES
function replaceCategories() {
    $('.category-select option').remove();

    $('.category').each(function () {
        var id = $(this).data('category-id');
        var name = $(this).find('.category_name').html();
        $('.category-select').append('<option value="' + id + '">' + name + '</option>');
    });
}

//CREATE CATEGORY
var open_category_remodal = $('#open-category-remodal');
var leistungenModal1 = $('#leistungenModal1').remodal();

open_category_remodal.on('click', function () {
    leistungenModal1.open();
});

$(document).on('click', '#create_new_category', function () {
    var data = {
        category_name: $('input[name="create_category_name"]').val(),
        category_status: $('select[name="create_category_status"]').val()
    };

    $.post({
        url: window.location['pathname'] + '/createcategory',
        data: data,
        success: function (response) {
            tempAlert('Category create successful');
            $('#tab-6').replaceWith(response);
            refreshCategoryEvents();
            replaceCategories();
            $('input[type="text"]').val('');
        }
    });
    leistungenModal1.close();
    return false;
});

//EDIT CATEGORY
var leistungenModal3 = $('#leistungenModal3').remodal();
$(document).on('click', '.category', function () {

    leistungenModal3.open();
    var name = $(this).find('.category_name').html();
    var id = $(this).data('category-id');
    $('input[name="edit-category-id"]').val(id);
    $('input[name="edit_category_name"]').val(name);
});
$(document).on('click', '#edit_category', function () {

    var data = {
        id_service: $('input[name="edit-category-id"]').val(),
        category_name: $('input[name="edit_category_name"]').val(),
        category_status: $('select[name="edit_category_status"]').val()
    };
    $.post({
        url: window.location['pathname'] + '/editcategory',
        data: data,
        success: function (response) {
            tempAlert('Edit successful');
            $('#tab-6').replaceWith(response);
            refreshCategoryEvents();
            replaceCategories();
        }
    });
    leistungenModal3.close();
    return false;
});
//DELETE CATEGORY
$(document).on('click', '.delete-category', function () {
    if (confirm('Are you shure to delete category?')) {
        var data = {
            id_service: $(this).parent().parent().attr('data-category-id')
        };
        $.post({
            url: window.location['pathname'] + '/removecategory',
            data: data,
            success: function (response) {
                tempAlert('Category Deleted');
                replaceCategories();
            }
        });
        $(this).parent().parent().remove();
    }
    return false;
});


//CREATE SERVICE
var open_service_remodal = $('#open-service-remodal');
var leistungenModal2 = $('#leistungenModal2').remodal();

open_service_remodal.on('click', function () {
    leistungenModal2.open();
});

$(document).on('click', '#create_new_service', function () {
    var data = {
        service_name: $('input[name="create_service_name"]').val(),
        category_id: $('select[name="create_service_category"]').val(),
        price: $('input[name="create_service_price"]').val(),
        duration: $('input[name="create_service_duration"]').val(),
        service_status: $('select[name="create_service_status"]').val()
    };

    $.post({
        url: window.location['pathname'] + '/createservice',
        data: data,
        success: function (response) {
            tempAlert('Service create successful');
            $('#tab-7').replaceWith(response);
            refreshServicesEvents();
            $('input[type="text"]').val('');
            leistungenModal2.close();
        }
    });

    return false;
});

//EDIT SERVICE
var leistungenModal4 = $('#leistungenModal4').remodal();

$(document).on('click', '.service', function () {

    leistungenModal4.open();

    var id = $(this).data('service-id');
    var name = $(this).find('.service_name').html();
    var price = $(this).find('.service_price').html().split(' ')[0];
    var duration = $(this).find('.service_duration').html().split(' ')[0];

    $('input[name="edit_service_id"]').val(id);
    $('input[name="edit_service_name"]').val(name);
    $('input[name="edit_service_price"]').val(price);
    $('input[name="edit_service_duration"]').val(duration);
});


$(document).on('submit', '#productEditForm', function () {

    var data = {
        id_service: $('input[name="edit_service_id"]').val(),
        service_name: $('input[name="edit_service_name"]').val(),
        category_id: $('select[name="edit_service_category"]').val(),
        price: $('input[name="edit_service_price"]').val(),
        duration: $('input[name="edit_service_duration"]').val(),
        service_status: $('select[name="edit_service_status"]').val()
    };

    $('#tablePreloader').show();

    $.post({
        url: window.location['pathname'] + '/editservice',
        data: data,
        success: function (response) {
            $('#tablePreloader').hide();
            $('#tab-7').replaceWith(response);
            refreshServicesEvents();
        }
    });
    leistungenModal4.close();

    return false;
});

//DELETE SERVICE
$(document).on('click', '.delete-service', function () {
    if (confirm('Are you shure to delete service?')) {
        var data = {
            id_service: $(this).parent().parent().attr('data-service-id')
        };

        $.post({
            url: window.location['pathname'] + '/removeservice',
            data: data,
            dataType: 'Json',
            success: function (response) {
                tempAlert('Deleted service');
            }
        });
        $(this).parent().parent().remove();
    }
    return false;
});
