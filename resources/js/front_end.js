import $ from 'jquery';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener("DOMContentLoaded", function () {

    $(".js-btn-add-cart").on("click", function (event) {
        event.preventDefault();
        $.ajax({
            url: base_url+ '/add-to-cart',
            method:'POST',
            data: {
                'name': 'Iman'
            },
            success: function (response) {

            },
            error: function (error) {

            }
        });
    });

});
