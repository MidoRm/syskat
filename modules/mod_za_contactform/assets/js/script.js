/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2015 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 20/02/2015
# ------------------------------------------------------------------------
*/

(function ($) {
    $(document).ready(function() {

        $('#za-quickcontact-form').submit(function() {
            var value   = $(this).serializeArray(),
            request = {
                'option' : 'com_ajax',
                'module' : 'za_contactform',
                'data'   : value,
                'format' : 'jsonp'
            };
            $.ajax({
                type   : 'POST',
                data   : request,
                beforeSend: function(){
                    $('#za_qc_submit').before('<p class="za_qc_loading"></p>');
                },
                success: function (response) {
                    $('#za_qc_status').hide().html(response).fadeIn().delay(3000).fadeOut(500);
                    $('.za_qc_loading').fadeOut(function(){
                        $(this).remove();
                        $('#za-quickcontact-form').parents('.morph-content').find('span.icon-close').click();
                    });

                }
            });
            return false;
        });

    });
})(jQuery);