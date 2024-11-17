jQuery(function ($) {
    "use strict";

    /**************
     * copy shortcode
     * *************/
    $('#share-copy').on('click',function () {
        $(".copy-input").select();
        document.execCommand("copy");
    });

    /* Animations */
    new WOW().init();
});
