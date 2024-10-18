$(document).on('click', '.btn-edit-category', function () {
    $('#category-name').val($(this).data('category'));
    $('#update-form').attr('action', $(this).data('action'));
});

$(document).on('click', '.btn-edit-donation', function () {
    $('#donation-name').val($(this).data('name'));
    $('#donation-status').val($(this).data('status'));
    $('#update-form').attr('action', $(this).data('action'));
});

$(document).on('click', '.btn-delete', function () {
    $('#delete-item').html($(this).data('item'));
    $('#delete-form').attr('action', $(this).data('action'));
});

$("form").submit(function () {
    $(this).find('.spinner-border').removeClass('d-none');
    $(this).find(":submit").prop('disabled', true);
    $("*").css("cursor", "wait");
});
