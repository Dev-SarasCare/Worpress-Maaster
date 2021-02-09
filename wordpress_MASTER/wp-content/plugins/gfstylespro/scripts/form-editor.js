
window.WLAddOnTitle =   "Styles Pro";
window.WLSettingName =  "gfStylesPro";
window.WLSettingClass = "gfsp_styles";

/** 
 * Warp Lord Gravity Forms Add-on Script for Form Editor
 * Version 1.0
 */


// Add field settings fields
jQuery.each(fieldSettings, function(key) {
    //  No need to add settings for hidden fields
    if ( key != "hidden" && key != "hiddenproduct" && key != "page" ) {
        fieldSettings[key] += ", ." + WLSettingClass;
    }
    // Attach Icons to the following fields
    iconFields = 'address calculation date email fileupload name username number password phone post_category post_content post_excerpt post_image post_title post_tags price quantity select shipping text time website coupon';
    if ( iconFields.indexOf(key) > -1 ) {
        fieldSettings[key] += ", .gfsp_icon";
    }
});


//  Folding Actions
jQuery('.box h3').click(function() {
    
    var container = jQuery('#TB_ajaxContent');

    jQuery('.toggle_open').removeClass('toggle_open');
	if ( jQuery(this).next().css('display') != 'block' ) {
        jQuery('.box h3 + div').slideUp('fast');
        jQuery(this).addClass('toggle_open');

        container.animate({
            scrollTop: jQuery(this).offset().top - container.offset().top - 200 + container.scrollTop()
        });
    }
    jQuery(this).next().slideToggle();
});


//  Binding to the load field settings event to initialize the checkbox
jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
    /* Field Setting: gfStylesPro */
    jQuery("#gf_stylespro_value").attr("value", "");
    jQuery("#gf_stylespro_value").attr("value", field[WLSettingName]);
    jQuery('.' + WLSettingClass+' input').prop('checked', false);
    jQuery('.' + WLSettingClass+' .default').prop('checked', true);

    //  Prepopulate Checkboxes
    if ( field[WLSettingName] ) {
        var pre_pop = field[WLSettingName].split(" ");
        // Combine gfsp_o_list values Since v2.0
        var list_str = '';
        jQuery.each(pre_pop, function(key) {
            if ( pre_pop[key].indexOf('gfsp_o_') == 0 || pre_pop[key].indexOf('o-') == 0 ) {
                list_str = list_str + (list_str == '' ? '' : ' ') + pre_pop[key];
                pre_pop[key] = '';
            }
        });
        pre_pop.push(list_str);

        // Prepopulate now
        jQuery.each(pre_pop, function(key) {
            if (pre_pop[key] != "") {
                jQuery('.' + WLSettingClass+' input[value="' + pre_pop[key] + '"]').prop('checked', true);
            }
        });
    }
    
    // Set states for Effects
    jQuery(".gfsp_effects_wrapper input").attr("disabled", "disabled");
    jQuery("[name=gfsp_o_style]:checked").trigger("change")
    
    //  Hide irrelevant options
    var field_type=field["type"];
    var input_type=field["inputType"];
    var $mod = jQuery(".gf_stylespro_selectors");

    $mod.find(".h").slideUp();
    $mod.find(".h_"+field_type).slideDown();
    $mod.find(".h_"+field_type+"-"+input_type).slideDown();

    /* Field Setting: gfStylesProIcon */
    jQuery("#gf_stylespro_icon_value").attr("value", "");
    jQuery("#gf_stylespro_icon_value").attr("value", field["gfStylesProIcon"]);
    if ( field["gfStylesProIcon"] )
        field_icon_preview_update( field["gfStylesProIcon"] );
    else
        field_icon_preview_update( '' );
    
});



/**
 * 
 * Ornament Editor
 * 
 */

jQuery('.choices_setting')
    .on('input propertychange', '.field-choice-sp_ornament', function () {
        var $this = jQuery(this);
        var i = $this.closest('li.field-choice-row, li.gquiz-choice-row').data('index');

        var field = GetSelectedField();
        field.choices[i].spOrnament = $this.val();
    });
    
gform.addFilter('gform_append_field_choice_option', function (str, field, i) {
    if (field.type != 'radio' && field.type != 'checkbox' && field.type != 'poll' && field.type != 'quiz' && field.type != 'survey' && field.type != 'option' && field.type != 'post_tags' && field.type != 'post_category' && field.type != 'post_custom_field' && field.type != 'product') {
        return str;
    }

    // For fields with multiple input types, we continue only if checkbox or radio
    if (field.type == 'poll' || field.type == 'quiz' || field.type == 'survey' || field.type == 'option' || field.type == 'post_tags' || field.type == 'post_custom_field' || field.type == 'product' || field.type == 'post_category') {
        if (field.inputType != 'checkbox' && field.inputType != 'radio'){
            return str;
        }
    }

    var inputType = GetInputType(field);
    var spOrnament = field.choices[i].spOrnament ? field.choices[i].spOrnament : '';
    

    return "<button id=\"add_gf_stylespro_choice\" class=\"button\" onclick=\"choice_tb_show('" + inputType + "_choice_sp_ornament_" + i + "') \"><i class=\"fa fa-picture-o\"></i></button><input type='hidden' id='" + inputType + "_choice_sp_ornament_" + i + "' value='" + spOrnament + "' class='field-choice-input field-choice-sp_ornament' />" + str;
});


function choice_preview_update(spIcnImg){
    
    jQuery('#gfsp_icon_temp').val(spIcnImg);

    var spIcnImg = spIcnImg.split('|');
    
    // remove index 3 (color) if exists; we append it while saving
    if (spIcnImg[0] === "icn" && spIcnImg[3] !== undefined){
        spIcnImg.pop();
        jQuery('#gfsp_icon_temp').val( spIcnImg.join('|') );
    }

    // remove index 2 (alt_text) if exists; we append it while saving
    if (spIcnImg[0] === "img" && spIcnImg[2] !== undefined){
        spIcnImg.pop();
        jQuery('#gfsp_icon_temp').val( spIcnImg.join('|') );
    }

    if ( spIcnImg[0] == 'icn' ){
        jQuery('.sp_choice_preview').html('<i class="'+ spIcnImg[1] +'"></i>');
        jQuery('.gfsp_color_wrapper').show();

        if (  spIcnImg[2] !== undefined && spIcnImg[2] == "custom" ) {
            jQuery(".ornament_icon_custom").val( spIcnImg[1] );
        }
    }
    else if ( spIcnImg[0] == 'img' ){
        jQuery('.sp_choice_preview').html('<img src="'+ spIcnImg[1] +'"></i>');
        jQuery('.ornament_image').val(spIcnImg[1]);
        // jQuery('.ornament_image_alt').val(spIcnImg[2]);
        jQuery('.gfsp_color_wrapper').hide();
    }
    else {
        jQuery('.sp_choice_preview').html(' ');
    }
}


function field_icon_preview_update(spIcnImg) {
    jQuery('#gfsp_icon_temp').val(spIcnImg);

    var spIcnImg = spIcnImg.split('|');

    // remove index 3 (color) if exists; we add it while saving
    var spIcnColor = '';

    if (spIcnImg[3] !== undefined){
        spIcnColor = spIcnImg.pop();
        jQuery('#gfsp_icon_temp').val( spIcnImg.join('|') );
    }

    if ( spIcnImg[0] == 'icn' ){
        jQuery('.sp_field_icon_preview').html('<i style="color:' + spIcnColor +';"  class="'+ spIcnImg[1] +'"></i>');
        jQuery('.gfsp_color_wrapper').show();
    }
    else if ( spIcnImg[0] == 'img' ){
        jQuery('.sp_field_icon_preview').html('<img src="'+ spIcnImg[1] +'"></i>');
        jQuery('.ornament_image').val(spIcnImg[1]);
        jQuery('.gfsp_color_wrapper').hide();
    }
    else {
        jQuery('.sp_field_icon_preview').html(' ');
    }

    gfspFieldIconUpdate( GetSelectedField() );
}


function choice_tb_show(choice_field) {
    window.spChoice = jQuery('#' + choice_field);
    jQuery('.ornament_image').val('');
    jQuery('.ornament_image_alt').val('');
    jQuery('.ornament_icon_custom').val('');
    jQuery('#gfsp_icon_color').val('').change();
    choice_preview_update( spChoice.val() );
    
    var spChoiceArr = spChoice.val().split('|');
    // since: spChoiceArr = icn|class|iconset|color
    var color = spChoiceArr[3];
    jQuery('#gfsp_icon_color').val(color).change();
    jQuery('.sp_choice_preview').css('color', (color != undefined ? color: 'inherit') );

    // since: spChoiceArr = img|url|alt_text
    if ( spChoiceArr[0] == "img" ) {
        jQuery('.ornament_image_alt').val(spChoiceArr[2]);
    }
    
    tb_show(WLAddOnTitle + ': Icon / Image Selector', '#TB_inline?height=500&width=600&inlineId=add_gf_stylespro_choice_modal', '');
}


function field_icon_tb_show() {
        jQuery('.ornament_image').val('');
        jQuery('.ornament_icon_custom').val('');
        jQuery('#gfsp_icon_color').val('').change();

    if ( field['gfStylesProIcon'] ) {
        choice_preview_update( field['gfStylesProIcon'] );
        jQuery("#gf_stylespro_icon_value").attr("value", field["gfStylesProIcon"]);
        
        // Because: spChoice.val = icn|class|iconset|color
        color = field['gfStylesProIcon'].split('|')[3];
        jQuery('#gfsp_icon_color').val(color).change();
        jQuery('.sp_choice_preview').css('color', (color != undefined ? color: 'inherit') );
    } else {
        choice_preview_update( '' );
    }

    tb_show(WLAddOnTitle + ': Icon / Image Selector', '#TB_inline?height=500&width=600&inlineId=add_gf_stylespro_choice_modal', '');
}


function searchIcons() {
    var searchTerm = jQuery('#gfsp_search_icons').val().toLowerCase();

    if (searchTerm == '') {
        jQuery('.all_icons span').removeClass('hide');
        jQuery('.search_count').text('');
        return;
    }
    jQuery('.all_icons span').addClass('hide');
    jQuery('.all_icons span:contains("' + searchTerm + '")').removeClass('hide');

    // Count v 2.0.3
    jQuery('.gfsp_icons').each( function()
        {
            var total = jQuery(this).find('.all_icons span').length;
            var count = jQuery(this).find('span:contains("' + searchTerm + '")').length;
            count = ( (count > 0 && count < total) ? '('+count+')' : '')  	
            jQuery(this).prev().find('.search_count').text(count);
        }
    );
}


jQuery('#gfsp_search_icons').on('input', function() {
    searchIcons();
});


jQuery('.ornament_image').on('change blur', function() {
    choice_preview_update('img|' + jQuery(this).val());
});



// Media uploader
var sp_media_init = function(selector, button_selector) {
    var clicked_button = false;

    jQuery(selector).each(function (i, input) {
        var button = jQuery(input).next(button_selector);
        button.click(function (event) {
            event.preventDefault();
            var selected_img;
            clicked_button = jQuery(this);

            // check for media manager instance
            if(wp.media.frames.gk_frame) {
                wp.media.frames.gk_frame.open();
                return;
            }
            // configuration of the media manager new instance
            wp.media.frames.gk_frame = wp.media({
                title: 'Select image',
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: 'Use selected image'
                }
            });

            // Function used for the image selection and media manager closing
            var gk_media_set_image = function() {
                var selection = wp.media.frames.gk_frame.state().get('selection');

                // no selection
                if (!selection) {
                    return;
                }

                // iterate through selected elements
                selection.each(function(attachment) {
                    var url = attachment.attributes.url;
                    clicked_button.prev(selector).val(url);
                    choice_preview_update('img|' + url);
                });
            };

            // closing event for media manger
            wp.media.frames.gk_frame.on('close', gk_media_set_image);
            // image selection event
            wp.media.frames.gk_frame.on('select', gk_media_set_image);
            // showing media manager
            wp.media.frames.gk_frame.open();
        });
    });
};
sp_media_init('.ornament_image', '.media-button');


jQuery(document).ready( function(){
    jQuery('#gfsp_icon_color').wpColorPicker({
        change: function(event, ui){
            jQuery('.sp_choice_preview').css('color', ui.color.toString() );
        },
        clear: function(event){
            jQuery('.sp_choice_preview').removeAttr('style')
        }
    });
} );



/* Save settings to the choice */
function gfsp_ornament_save() {
    
    var color = jQuery('#gfsp_icon_color').val();
    var tempVal = jQuery('#gfsp_icon_temp').val();

    // add color if present and icon
    if (color != '' && color != undefined && tempVal.indexOf('icn') == 0)
        tempVal = tempVal + "|" + color;

    fieldType = GetSelectedField().type;
    inputType = GetSelectedField().inputType;
    if ( fieldType == 'radio' || fieldType == 'checkbox' || fieldType == 'poll' || fieldType == 'quiz' || (((fieldType == 'option' || fieldType == 'post_tags' || fieldType == 'post_custom_field' || fieldType == 'product' || fieldType == 'survey' || fieldType == 'post_category') && (inputType == 'checkbox' || inputType == 'radio'))) )
    {
        // add Image Alt if a Choice Ornament
        var imageAlt = jQuery("#gfsp_ornament_image_alt").val();

        if ( tempVal.indexOf('img') == 0 && imageAlt !== "" ) {
            tempVal = tempVal + "|" + imageAlt;
        }

        spChoice.val( tempVal ).trigger('input');
    }
    else
    {
        SetFieldProperty('gfStylesProIcon', tempVal);
        jQuery("#gf_stylespro_icon_value").attr("value", tempVal);
        field_icon_preview_update(tempVal);
    }
    tb_remove();
}

/* Save settings to field */
function gfsp_save() {
    var classes = [];
    jQuery("#gf_stylespro_current_modal input:checked:not(:disabled)").each( function(){
        if ( jQuery(this).val() ) {
            var cls=jQuery(this).val();
            classes.push(cls);
        }
    });

    jQuery('#gf_stylespro_value').val( classes.join(" ") );
    SetFieldProperty('gfStylesPro', classes.join(" "));
    tb_remove();
    /* Update choices preview incase ornaments position changes */
    UpdateFieldChoices(GetInputType(field));
}

/* Conditional effects show/hide */
jQuery("[name=gfsp_o_style]").on("change", function() {
    var id = jQuery(this).attr("id");
    jQuery(".gfsp_effects_wrapper input").each( function(i, e) {
        var showFor = jQuery(e).data().showfor,
            hideFor = jQuery(e).data().hidefor;

        var showMatch = true,
            hideMatch = false;

        if ( showFor.length > 0) {
            showMatch = showFor.split(" ").reduce( function(total, cVal){ return total + (id.indexOf(cVal) > -1) }, 0 ) > 0;
        }
        if ( hideFor.length > 0 ) {
            hideMatch = hideFor.split(" ").reduce( function(total, cVal){ return total + (id.indexOf(cVal) > -1) }, 0 ) > 0;
        }

        if ( (showMatch && !hideMatch) ) {
            jQuery(e).removeAttr("disabled");
        } 
        else {
            jQuery(e).attr("disabled", "disabled");
        }
        
    });
});

// Icon Selection
jQuery('.all_icons span').click( function() {
    icnClass = jQuery(this).find('i').attr('class');
    if (icnClass != ''){
        type = jQuery(this).closest('.all_icons').data('iconset');
        choice_preview_update('icn|' + icnClass + "|" + type);
        }
    else
        choice_preview_update('');
} );


// Icon Selection
jQuery('.icon-custom-set').click( function() {
    var icnClass = jQuery(".ornament_icon_custom").val();
    if (icnClass != ''){
        var type = "custom";
        choice_preview_update('icn|' + icnClass + "|" + type);
    }
    else
        choice_preview_update('');
} );








/**
 * Live update choices ornaments
 * */
function gfspChoicesObserve(fld){
    // create an observer instance
    var observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        var index = 0;
        field = GetSelectedField();

        oAfter = (field[WLSettingName] !== undefined && field[WLSettingName].indexOf('o_after') > -1);
        jQuery(mutation.addedNodes).each( function(){

            field = GetSelectedField();
            
            if (field.choices[index].spOrnament != undefined && field.choices[index].spOrnament != '') {

                ornamentArr = field.choices[index].spOrnament.split('|');
                if (ornamentArr[0] == 'icn'){
                    ornament = '<i class="o_icn_preview '+ ornamentArr[1] +'" style="color:'+ ornamentArr[3] +'"></i>'
                }
                if (ornamentArr[0] == 'img'){
                    ornament = '<div class="o_img_wr"><img class="gfsp_label_img" src="'+ ornamentArr[1]+'"></div>';
                }

                if (oAfter) {
                    jQuery(ornament).appendTo( jQuery(this).find('label') );		
                } else {
                    jQuery(ornament).prependTo( jQuery(this).find('label') );		
                }
            }

            index += 1;
        });
      });
    });
    // configuration of the observer:
    var config = { attributes: false, childList: true, characterData: false };

    // pass in the target node, as well as the observer options
    observer.observe(fld, config);
}

// Observe on form load
jQuery('.ginput_container > ul').each( function() {
	gfspChoicesObserve(this);
});

// Observe choices in newly added fields
jQuery(document).bind( 'gform_field_added', function( event, form, field ) {
    jQuery( '#field_' + field['id'] + ' .ginput_container > ul').each( function() {
        gfspChoicesObserve(this);
    });
} );


/*
 * Update Field Icon
 * */

// Use this function for field loop on page load and on icon change save
function gfspFieldIconUpdate(fld) {
	// If the value was never defined, stop
    if ( fld.gfStylesProIcon == undefined || fld.inputType == 'checkbox' || fld.inputType == 'radio') {
    return true;
    }

    var $addTo = jQuery('#field_' + fld.id + ' .ginput_container');
	$addTo.removeClass('has_icon');
	$addTo.find('.gfsp_icon').remove();

	// If the value is changed to empty, stop
    if ( fld.gfStylesProIcon == '' ) {
        return true;
    }

    var icnHtml = '';

    // since: spChoice.val = icn|class|iconset|color
    icnArr = fld.gfStylesProIcon.split('|');
    if (icnArr[0] == 'icn') {
        icnHtml = '<span class="gfsp_icon"><i class="'+ icnArr[1] +' iconset_'+icnArr[2]+'" style="color: '+ icnArr[3] +'"></i></span>'
    } else if (icnArr[0] == 'img') {
        icnHtml = '<span class="gfsp_icon"><i class="gfsp_icn_img" style=\'background-image:url("'+ icnArr[1] +')"\'></i></span>'        
    }

    // Add only to the first input on Date and Time type fields
    if (fld.type == 'date' || (fld.type == 'post_custom_field' && fld.inputType == 'date') ){
		if (fld.dateType == "datepicker")
			$addTo = jQuery('#field_' + fld.id + ' #gfield_input_datepicker');
		else
			$addTo = jQuery('#field_' + fld.id + ' #input_' + fld.id);
    }

    if (fld.type == 'time' || (fld.type == 'post_custom_field' && fld.inputType == 'time') ){
			$addTo = jQuery('#field_' + fld.id + ' #input_' + fld.id);
	}

	$addTo.addClass('has_icon');
        jQuery($addTo).prepend(icnHtml);
}


jQuery(form.fields).each( function() {
    gfspFieldIconUpdate(this);
});
