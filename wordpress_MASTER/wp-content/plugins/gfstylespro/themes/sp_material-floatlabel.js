
function maybeFloatLabel(field, event) {
    if (event == 'focus' || field.val() != '' ) {
        field.closest('.ginput_container').addClass('float_label')		
    } else {
        field.closest('.ginput_container').removeClass('float_label')
    }
}

function maybeFloatComplexLabel(field, event) {
    if (event == 'focus' || field.val() != '' ) {
        field.closest('span').addClass('float_label')		
    } else {
        field.closest('span').removeClass('float_label')
    }
}

jQuery(document).bind('gform_post_render', function(e, form_id) {
    
    jQuery('.ginput_container_text, .ginput_container_number, .ginput_container_textarea, .ginput_container_select, .ginput_container_date, .ginput_container_address, .ginput_container_email, .ginput_container_name, .ginput_container_phone, .ginput_container_website')
    .each( function() {


        if ( jQuery(this).hasClass('ginput_complex') ) {

            jQuery(this).find('span')
            .each( function( i, field_container ) {


                field = jQuery(field_container).find('input:not([readonly]), select:not([readonly])');

                field_type = field.is("select") ? "select" : field.attr('type');

                switch ( field_type ) {
                    case "text":
                    case "type":
                    case "number":
                    case "tel":
                    case "email":
                        
                        jQuery(field_container).addClass('floatable_label');

                        maybeFloatComplexLabel(field);
                        field.on('input paste propertychange focus blur change select', function(event) { maybeFloatComplexLabel( jQuery(this), event.type ) } )

                        break;
                    case "select":

                        if ( field.find(":selected").text() == "" ) {
                            jQuery(field_container).addClass('floatable_label');

                            maybeFloatComplexLabel(field);
                            field.on('input paste propertychange focus blur change select', function(event) { maybeFloatComplexLabel( jQuery(this), event.type ) } )
                                
                        }

                        break;
                
                    default:
                        break;
                }
                
                
            } );


        }


        else {

            field = jQuery(this).find('input:not([readonly]), select:not([readonly]), textarea:not([readonly])');

            if ( ! jQuery(this).prev().hasClass('gfield_label') ) {
                field_type = "not_supported";
            } else {
                // Get nodeName if select or textarea, otherwise it's input, get its type
                field_type = ( field.is("select") || field.is("textarea") ) ? field.get(0).nodeName.toLowerCase() : field.attr('type');
            }

            switch ( field_type ) {
                case "text":
                case "type":
                case "number":
                case "tel":
                case "url":
                case "email":
                case "textarea":
                    
                    jQuery(this).prev('.gfield_label').prependTo ( jQuery(this) );
                    jQuery(this).addClass('floatable_label');

                    maybeFloatLabel(field);
                    field.on('input paste propertychange focus blur change select', function(event) { maybeFloatLabel( jQuery(this), event.type ) } )

                    break;

                case "select":
                    if ( field.find(":selected").text() == "" ) {

                        jQuery(this).prev('.gfield_label').prependTo ( jQuery(this) );
                        jQuery(this).addClass('floatable_label');

                        maybeFloatLabel(field);
                        field.on('input paste propertychange focus blur change select', function(event) { maybeFloatLabel( jQuery(this), event.type ) } )
                            
                    }

                    break;
            
                default:
                    break;
            }

        }
    });
    jQuery("#gform_fields_" + form_id + " :focus").focus()
}); // gform_post_render