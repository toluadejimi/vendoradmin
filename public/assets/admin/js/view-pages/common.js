

"use strict";

    document.addEventListener('DOMContentLoaded', function () {
        let checkboxes = document.querySelectorAll('.dynamic-checkbox');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('click', function (event) {
                event.preventDefault();
                const checkboxId = checkbox.getAttribute('data-id');
                const imageOn = checkbox.getAttribute('data-image-on');
                const imageOff = checkbox.getAttribute('data-image-off');
                const titleOn = checkbox.getAttribute('data-title-on');
                const titleOff = checkbox.getAttribute('data-title-off');
                const textOn = checkbox.getAttribute('data-text-on');
                const textOff = checkbox.getAttribute('data-text-off');

                const isChecked = checkbox.checked;

                if (isChecked) {
                    $('#toggle-status-title').empty().append(titleOn);
                    $('#toggle-status-message').empty().append(textOn);
                    $('#toggle-status-image').attr('src',imageOn);
                    $('#toggle-status-ok-button').attr('toggle-ok-button', checkboxId);
                    $('#toggle-ok-button').attr('toggle-ok-button', checkboxId);

                    console.log('Checkbox ' + checkboxId + ' is checked');
                } else {
                    $('#toggle-status-title').empty().append(titleOff);
                    $('#toggle-status-message').empty().append(textOff);
                    $('#toggle-status-image').attr('src',imageOff);
                    $('#toggle-status-ok-button').attr('toggle-ok-button', checkboxId);
                    $('#toggle-ok-button').attr('toggle-ok-button', checkboxId);
                    console.log('Checkbox ' + checkboxId + ' is unchecked');
                }


                $('#toggle-status-modal').modal('show');

            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        let checkboxes = document.querySelectorAll('.dynamic-checkbox-toggle');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('click', function (event) {
                event.preventDefault();
                const checkboxId = checkbox.getAttribute('data-id');
                const imageOn = checkbox.getAttribute('data-image-on');
                const imageOff = checkbox.getAttribute('data-image-off');
                const titleOn = checkbox.getAttribute('data-title-on');
                const titleOff = checkbox.getAttribute('data-title-off');
                const textOn = checkbox.getAttribute('data-text-on');
                const textOff = checkbox.getAttribute('data-text-off');


                const isChecked = checkbox.checked;

                if (isChecked) {
                    $('#toggle-title').empty().append(titleOn);
                    $('#toggle-message').empty().append(textOn);
                    $('#toggle-image').attr('src',imageOn);
                    $('#toggle-ok-button').attr('toggle-ok-button', checkboxId);

                } else {
                    $('#toggle-title').empty().append(titleOff);
                    $('#toggle-message').empty().append(textOff);
                    $('#toggle-image').attr('src',imageOff);
                    $('#toggle-ok-button').attr('toggle-ok-button', checkboxId);
                }

                    $('#toggle-modal').modal('show');
            });
        });
    });


      document.addEventListener('DOMContentLoaded', function () {
        let imageData = document.querySelectorAll('.remove-image');
        imageData.forEach(function (image) {
            image.addEventListener('click', function (event) {
                event.preventDefault();
                const imageId = image.getAttribute('data-id');
                const title = image.getAttribute('data-title');
                const text = image.getAttribute('data-text');

                    $('#toggle-status-title').empty().append(title);
                    $('#toggle-status-message').empty().append(text);
                    $('#toggle-status-ok-button').attr('toggle-ok-button', imageId);
                    $('#toggle-ok-button').attr('toggle-ok-button', imageId);

                $('#toggle-status-modal').modal('show');

            });
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        const langLinks = document.querySelectorAll(".lang_link");

        langLinks.forEach(function (langLink) {
            langLink.addEventListener('click', function (e) {
                e.preventDefault();
                langLinks.forEach(function (link) {
                    link.classList.remove('active');
                });
                this.classList.add('active');
                document.querySelectorAll(".lang_form").forEach(function (form) {
                    form.classList.add('d-none');
                });
                let form_id = this.id;
                let lang = form_id.substring(0, form_id.length - 5);

                $("#" + lang + "-form").removeClass('d-none');
                $("#" + lang + "-form1").removeClass('d-none');
                $("#" + lang + "-form2").removeClass('d-none');
                $("#" +lang+"-form3").removeClass('d-none');
                $("#" +lang+"-form4").removeClass('d-none');
                if (lang === 'default') {
                    $(".default-form").removeClass('d-none');
                }
            });
        });
    });





$('[data-slide]').on('click', function(){
    let serial = $(this).data('slide')
    $(`.tab--content .item`).removeClass('show')
    $(`.tab--content .item:nth-child(${serial})`).addClass('show')
})
$(document).ready(function() {
    $('.add-required-attribute').on('click', function() {
        let status = $(this).attr('id');
        let name = $(this).data('textarea-name');
        if ($('#' + status).is(':checked')) {
            $('#en-form .' + name).attr('required', true);
        } else {
            $('#en-form .' + name).removeAttr('required');
        }
    });
});

$(document).on('click', '.location-reload', function () {
    location.reload();
});
$(document).on('click', '.redirect-url', function () {
    location.href=$(this).data('url');
});

function readURL(input, viewer='viewer') {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#' + viewer).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    "use strict"
    $(".upload-img-3, .upload-img-4, .upload-img-2, .upload-img-5, .upload-img-1, .upload-img").each(function(){
        let targetedImage = $(this).find('.img');
        let targetedImageSrc = $(this).find('.img img');
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                let uploadedFile = new FileReader();
                uploadedFile.onload = function (e) {
                    targetedImageSrc.attr('src', e.target.result);
                    targetedImage.addClass('image-loaded');
                    targetedImage.hide();
                    targetedImage.fadeIn(650);
                }
                uploadedFile.readAsDataURL(input.files[0]);
            }
        }
        $(this).find('input').on('change', function () {
            proPicURL(this);
        })
    })

    $('.read-url').on('change', function () {
        readUrl(this);
    });

});
$(document).on('ready', function () {
    // INITIALIZATION OF SHOW PASSWORD
    // =======================================================
    $('.js-toggle-password').each(function () {
        new HSTogglePassword(this).init()
    });


    // INITIALIZATION OF FORM VALIDATION
    // =======================================================
    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this), {
            rules: {
                confirmPassword: {
                    equalTo: '#signupSrPassword'
                }
            }
        });
    });
});

$('.route-alert').on('click',function (){
    let route = $(this).data('url');
    let message = $(this).data('message');
    let title = $(this).data('title');
    route_alert(route, message,title);
})
$(".set-filter").on("change", function () {
    const id = $(this).val();
    const url = $(this).data('url');
    const filter_by = $(this).data('filter');
    let nurl = new URL(url);
    nurl.searchParams.delete('page');
    nurl.searchParams.set(filter_by, id);
    location.href = nurl;
    tour.next();
});
$(document).ready(function() {
    $('.onerror-image').on('error', function() {
        let img = $(this).data('onerror-image');
        $(this).attr('src', img);
    });

    $('.onerror-image').each(function() {
        let defaultImage = $(this).data('onerror-image');
        if ($(this).attr('src').endsWith('/')) {
            $(this).attr('src', defaultImage);
        }
    });
});

$(document).on('click', '.confirm-Status-Toggle', function () {
    let Status_toggle = $('#toggle-status-ok-button').attr('toggle-ok-button');
    if ($('#'+Status_toggle).is(':checked')) {
        $('#'+Status_toggle).prop('checked', false).val(0);
    } else {
        $('#'+Status_toggle).prop('checked', true).val(1);
    }
    $('#'+Status_toggle+'_form').submit();
});
$(document).on('click', '.confirm-Toggle', function () {

    let toggle_id = $('#toggle-ok-button').attr('toggle-ok-button');
    if ($('#'+toggle_id).is(':checked')) {
        $('#'+toggle_id).prop('checked', false);
    } else {
        $('#'+toggle_id).prop('checked', true);
    }
    $('#toggle-modal').modal('hide');

    if(toggle_id === 'free_delivery_over_status'){
        if ($("#free_delivery_over_status").is(':checked')) {
            $('#free_delivery_over').removeAttr('readonly');
        } else {
            $('#free_delivery_over').attr('readonly', true).val(null);
        }
    }
    if(toggle_id === 'product_gallery'){
        if ($("#product_gallery").is(':checked')) {
            $(".access_all_products").removeClass('d-none');
        } else {
            $(".access_all_products").addClass('d-none');
        }
    }
    if(toggle_id === 'product_approval'){
        if ($("#product_approval").is(':checked')) {
            $(".access_product_approval").removeClass('d-none');
        } else {
            $(".access_product_approval").addClass('d-none');
        }
    }
    if(toggle_id === 'additional_charge_status'){
        if ($("#additional_charge_status").is(':checked')) {
            $('#additional_charge_name').removeAttr('readonly').attr("required", true);
            $('#additional_charge').removeAttr('readonly').attr("required", true);
        } else {
            $('#additional_charge_name').attr('readonly', true).removeAttr('required');
            $('#additional_charge').attr('readonly', true).removeAttr('required');
        }
    }
    if(toggle_id === 'cash_in_hand_overflow'){
        if ($("#cash_in_hand_overflow").is(':checked')) {
            $('#cash_in_hand_overflow_store_amount').removeAttr('readonly').attr('required', true);
            $('#min_amount_to_pay_store').removeAttr('readonly').attr('required', true);
            $('#min_amount_to_pay_dm').removeAttr('readonly').attr('required', true);
            $('#dm_max_cash_in_hand').removeAttr('readonly').attr('required', true);
        } else {
            $('#cash_in_hand_overflow_store_amount').attr('readonly', true).removeAttr('required');
            $('#min_amount_to_pay_store').attr('readonly', true).removeAttr('required');
            $('#min_amount_to_pay_dm').attr('readonly', true).removeAttr('required');
            $('#dm_max_cash_in_hand').attr('readonly', true).removeAttr('required');
        }
    }
    if(toggle_id === 'play-store-dm-status'){

        if ($("#play-store-dm-status").is(':checked')) {
            $('#playstore_url').removeAttr('readonly').attr('required', true);

        } else {
            $('#playstore_url').attr('readonly', true).removeAttr('required');
        }
    }
    if(toggle_id === 'apple-dm-status'){

        if ($("#apple-dm-status").is(':checked')) {
            $('#apple_store_url').removeAttr('readonly').attr('required', true);

        } else {
            $('#apple_store_url').attr('readonly', true).removeAttr('required');
        }
    }


});


