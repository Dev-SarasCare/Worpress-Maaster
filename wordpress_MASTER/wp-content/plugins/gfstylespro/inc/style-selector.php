<li class="gfsp_styles field_setting">
    <label for="field_admin_label" class="section_label">
        <?php _e( $this->_short_title, 'gf_stylespro' ); ?>
        <?php gform_tooltip( 'gf_stylespro_value' ) ?>
    </label>
    <button id="add_gf_stylespro_styles" class="button" onclick="tb_show('Styes Pro: Style Selector', '#TB_inline?height=600&width=820&inlineId=gf_stylespro_modal', '');">Styles Selector</button>
    <input type="hidden" id="gf_stylespro_value" value="" />
    <!-- Modal -->
    <div id="gf_stylespro_modal" style="display: none">
    <div class="gf_stylespro_selectors" id="gf_stylespro_current_modal">
    <div class="gf_stylespro_bg"></div>
    <div class="box">
    <?php

    // If not theme is selected; show warning
    if ( empty($theme) || $theme == "none" ) {
        echo '<div style="border: 1px solid red; padding: 5px 10px;">
        <i>Styles Pro is not enabled for this form. These styles only work in conjunction with it.<br>Go to Form settings > <a href='.
        admin_url( "admin.php?page=gf_edit_forms&view=settings&subview=gf_stylespro&id={$form_id}" ) . '>Styles Pro</a> to enable it.</i>
        </div>';
    }

    ?>
    <h3 class="toggle_open">Layout</h3>
    <div class="layout">
        <input id="gfsp_full" class="has_img default" type="radio" name="gfsp_layout" value="">
            <label for="gfsp_full" data-hover="Full width"><?php self::icn_img("full.png"); ?></label>
        <input id="gf_half" class="has_img" type="radio" name="gfsp_layout" value="gf_half">
            <label for="gf_half" data-hover="Half"><?php self::icn_img("half.png"); ?></label>
        <input id="gf_third" class="has_img" type="radio" name="gfsp_layout" value="gf_third">
            <label for="gf_third" data-hover="Third"><?php self::icn_img("third.png"); ?></label>
        <input id="gf_third_two" class="has_img" type="radio" name="gfsp_layout" value="gf_third_two">
            <label for="gf_third_two" data-hover="2 Thirds"><?php self::icn_img("twothird.png"); ?></label>
        <input id="gf_quarter" class="has_img" type="radio" name="gfsp_layout" value="gf_quarter">
            <label for="gf_quarter" data-hover="Quarter"><?php self::icn_img("fourth.png"); ?></label>
        <input id="gf_inline" class="has_img" type="radio" name="gfsp_layout" value="gf_inline">
            <label for="gf_inline" data-hover="Inline"><?php self::icn_img("inline.png"); ?></label>
    </div>
    <h3>Position</h3>
    <div class="float" style="display: none">
        <input id="gf_newline" class="has_img" type="checkbox" name="gf_newline" value="gf_newline">
            <label for="gf_newline" data-hover="New line"><?php self::icn_img("newline.png"); ?></label>
        <br/>
        <input id="float_none" class="has_img default" type="radio" name="gfsp_float" value="">
            <label for="float_none" data-hover="None"><?php self::icn_img("none.png"); ?></label>
        <input id="gf_left" class="has_img" type="radio" name="gfsp_float" value="gf_left">
            <label for="gf_left" data-hover="Float left"><?php self::icn_img("float-left.png"); ?></label>
        <input id="gf_right" class="has_img" type="radio" name="gfsp_float" value="gf_right">
            <label for="gf_right" data-hover="Float right"><?php self::icn_img("float-right.png"); ?></label>
        <input id="gf_invisible" type="radio" name="gfsp_float" value="gf_invisible">
            <label for="gf_invisible" title="Off screen">Make invisible</label>
        <input id="gf_hidden" type="radio" name="gfsp_float" value="gf_hidden">
            <label for="gf_hidden" title="Uses display: none">Hidden</label>
    </div>
                
    <h3 class="gfsp_field_icon h h_time h_date h_tel h_phone h_text h_select h_address h_name h_number h_tel h_textarea h_email h_title h_fileupload h_post_category-select h_post_image h_post_title h_post_tags-text h_post_tags-select h_post_custom_field-text h_post_custom_field-select h_post_custom_field-number h_post_custom_field-date h_post_custom_field-time h_post_custom_field-phone h_post_custom_field-website h_post_custom_field-email h_post_custom_field-fileupload h_post_custom_field-website">Field icon</h3>
    <div class="gfsp_field_icon h" style="display: none">
        
        <input id="gf_icn_default" class="has_img default" type="radio" name="gf_icn" value="">
            <label for="gf_icn_default" data-hover="Default"><?php self::icn_img("icn-default.png"); ?></label>
        
        <input id="gf_icn_theme" class="has_img" type="radio" name="gf_icn" value="gf_icn_theme">
            <label for="gf_icn_theme" style="display: none;" data-hover="Theme"><?php self::icn_img("icn-default.png"); ?></label>
            
        <input id="gf_icn_border" class="has_img" type="radio" name="gf_icn" value="gf_icn_border">
            <label for="gf_icn_border" data-hover="Border"><?php self::icn_img("icn-border.png"); ?></label>

        <input id="gf_icn_bs" class="has_img" type="radio" name="gf_icn" value="gf_icn_bs">
            <label for="gf_icn_bs" data-hover="Bootstrap-like"><?php self::icn_img("icn-bs.png"); ?></label>

        <input id="gf_icn_inset" class="has_img" type="radio" name="gf_icn" value="gf_icn_inset">
            <label for="gf_icn_inset" data-hover="Inside the field"><?php self::icn_img("icn-inset.png"); ?></label>
        
        <br />

        <input id="gf_icn_large" type="checkbox" name="gf_icn_large" value="gf_icn_large">
            <label for="gf_icn_large">Larger icon</label>

        <h4>Placement</h4>
        
        <input id="gf_icon_before" type="radio" class="default has_img" name="gf_icon_after" value="">
            <label for="gf_icon_before" data-hover="Before the field"><?php self::icn_img("icn-before.png"); ?></label>

        <input id="gf_icon_after" type="radio" class="has_img" name="gf_icon_after" value="gf_icon_after">
            <label for="gf_icon_after" data-hover="After the field"><?php self::icn_img("icn-after.png"); ?></label>


    </div>

    <h3 class="gfsp_special_tab">Special</h3>
    <div class="gfsp_special" style="display: none">

        <input id="gf_scroll_text" type="checkbox" name="gf_scroll_text" value="gf_scroll_text">
            <label for="gf_scroll_text" class="h h_html h_section" style="display: none;">Scroll text</label>

        <input id="gf_hide_ampm" type="checkbox" name="gf_hide_ampm" value="gf_hide_ampm">
            <label for="gf_hide_ampm" class="h h_time" style="display: none;">Hide am/pm</label>

        <input id="gf_hide_charleft" type="checkbox" name="gf_hide_charleft" value="gf_hide_charleft">
            <label for="gf_hide_charleft" class="h h_text h_textarea h_number" style="display: none;">Hide charachters left</label>

        <input id="gf_hide_label" type="checkbox" name="gf_hide_label" value="gf_hide_label">
            <label for="gf_hide_label">Hide label</label>

        <input id="gf_hide_o_text" type="checkbox" name="gf_hide_o_text" value="gf_hide_o_text">
            <label for="gf_hide_o_text" style="display: none;" class="h h_checkbox h_radio h_product h_option h_post_tags-checkbox h_post_tags-radio h_post_custom_field-checkbox h_post_custom_field-radio h_product-checkbox h_product-radio">Hide choice label (image/icon only)</label>

        <input id="gf_label_inline" type="checkbox" name="gf_label_inline" value="gf_label_inline">
            <label for="gf_label_inline"
                data-warning="Use it with fields that are wide enough to contain the labels and the inputs"
            >Inline label</label>

        <input id="gf_hide_complex_label" type="checkbox" name="gf_hide_complex_label" value="gf_hide_complex_label">
            <label for="gf_hide_complex_label" class="h h_address h_name h_creditcard h_email h_date" style="display: none;">Hide inner labels</label>

    </div>

    <h3 class="gfsp_lists_tab h h_checkbox h_radio h_poll h_quiz h_option h_post_tags-checkbox h_post_tags-radio h_post_custom_field-checkbox h_post_custom_field-radio h_post_category-checkbox h_post_category-radio h_product-checkbox h_product-radio h_survey-checkbox h_survey-radio">Columns</h3>
    <div class="gfsp_lists h" style="display: none">
        <input id="gf_list_full" class="has_img default" type="radio" name="gfsp_list_col" value="">
            <label for="gf_list_full" data-hover="1 column"><?php self::icn_img("list-none.png"); ?></label>
        <input id="gf_list_2col" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_2col">
            <label for="gf_list_2col" data-hover="2 columns"><?php self::icn_img("list2.png"); ?></label>
        <input id="gf_list_3col" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_3col">
            <label for="gf_list_3col" data-hover="3 columns"><?php self::icn_img("list3.png"); ?></label>
        <input id="gf_list_4col" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_4col">
            <label for="gf_list_4col" data-hover="4 columns"><?php self::icn_img("list4.png"); ?></label>
        <input id="gf_list_5col" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_5col">
            <label for="gf_list_5col" data-hover="5 columns"><?php self::icn_img("list5.png"); ?></label>
        <input id="gf_list_6col" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_6col">
            <label for="gf_list_6col" data-hover="6 columns"><?php self::icn_img("list6.png"); ?></label>
        <input id="gf_list_inline" class="has_img" type="radio" name="gfsp_list_col" value="gf_list_inline" title="Inline">
            <label for="gf_list_inline" data-hover="Automatic (inline)"><?php self::icn_img("listinline.png"); ?></label>
        
        <h4>Ignore Screen Breakpoints</h4>

        <input id="gf_list_col-ex_medium" type="checkbox" name="gf_list_col-ex_medium" value="gf_list_col-ex_medium">
            <label for="gf_list_col-ex_medium" data-warning="This option ignores medium screen breakpoint (like tablets); where column numbers are usually lowered.&#10;Ex: 6 columns becomes 3; 4 becomes 2">Medium screens</label>

        <input id="gf_list_col-ex_small" type="checkbox" name="gf_list_col-ex_small" value="gf_list_col-ex_small">
            <label for="gf_list_col-ex_small" data-warning="This option ignores small screen breakpoint (like mobiles); where column numbers are even lowered, sometimes to a single option per row.&#10;Ex: 6 columns becomes 2; 3 becomes 1; inline becomes 1">Small screens</label>
    </div>

    <h3 class="gfsp_lists_tab h h_checkbox h_radio h_poll h_quiz h_option h_post_tags-checkbox h_post_tags-radio h_post_custom_field-checkbox h_post_custom_field-radio h_post_category-checkbox h_post_category-radio h_product-checkbox h_product-radio h_survey-checkbox h_survey-radio h_consent">Style</h3>
    <div class="gfsp_lists h" style="display: none">
        <input id="gfsp_theme_default" class="has_img default" type="radio" name="gfsp_o_style" value="">
            <label for="gfsp_theme_default" data-hover="Theme default"><?php self::icn_img("none.png"); ?></label>
        <input id="gfsp_toggle" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_toggle">
            <label for="gfsp_toggle" data-hover="Material Toggle"><?php self::icn_img("list-toggle.png"); ?></label>
        <input id="gfsp_ios" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_ios">
            <label for="gfsp_ios" data-hover="iOS Toggle"><?php self::icn_img("list-ios.png"); ?></label>
        <input id="gfsp_draw" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_draw">
            <label for="gfsp_draw" data-hover="Draw"><?php self::icn_img("list-draw.png"); ?></label>
        <input id="gfsp_dot" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_dot">
            <label for="gfsp_dot" data-hover="Dot"><?php self::icn_img("list-dot.png"); ?></label>
        <input id="gfsp_flip" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_flip">
            <label for="gfsp_flip" data-hover="Flip"><?php self::icn_img("list-flip.png"); ?></label>
        <input id="gfsp_default" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_default">
            <label for="gfsp_default" data-hover="Browser default"><?php self::icn_img("list-default.png"); ?></label>
        <p>Overall styles <i>(designed to be used with icons and images)</i></p>
        <input id="gfsp_o_frame" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg">
            <label for="gfsp_o_frame" data-hover="Frame"><?php self::icn_img("o-frame.png"); ?></label>

        <input id="gfsp_o_frame-ticktopright" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-notick o-ticktopright">
            <label for="gfsp_o_frame-ticktopright" data-hover="Frame (top tick)"><?php self::icn_img("o_frame_ticktopright.png"); ?></label>
        <input id="gfsp_o_frame-notick" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-notick">
            <label for="gfsp_o_frame-notick" data-hover="Frame (no tick)"><?php self::icn_img("o_frame_notick.png"); ?></label>

        <input id="gfsp_o_list" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_list o-custom-bg">
            <label for="gfsp_o_list" data-hover="List"><?php self::icn_img("o-list.png"); ?></label>
        <input id="gfsp_o_list-round" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_list o-round o-custom-bg">
            <label for="gfsp_o_list-round" data-hover="List (Round)"><?php self::icn_img("o-list-round.png"); ?></label>
        <input id="gfsp_o_list-join" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_list o-join o-custom-bg">
            <label for="gfsp_o_list-join" data-hover="List (Joined)"><?php self::icn_img("o-list-join.png"); ?></label>
        <input id="gfsp_o_list-round-join" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_list o-round o-join o-custom-bg">
            <label for="gfsp_o_list-round-join" data-hover="List (Round &amp; Joined)"><?php self::icn_img("o-list-round-join.png"); ?></label>
        <input id="gfsp_o_shade" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_shade">
            <label for="gfsp_o_shade" data-hover="Shade"><?php self::icn_img("o-shade.png"); ?></label>
        <input id="gfsp_o_shade-round" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_shade o-round">
            <label for="gfsp_o_shade-round" data-hover="Shade (Round)"><?php self::icn_img("o-shade-round.png"); ?></label>
        <input id="gfsp_o_frame-shadowbox" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-shadowbox o-notick o-custom-border">
            <label for="gfsp_o_frame-shadowbox" data-hover="Shadow box"><?php self::icn_img("o_frame_shadowbox.png"); ?></label>

        <!-- NEW -->

        <input id="gfsp_o_frame-textoverlay" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay">
            <label for="gfsp_o_frame-textoverlay" data-hover="Text overlay"><?php self::icn_img("o_frame_textoverlay.png"); ?></label>   

        <input id="gfsp_o_frame-textoverlay-notick" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-notick">
            <label for="gfsp_o_frame-textoverlay-notick" data-hover="Text overlay (no tick)"><?php self::icn_img("o_frame_textoverlay_notick.png"); ?></label>

        <input id="gfsp_o_frame-textoverlay-mid" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-overlaymid">
            <label for="gfsp_o_frame-textoverlay-mid" data-hover="Text overlay middle"><?php self::icn_img("o_frame_textoverlay_mid.png"); ?></label>

        <input id="gfsp_o_frame-textoverlay-round" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-overlaymid o-round">
            <label for="gfsp_o_frame-textoverlay-round" data-hover="Text overlay round"><?php self::icn_img("o_frame_textoverlay_round.png"); ?></label>
        
        <input id="gfsp_o_frame-textoverlay-block-notick" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-text_block o-notick">
            <label for="gfsp_o_frame-textoverlay-block-notick" data-hover="Text overlay block no tick"><?php self::icn_img("o_frame_textoverlay_block_notick.png"); ?></label>

        <input id="gfsp_o_frame-textoverlay-block" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-text_block">
            <label for="gfsp_o_frame-textoverlay-block" data-hover="Text overlay block"><?php self::icn_img("o_frame_textoverlay_block.png"); ?></label>
        
        <input id="gfsp_o_frame-textoverlay-block-tickcorner" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-text_block o-ticktopright o-notick">
            <label for="gfsp_o_frame-textoverlay-block-tickcorner" data-hover="Text overlay block corner tick"><?php self::icn_img("o_frame_textoverlay_block_tickcorner.png"); ?></label>
        
        <input id="gfsp_o_frame-textoverlay-mid-tickcorner" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-overlaymid o-ticktopright o-notick">
            <label for="gfsp_o_frame-textoverlay-mid-tickcorner" data-hover="Text overlay middle corner tick"><?php self::icn_img("o_frame_textoverlay_mid_tickcorner.png"); ?></label>
        
        <input id="gfsp_o_frame-tickanim-mid" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-ticktopright o-tickover o-notick">
            <label for="gfsp_o_frame-tickanim-mid" data-hover="Tick middle"><?php self::icn_img("o_frame_textoverlay_mid.png"); ?></label>
        
        <input id="gfsp_o_frame-textoverlay-tickanim-mid" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-ticktopright o-tickover o-notick">
            <label for="gfsp_o_frame-textoverlay-tickanim-mid" data-hover="Text overlay Tick middle"><?php self::icn_img("o_frame_textoverlay_tickanim_mid.png"); ?></label>
        
        <input id="gfsp_o_frame-textoverlay-tickanim-corner" class="has_img" type="radio" name="gfsp_o_style" value="gfsp_o_frame o-custom-bg o-textoverlay o-overlaymid o-ticktopright o-tickover o-tickovercnr o-notick">
            <label for="gfsp_o_frame-textoverlay-tickanim-corner" data-hover="Text overlay middle Tick corner"><?php self::icn_img("o_frame_textoverlay_tickanim_corner.png"); ?></label>
        
        <!-- Effects -->
        <div class="gfsp_effects_wrapper">
            <div>
                <p class="sub_heading">Image Effects</p>
                <input
                    id="cb_e-bw2col"
                    name="cb_e-bw2col"
                    type="checkbox"
                    value="e-bw2col"
                    class="has_img"
                    data-showfor=""
                    data-hidefor=""
                >
                <label for="cb_e-bw2col" class="" data-hover="Black &amp; White"><?php self::icn_img("e_bw2col.png") ?></label>
                
                <input
                    id="cb_e-fade"
                    name="cb_e-fade"
                    type="checkbox"
                    value="e-fade"
                    class="has_img"
                    data-showfor=""
                    data-hidefor=""
                >
                <label for="cb_e-fade" class="" data-hover="Fade"><?php self::icn_img("e_fade.png") ?></label>
                
                <input
                    id="cb_e-blur"
                    name="cb_e-blur"
                    type="checkbox"
                    value="e-blur"
                    class="has_img"
                    data-showfor=""
                    data-hidefor=""
                >
                <label for="cb_e-blur" class="" data-hover="Blur"><?php self::icn_img("e_blur.png") ?></label>

            </div>
            <div>
                <p class="sub_heading">Style Effects</p>
                <input
                    id="cb_e-ripple"
                    name="cb_e-ripple"
                    type="checkbox"
                    value="e-ripple"
                    class="has_img"
                    data-showfor="textoverlay"
                    data-hidefor=""
                >
                <label for="cb_e-ripple" class="" data-hover="Ripple"><?php self::icn_img("e_ripple.png") ?></label>

                <input
                    id="cb_e-shadelarge"
                    name="cb_e-shadelarge"
                    type="checkbox"
                    value="e-shadelarge"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-shadelarge" class="" data-hover="Drop Shadow"><?php self::icn_img("e_shadelarge.png") ?></label>

                <input
                    id="cb_e-hborder"
                    name="cb_e-hborder"
                    type="checkbox"
                    value="e-hborder"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-hborder" class="" data-hover="Hover Border"><?php self::icn_img("e_hborder.png") ?></label>

                <input
                    id="cb_e-nopad"
                    name="cb_e-nopad"
                    type="checkbox"
                    value="e-nopad"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-nopad" class="" data-hover="Remove padding"><?php self::icn_img("e_nopad.png") ?></label>

                <input
                    id="cb_e-nullborder"
                    name="cb_e-nullborder"
                    type="checkbox"
                    value="e-nullborder"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-nullborder" class="" data-hover="Null Border"><?php gform_tooltip( 'gf_stylespro_e_nullborder' ) ?><?php self::icn_img("e_nullborder.png") ?></label>

                <input
                    id="cb_e-noborder"
                    name="cb_e-noborder"
                    type="checkbox"
                    value="e-noborder"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-noborder" class="" data-hover="Remove border"><?php self::icn_img("e_noborder.png") ?></label>

                <input
                    id="cb_e-thickborder"
                    name="cb_e-thickborder"
                    type="checkbox"
                    value="e-thickborder"
                    class="has_img"
                    data-showfor="gfsp_o_frame"
                    data-hidefor=""
                >
                <label for="cb_e-thickborder" class="" data-hover="Thick border"><?php self::icn_img("e_thickborder.png") ?></label>

                <input
                    id="cb_e-overlaystick"
                    name="cb_e-overlaystick"
                    type="checkbox"
                    value="e-overlaystick"
                    class="has_img"
                    data-showfor="textoverlay"
                    data-hidefor="textoverlay-mid textoverlay-block"
                >
                <label for="cb_e-overlaystick" class="" data-hover="Stick overlay text to the edge"><?php self::icn_img("e_overlaystick.png") ?></label>

                <input
                    id="cb_e-ticksq"
                    name="cb_e-ticksq"
                    type="checkbox"
                    value="e-ticksq"
                    class="has_img"
                    data-showfor="tickanim"
                    data-hidefor=""
                >
                <label for="cb_e-ticksq" class="" data-hover="Square tick box"><?php self::icn_img("e_ticksq.png") ?></label>
            </div>

        </div>
        <!-- /Effects -->

    </div>
    <h3 class="gfsp_lists_ornament_tab h h_checkbox h_radio h_poll h_quiz h_option h_post_tags-checkbox h_post_tags-radio h_post_custom_field-checkbox h_post_custom_field-radio h_product-checkbox h_product-radio">Image/icon settings</h3>
    <div class="gfsp_lists_ornament h" style="display: none">
        <h4>Placement</h4>
        <input id="gfsp_o_before" class="default" type="radio" name="gfsp_o_pos" value="">
            <label for="gfsp_o_before">Image/icon first</label>
        <input id="gfsp_o_after" class="" type="radio" name="gfsp_o_pos" value="o_after">
            <label for="gfsp_o_after">Text first</label>
        <h4>Size</h4>
        <input id="gfsp_o_small" class="" type="radio" name="gfsp_o_size" value="o_small">
            <label for="gfsp_o_small">Small</label>
        <input id="gfsp_o_medium" class="default" type="radio" name="gfsp_o_size" value="o_medium">
            <label for="gfsp_o_medium">Medium</label>
        <input id="gfsp_o_large" class="" type="radio" name="gfsp_o_size" value="o_large">
            <label for="gfsp_o_large">Large</label>

    </div>

    <div class="gfsp_footer">
        <a href="<?php echo $this->_support_url; ?>" target="_blank" style="float: left;">Need help?</a>
        <input type="button" class="button-primary" value="Save" onclick="gfsp_save();">
        <input type="button" class="button" value="Cancel" onclick="tb_remove();">
        </div>
    </div>
    </div>
    </div>
    <!-- Modal ends -->
</li>