$('#update_delivery_status').on('change', function () {
    var status = $('#update_delivery_status').val();
    if (status == 'on_the_way' && $('#minutes').val()) {
        $('#minutes-remaining').removeClass('d-none');
    } else {
        $('#minutes-remaining').addClass('d-none');
        update_delivery_status_of_order(order_id, status, 0);
    }
});

$(document).on('click', '.btn-submit-minutes-remaining', function () {
    if ($('#minutes').val()) {
        $('#minutes').removeClass('is-invalid');
        $('#minutes').addClass('is-valid');
        update_delivery_status_of_order(order_id, $('#emergency_update_delivery_status').val(), $('#minutes').val());
    } else {
        $('#minutes').removeClass('is-valid');
        $('#minutes').addClass('is-invalid');
    }
});

function update_delivery_status_of_order(order_id, status, minutes) {
    var delivery_type = $('#delivery_type').val();
    $.post(SITE_URL + '/orders/update_delivery_status', {
        _token: CSRF,
        order_id: order_id,
        status: status,
        minutes: minutes,
        delivery_type: delivery_type
    }, function (data) {
        AIZ.plugins.notify('success', order_update_success_notify);
        location.reload();
    });
}

$(document).on("change", ".check-all", function () {
    if (this.checked) {
        $('.check-one:checkbox').each(function () {
            this.checked = true;
        });
    } else {
        $('.check-one:checkbox').each(function () {
            this.checked = false;
        });
    }
});

function change_emergency_order_status(id, status, minutes) {
    $("#order_id").val(id);
    $("#update_delivery_status").val(status);
    $("#minutes").val(minutes);
}

function update_emergency_order_status() {
    $.post(SITE_URL + '/orders/update_delivery_status', {
        _token: CSRF,
        order_id: $("#order_id").val(),
        status: $("#update_delivery_status").val(),
        minutes: $('#minutes').val(),
    }, function (data) {
        if (data == 1) {
            AIZ.plugins.notify('success', order_status_notify);
        } else {
            AIZ.plugins.notify('error', some_error_notify);
        }
        $("#changeStatusModal").modal('hide');
        location.reload();
    });
}

function bulk_order_delete() {
    var data = new FormData($('#sort_orders')[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: SITE_URL + "/bulk-order-delete",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response == 1) {
                location.reload();
            }
        }
    });
}

$("form").submit(function () {
    $(this).find(':submit').prop('disabled', true);
    $("*").css("cursor", "wait");
});

function models() {
    var brand_id = $('#brand_id').val();
    $.ajax({
        url: SITE_URL +'/admin/get-car-models',
        type: 'post',
        data: {
            _token: CSRF,
            id: brand_id
        },
        success: function(res) {
            $('#model_id').html(res);
        },
        error: function() {
            alert('failed...');
        }
    });
}

function years() {
    var model_id = $('#model_id').val();
    $.ajax({
        url: SITE_URL +'/admin/get-car-years',
        type: 'post',
        data: {
            _token: CSRF,
            id: model_id
        },
        success: function(res) {
            $('#year_id').html(res);
        },
        error: function() {
            alert('failed...');
        }
    });
}
