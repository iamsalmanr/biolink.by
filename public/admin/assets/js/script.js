(function ($) {
    "use strict";

    $(document).on('ready', function() {
        // load google font
        var quick_load_css = function (id, url) {
            if (!document.getElementById('')) {
                var l = document.getElementsByTagName("head")[0], o = document.createElement("link");
                o.id = id, o.rel = "stylesheet", o.type = "text/css", o.href = url, l.appendChild(o)
            }
        };
        quick_load_css("quick-google-font","//fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,700,700i,800,800i&display=swap");
    });

    $(".mobile-toggle").on('click', function () {
        $(".nav-menus").toggleClass("open");
    });

    // Button ripple effect
    $('.quick-ripple-effect, .quick-ripple-effect-dark').on('click', function (e) {
        var rippleDiv = $('<span class="quick-ripple-overlay">'), rippleOffset = $(this).offset(),
            rippleY = e.pageY - rippleOffset.top, rippleX = e.pageX - rippleOffset.left;
        rippleDiv.css({
            top: rippleY - (rippleDiv.height() / 2),
            left: rippleX - (rippleDiv.width() / 2)
        }).appendTo($(this));
        window.setTimeout(function () {
            rippleDiv.remove();
        }, 800);
    });

    // tooltip
    tippy('body', {
        target: '[data-tippy-placement]',
        delay: 100,
        arrow: true,
        arrowType: 'sharp',
        size: 'regular',
        duration: 200,
        animation: 'shift-away',
        animateFill: true,
        theme: 'dark',
        interactive: true,
        distance: 10
    });

    // check all
    var $action_btn = $(".site-action");
    $(document).on('change', '#quick-checkbox-all', function () {
        $('.quick-check').prop('checked',$(this).is(":checked")).trigger('change');
    })

    // action button
    .on('change', '.quick-check', function () {
        $('.quick-check:checked').length > 0 ? $action_btn.addClass('active') : $action_btn.removeClass('active');

        $('#quick-checkbox-all').prop(
            'checked',
            $('.quick-check:not(:checked)').length == 0
        );
    });
    $action_btn.find('.back-icon').on('click', function () {
        $action_btn.removeClass('active');
    });

    // multi select
    var $multi_select = $('.quick-multi-select');
    if($multi_select.length){
        var select_all = $multi_select.data('select-all') || false;
        $multi_select.multiselect({
            showCheckbox: false,  // display the checkbox to the user
            search: true, // include option search box
            selectAll: select_all, // add select all option
            minHeight: 20,
            maxPlaceholderOpts: 2
        });
    }

    // Sidepanel
    var $body = $('body'),
        $backdrop = $('<div class="slidePanel-wrapper" style="display:none"/>');

    var is_rtl = $('html').attr('dir') === 'rtl';
    $(document).on("click", "[data-toggle=slidePanel]", function (e) {
        e.stopPropagation();
        e.preventDefault();

        var $btn = $(this);
        $.slidePanel.show({url: $(this).data("url"), settings: {cache: false}}, {
            direction: is_rtl ? 'left' : 'right',
            template: function (options) {
                return '<div class="' + options.classes.base + " " + options.classes.base + "-" + options.direction + '"><div class="' + options.classes.base + '-scrollable"><div><div class="' + options.classes.content + '"></div></div></div><div class="' + options.classes.base + '-handler"></div></div>'
            }, afterLoad: function () {
                this.$panel.find('.preloader').hide();
                var call = $btn.attr('data-event');
                if (call != undefined) {
                    var fn = window[call];
                    fn(this.$panel);
                } else {
                    if (typeof bookmeSidePanelLoaded != "undefined") {
                        bookmeSidePanelLoaded(this.$panel);
                    }
                }

            }, beforeLoad: function () {
                this.$panel.find('.preloader').show();
                $body.css('overflow-y', 'hidden');
                $body.append($backdrop);
                $('.slidePanel-wrapper').fadeIn();
            }, afterHide: function () {
                $body.css('overflow-y', 'auto');
            }, beforeHide: function () {
                $('.slidePanel-wrapper').fadeOut(300, function () {
                    $(this).remove();
                });
            },
            closeSelector: ".slidePanel-close",
            mouseDragHandler: ".slidePanel-handler",
            loading: {
                template: function (options) {
                    return '<div class="' + options.classes.loading + '"><div class="cssload-speeding-wheel"></div></div>'
                }, showCallback: function (options) {
                    this.$el.addClass(options.classes.loading + "-show")
                }, hideCallback: function (options) {
                    this.$el.removeClass(options.classes.loading + "-show")
                }
            }
        });
    }).on("click", ".slidePanel-wrapper", function (e) {
        $.slidePanel.hide();
    });

})(jQuery);

/* Public functions */
function toggleFullScreen() {
    if ((document.fullScreenElement) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}


function quick_alert(message, type) {
    if (message) {
        if (typeof type == 'undefined')
            type = 'success';


        var $container = jQuery('.quick-alert-area');
        if ($container.length == 0) {
            $container = jQuery('<div class="quick-alert-area"></div>').appendTo('body');
        }

        var class_name = 'quick-alert-' + type;
        var alert_type = 'Success';
        if(type == 'error')
            alert_type = 'Error';
        else if(type == 'info')
            alert_type = 'Info';

        var $alert = jQuery('<div role="alert" class="alert">' +
            '            <div class="d-flex">\n' +
            '                <i class="quick-alert-icon ' + class_name + '"></i>' +
            '                <div class="quick-alert-text">' +
            '                    <h2 class="quick-alert-title">' + alert_type + '</h2>' +
            '                    <p class="quick-alert-message">' + message + '</p>' +
            '                    <div class="close">&times;</div>' +
            '                </div>' +
            '            </div>' +
            '        </div>');
        $alert.appendTo($container).fadeIn().css('transform', 'translate3d(0%, 0px, 0px)');

        if (type == 'success') {
            setTimeout(function () {
                remove_alert($alert);
            }, 5000);
        }
        $alert.find('.close').on('click', function (e) {
            e.preventDefault();
            remove_alert();
        });

        function remove_alert() {
            $alert.css('transform', jQuery('html').attr('dir') == 'rtl' ? 'translate3d(-100%, 0px, 0px)' : 'translate3d(100%, 0px, 0px)').fadeOut(200, function () {
                $alert.remove();
            });
        }
    }
}


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
