$(document).on("click", ".btn-save", function(e) {
    e.preventDefault();
    var flag = true;
    $("[required]").each(function() {
        if ($(this).val() == '') {
            flag = false;
            $(this).focus();
            return true;
        }
    });

    if (flag) {
        is_checked = false;
        $("input[name='services[]']:checked").each(function() {
            is_checked = true;
            return true;
        });
        if (is_checked) {
            if ($('#package_type').val() == '') {
                flag = false;
                $('#package_type').focus();
            }
            if ($('#sub_category_id').val() == '') {
                flag = false;
                $('#sub_category_id').focus();
            }
            if ($('#sub_child_category_id').val() == '') {
                flag = false;
                $('#sub_child_category_id').focus();
            }
        }
    }
    if (flag) {
        $(this).prop('disabled', true);
        $("*").css("cursor", "wait");
        $('#services-products-form').submit();
    }
});

$(document).on("change", ".check-all", function() {
    if (this.checked) {
        $('.check-' + $(this).data('check') + ':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $('.check-' + $(this).data('check') + ':checkbox').each(function() {
            this.checked = false;
        });
    }
});

function get_all_tyres() {
    $('.btn-tyre-filter').find('.spinner-border').removeClass('d-none');
    $.post(SITE_URL + '/admin/get-all-tyres', {
        _token: CSRF,
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        year_id: $('#year_id').val(),
        variant_id: $('#variant_id').val(),
        sub_category_id: $('#featured_cat_id').val(),
        sub_child_category_id: $('#featured_sub_cat_id').val(),
        size_cat_id: $('#size_cat_id').val(),
        sub_cat_id: $('#sub_cat_id').val(),
        child_cat_id: $('#child_cat_id').val(),
    }, function(data) {
        $('.btn-tyre-filter').find('.spinner-border').addClass('d-none');
        $('#tbl-tyres tbody').empty();
        $('#tbl-tyres tbody').append(data);
        var searchIDs = $("#tbl-tyres input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        $('#added_tyres').val(searchIDs.join(","));
    });
}

function get_all_parts_carwash(categories_name) {
    let name = "parts"; // Default name
    if (categories_name == "Car Wash") {
        name = "carwash";
    }

    // Use template literals to dynamically set the class and ID selectors
    $(`.btn-${name}-filter`).find('.spinner-border').removeClass('d-none');
    $.post(SITE_URL + '/admin/get-all-parts', {
        _token: CSRF,
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        year_id: $('#year_id').val(),
        variant_id: $('#variant_id').val(),
        sub_category_id: $('#featured_cat_id').val(),
        sub_child_category_id: $('#featured_sub_cat_id').val(),
        size_cat_id: $('#size_cat_id').val(),
        sub_cat_id: $('#sub_cat_id').val(),
        child_cat_id: $('#child_cat_id').val(),
        categories_name: categories_name,
        name: name        
    }, function (data) {
        $(`.btn-${name}-filter`).find('.spinner-border').addClass('d-none');

        // Use template literals for the table selector
        $(`#tbl-${name} tbody`).empty();
        $(`#tbl-${name} tbody`).append(data);

        var searchIDs = $(`#tbl-${name}s input:checkbox:checked`).map(function () {
            return $(this).val();
        }).get();
        $(`#added_${name}`).val(searchIDs.join(","));
    });
}


// function get_all_parts_carwash(categories_name) {
//     let categories_name = "Parts";
//     let name = "part";
//     if (categories_name =="Car Wash") {
//         name = "carwash";
//     }
//     $('.btn-part-filter').find('.spinner-border').removeClass('d-none');
//     $.post(SITE_URL + '/admin/get-all-parts', {
//         _token: CSRF,
//         brand_id: $('#brand_id').val(),
//         model_id: $('#model_id').val(),
//         year_id: $('#year_id').val(),
//         variant_id: $('#variant_id').val(),
//         sub_category_id: $('#featured_cat_id').val(),
//         sub_child_category_id: $('#featured_sub_cat_id').val(),
//         size_cat_id: $('#size_cat_id').val(),
//         sub_cat_id: $('#sub_cat_id').val(),
//         child_cat_id: $('#child_cat_id').val(),
//         categories_name: categories_name,
//     }, function(data) {
//         $('.btn-part-filter').find('.spinner-border').addClass('d-none');
//         $('#tbl-parts tbody').empty();
//         $('#tbl-parts tbody').append(data);
//         var searchIDs = $("#tbl-parts input:checkbox:checked").map(function(){
//             return $(this).val();
//         }).get();
//         $('#added_parts').val(searchIDs.join(","));
//     });
// }

function get_all_batteries() {
    $('.btn-battery-filter').find('.spinner-border').removeClass('d-none');
    $.post(SITE_URL + '/admin/get-all-batteries', {
        _token: CSRF,
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        year_id: $('#year_id').val(),
        variant_id: $('#variant_id').val(),
        sub_category_id: $('#battery_sub_category_id').val(),
        sub_child_category_id: $('#battery_sub_child_category_id').val(),
    }, function(data) {
        $('.btn-battery-filter').find('.spinner-border').addClass('d-none');
        $('#tbl-batteries tbody').empty();
        $('#tbl-batteries tbody').append(data);
        var searchIDs = $("#tbl-batteries input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        $('#added_batteries').val(searchIDs.join(","));
    });
}

$(document).on('click', '.btn-filter-mileages', function () {
    $.each($("#mileages option:selected"), function () {
        $(this).prop('selected', false);
    });
    $.post(SITE_URL + '/admin/get-all-mileages', {
        _token: CSRF,
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        year_id: $('#year_id').val(),
        variant_id: $('#variant_id').val(),
    }, function(data) {
        var arr = JSON.parse(data);
        var mileage = arr.mileage;
        for (i = 0; i < mileage.length; i++) {
            $('#mileages option[value="' + mileage[i] + '"]').prop('selected', true);
        }
    });
});

$(document).on('click', '.btn-generate-expiry-months', function () {
    $('#expiry-months').removeClass('d-none');
    $('.mileage option').each(function () {
        var i = $(this).val();
        if ($(this).is(':selected')) {
            var flag = true;
            $('.expiry_mileage_input').each(function () {
                var j = $(this).val();
                if (j == i) {
                    flag = false;
                    return false;
                }
            });
            if (flag) {
                $('#expiry-months').append('<tr id="' + i + '-tr"><td>' + i + '</td><td><input type="number" value="6" class="form-control" disabled></td></tr>');
            }
        } else {
            $('#' + i + '-tr').remove();
        }
    });
});

function get_all_services() {
    $('.btn-service-filter').find('.spinner-border').removeClass('d-none');
    $.post(SITE_URL + '/admin/get-all-services', {
        _token: CSRF,
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        year_id: $('#year_id').val(),
        variant_id: $('#variant_id').val(),
        package_type: $('#package_type').val(),
        sub_category_id: $('#sub_category_id').val(),
        mileages: $('#mileages').val(),
        sub_child_category_id: $('#sub_child_category_id').val(),
        group_type: $('input[name="group_type"]:checked').val()
    }, function(data) {
        $('.btn-service-filter').find('.spinner-border').addClass('d-none');
        $('#tbl-services tbody').empty();
        $('#tbl-services tbody').append(data);
        var searchIDs = $("#tbl-services input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        $('#added_services').val(searchIDs.join(","));
    });
}

function battery_get_sub_child_categories() {
    $.ajax({
        url: SITE_URL + "/admin/battery-get-sub-child-categories",
        type: 'POST',
        data: {
            _token: CSRF,
            id: $('#battery_sub_category_id').val()
        },
        success: function(res) {
            $('#battery_sub_child_category_id').html(res);
            $("#battery_sub_child_category_id").selectpicker('refresh');
        },
        error: function() {
            alert('failed...');

        }
    });
}

$(document).on('keyup', '.search-input', function() {
    // Retrieve the input field text and reset the count to zero
    var filter = $(this).val();
    var table = $(this).data('tbl');
    $('#' + table + ' tbody tr').hide();
    var result = $('#' + table + ' tbody tr:not(.notfound) td:contains("' + filter + '")');
    var len = result.length;

    if(len > 0){
        // Searching text in columns and show match row
        result.each(function(){
            $(this).closest('tr').show();
        });
    }else{
        $('.notfound').show();
    }
});

$(document).on('blur', '#mileage', function () {
    var rangeUpperLimit = Math.ceil($(this).val() / 5000) * 5000;
    if ((($(this).val() - 1) / 5000) % 2 === 0) {
        select_semi_option();
    } else {
        select_fully_option();
    }
    $(this).val(rangeUpperLimit);
});

function select_semi_option() {
    $("#package_type option").prop("selected", false)
    $("#package_type option[value='semi']").prop("selected", true);
}

function select_fully_option() {
    $("#package_type option").prop("selected", false)
    $("#package_type option[value='fully']").prop("selected", true);
}