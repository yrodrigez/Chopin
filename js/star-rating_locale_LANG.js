/*!
 * Star Rating <LANG> Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-star-rating
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";
    $.fn.ratingLocales['<LANG>'] = {
        defaultCaption: '{rating} Estrellas',
        starCaptions: {
            0.5: 'Media estrella',
            1: 'Una estrella',
            1.5: 'Una estrella y media',
            2: 'Dos estrellas',
            2.5: 'Dos estrellas y media',
            3: 'Tres estrellas',
            3.5: 'Tres estrellas y media',
            4: 'Cuatro estrellas',
            4.5: 'Cuatro estrellas y media',
            5: '¡Cinco Estrellas!'
        },
        clearButtonTitle: 'Limpiar',
        clearCaption: 'Sin Valorar'
    };
})(window.jQuery);
