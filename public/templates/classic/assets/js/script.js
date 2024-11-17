jQuery(function ($) {
    "use strict";

    /* Cookie Consent */
    $('.cookieAcceptButton').on('click', function () {
        var expires = new Date();
        expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
        document.cookie = 'quick_cookie_accepted' + '=' + '1' + ';expires=' + expires.toUTCString() + "; path=/";
        $('.cookieConsentContainer').fadeOut();
    });

    /* Any Ajax Submit Form */
    $(document).on("submit", "#ajax_submit_form, .ajax_submit_form", function (e) {
        e.preventDefault();
        var $form = $(this),
            action = $form.attr('action'),
            loader = $form.find('[type="submit"]'),
            options = {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:  action,
                dataType:  'json',
                success:   function(response){
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        if ($form.parents(".modal").length) {
                            $form.parents(".modal").modal('hide');
                        }
                        if ($('#bioframe').length) {
                            $('#bioframe').attr('src', function(i, val) { return val; });
                        }
                    } else {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#ee5252'
                        });
                    }
                    loader.removeClass('quick-loader').prop('disabled',false);
                }
            };
        loader.addClass('quick-loader').prop('disabled',true);
        $form.ajaxSubmit(options);
    });

    /**
     * Pricing Switcher
     * Enables monthly/yearly switcher seen on pricing tables
     */
    $('.billing-cycle-radios').on("click", function () {
        if ($('.billed-yearly-radio input').is(':checked')) {
            $('.pricing-table').addClass('billed-yearly').removeClass('billed-lifetime');

            $('.pricing-plan').show();
            $('.pricing-plan[data-annual-price="0"]').hide();
        }
        if ($('.billed-monthly-radio input').is(':checked')) {
            $('.pricing-table').removeClass('billed-yearly').removeClass('billed-lifetime');

            $('.pricing-plan').show();
            $('.pricing-plan[data-monthly-price="0"]').hide();
        }
        if ($('.billed-lifetime-radio input').is(':checked')) {
            $('.pricing-table').addClass('billed-lifetime').removeClass('billed-yearly');

            $('.pricing-plan').show();
            $('.pricing-plan[data-lifetime-price="0"]').hide();
        }
    });
    $('.billing-cycle-radios input').first().trigger('click');

    //Change Avatar
    let avatarInput = $('#change_avatar'),
        targetedImagePreview = $('#imagePreview');
    if (avatarInput.length) {
        avatarInput.on('change', function() {
            var file = true,
                readLogoURL;
            if (file) {
                readLogoURL = function(input_file) {
                    if (input_file.files && input_file.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            targetedImagePreview.css('background-image', 'url(' + e.target.result + ')');
                        }
                        reader.readAsDataURL(input_file.files[0]);
                    }
                }
            }
            readLogoURL(this);
        });
    }
});

/**
 * read url from input type and show image
 *
 * @param {selector} input
 * @param {string} id
 */
function readURL(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+id).attr('src', e.target.result);
            $('#'+id).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
