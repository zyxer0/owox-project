$(document).ready(function () {
    if ($('.fn_authors_sidebar').length > 0) {
        $.ajax({
            url: 'ajax/authors',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                $('.fn_authors_sidebar').html(data);
            }
        });
    }
    if ($('.fn_dates_publishers_sidebar').length > 0) {
        $.ajax({
            url: 'ajax/date_publishers',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                $('.fn_dates_publishers_sidebar').html(data);
            }
        });
    }
    if ($('.fn_categories_sidebar').length > 0) {
        $.ajax({
            url: 'ajax/categories',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                $('.fn_categories_sidebar').html(data);
            }
        });
    }
});