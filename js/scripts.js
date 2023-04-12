'use strict';

let ENTITY = {

    init: function init() {

        ENTITY.save_form();
    },

    save_form: function save_form() {

        $('#form').submit( function( e ) {

            e.preventDefault();
            let data = {
                action     : 'ut_save_form',
                ajax_nonce : ut_params.ajax_nonce,
                form       : $('#form').serialize(),
            };

            $.ajax({
                url  : ut_params.ajaxurl,
                data : data,
                type : 'POST',
                beforeSend: function() {
                    let overlay = $('<div id="overlay_form"><img src="' + ut_params.get_template_directory_uri + '/images/preloader.gif"></div>');
                        overlay.appendTo('#form');
                    $('button[name="form"]').attr( "disabled", true ); 
                },
                success: function( response ) {

                    if ( response.success ) {
                        $('#overlay_form').remove();
                        $('button[name="form"]').removeAttr("disabled");
                    }
                }
            });
        });
    },

};

$(document).ready( ENTITY.init() );