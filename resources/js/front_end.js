import $ from 'jquery';
import 'jquery-validation';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.fn.serializeFormObject = function () {
    var formData = $(this).serializeArray();
    var result = {};
    $.each(formData, function (index, value) {
        result[value.name] = value.value;
    });
    return result;
};
$(document).ready(function($) {
    $.validator.addMethod("phoneRegex", function(value, element, regexpr) {
        if($.trim(value)!="") {
            return regexpr.test(value);
        }else{
            return false;
        }
    }, "Please enter valid phone number.");

    $("#checkout-address-form").validate({
        // rules: {
        //     phone: {
        //         phoneRegex: /^(?:\+?\d{1,})?\d{8,}$/,
        //     }
        // },
        submitHandler: function (form) {
            var formElem = document.getElementById("checkout-address-form");
            var myFormData = new FormData(formElem);
            var formData = $(form).serializeFormObject();

            $.ajax({
                type: 'POST',
                url: '/checkout',
                data: formData,
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    var responseTextJson = JSON.parse(xhr.responseText)
                    if (responseTextJson) {
                        $(".checkout-msg").html('<p class="error" style="color: red">' + responseTextJson.message + '</p>');
                    }
                },
                success: function (response) {
                    console.log('response', response);
                    $("#payment-tab").trigger('click');
                    // if (response.status == 'success') {
                    //     console.log('response ', response);
                    //     if (response.user != null) {
                    //         $(".js_create_account_container").hide();
                    //     }
                    //     $("#payment-tab").trigger('click');
                    //     localStorage.setItem('checkout', JSON.stringify(formData));
                    // }
                }
            });
            return false;
        }
    });
});
