'use strict';

jQuery(document).ready(function () {


    jQuery(function (jQuery) {

        jQuery('.custom_header_color').wpColorPicker();

        if (jQuery(".custom_preview_image").length > 0) {

            if (document.getElementById('toggle-Enable').checked) {
                document.getElementById('nfw_header_options_table').className = 'form-table';
            } else {
                document.getElementById("nfw_header_options_table").className = 'form-table nfw-hide-options';
            }

            jQuery('.custom_upload_image').each(function (i, obj) {
                if (this.value == '') {
                    document.getElementById(this.id + '_clear').style.display = 'none';
                }
            });
        }
        
        if (jQuery("#nav-menu-header").length > 0) {

            jQuery('.menu-item-settings').each(function (i, obj) {
                // Aquire the current menu item's id number
                var current_id = jQuery(this).attr('id').substr(19);
                var status_text = '';
                if (document.getElementById('edit-menu-item-classes-' + current_id).value.search('nfw-nav-mega-enabled') != -1) {
                    status_text = "<span>Enabled</span>";
                }

                jQuery(this).prepend('<label>Mega Menu/Section : </label><button class="nfw-nav-mega-menu-class" \n\
                    onclick="return nfw_toggle_nav_mega(\'' + current_id + '\')">Toggle On/Off</button> <div class="nfw-nav-mega-status" id="nfw-nav-mega-status-' + current_id + '">' + status_text + '</div><br>');
            });
        }

///////////////////////////////////////////////////////////////
//
//          Widgets sidebar functions
//
///////////////////////////////////////////////////////////////

         if (jQuery("#widgets-right").length > 0) {
            var target_area = document.getElementById('widgets-right');
            target_area.insertAdjacentHTML('afterend', '<div class="sidebars_form_container">\n\
<h3 class="sidebars_form_title">Create a new WIDGET Area</h3>\n\
<input id="nfw_sidebar_title" name="nfw_sidebar_title" type="text" placeholder="name" value=""><br/>\n\
<input id="nfw_sidebar_description" name="nfw_sidebar_description" placeholder="description" type="text" value=""><br/>\n\
<div class="button-primary" id="nfw_create_trigger">Create Widget area</div></div>');

            var sidebars = document.getElementsByClassName("sidebar-nfw-sidebars-custom");
            var i;
            for (i = 0; i < sidebars.length; i++) {

                var sub = sidebars[i].getElementsByClassName('sidebar-name');
                var alt = sidebars[i].getElementsByClassName('widgets-sortables');

                sub[0].innerHTML = '<button class="nfw_sidebar_remove button-primary" data-sidebar_id="' + alt[0].id + '">remove</button>' + sub[0].innerHTML;

            }
        }

        jQuery("#nfw_create_trigger").click(function () {
            // Stores the relevant data from the fields in variables
            var title = document.getElementById('nfw_sidebar_title').value;
            var description = document.getElementById('nfw_sidebar_description').value;

            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: nfw_ajax.ajaxurl,
                data: {action: "nfw_admin_custom_sidebars", title: title, description: description},
                success: function (response) {
                    if (response == "created") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function (response) {
                    alert('Sidebar could not be created');
                    console.log(response);
                }

            });

            return false;
        });

        jQuery(".nfw_sidebar_remove").click(function () {
            var sidebar_id = jQuery(this).attr("data-sidebar_id");

            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: nfw_ajax.ajaxurl,
                data: {action: "nfw_remove_sidebar", sidebar_id: sidebar_id},
                success: function (response) {
                    if (response.sidebar_id != '') {
                        document.getElementById(sidebar_id).parentNode.style.display = 'none';
                    }
                },
                error: function (response) {
                    alert('Sidebar could not be removed');
                    console.log(response);
                }

            });

            return false;
        });


    });


});

function nfw_toggle_nav_mega(current_id) {
    var target_class = document.getElementById('edit-menu-item-classes-' + current_id);
    var object_class = document.getElementById('menu-item-' + current_id).className;
    var nav_class = object_class.substr(0, 28);
    var menu_item = document.getElementById('edit-menu-item-classes-' + current_id);
    if (nav_class == 'menu-item menu-item-depth-0 ' || nav_class == 'menu-item menu-item-depth-1 ') {
        if (target_class.value.search(' nfw-nav-mega-enabled') != -1) {
             menu_item.value=menu_item.value.replace(' nfw-nav-mega-enabled', '');
            document.getElementById('nfw-nav-mega-status-' + current_id).innerHTML = '';
        }else if (target_class.value.search('nfw-nav-mega-enabled') != -1){
             menu_item.value=menu_item.value.replace('nfw-nav-mega-enabled', '');
            document.getElementById('nfw-nav-mega-status-' + current_id).innerHTML = '';
        }else {
            menu_item.value = menu_item.value+' nfw-nav-mega-enabled';
            document.getElementById('nfw-nav-mega-status-' + current_id).innerHTML = "<span>Enabled</span>";
        }
    }
    return false;
}

function nfw_upload_trigger(target_id) {

    // check for media manager instance
    if (wp.media.frames.nfw_frame) {
        wp.media.frames.nfw_frame.open();
        return;
    }
    // configuration of the media manager new instance
    wp.media.frames.nfw_frame = wp.media({
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
    var nfw_media_set_image = function () {
        var selection = wp.media.frames.nfw_frame.state().get('selection');

        // no selection
        if (!selection) {
            return;
        }

        // iterate through selected elements
        selection.each(function (attachment) {
            var formfield = document.getElementById(target_id + '_upload_input');
            var preview = document.getElementById(target_id + '_preview_image');

            formfield.value = attachment.attributes.id;
            preview.src = attachment.attributes.url;
            if (document.getElementById(target_id + '_upload_input').value != '') {
                document.getElementById(target_id + '_upload_input_clear').style.display = 'inline-block';
            }

        });
    };

    // closing event for media manger
    wp.media.frames.nfw_frame.on('close', nfw_media_set_image);
    // image selection event
    wp.media.frames.nfw_frame.on('select', nfw_media_set_image);
    // showing media manager
    wp.media.frames.nfw_frame.open();
return false;
}
function nfw_clear_image_trigger(target_id, image_none) {
    // Removes the uploaded header image from the preview and the input fields
    document.getElementById(target_id + '_upload_input').value = '';
    document.getElementById(target_id + '_preview_image').src = image_none;
    document.getElementById(target_id + '_upload_input_clear').style.display = 'none';
    return false;
}

function nfw_header_override() {
    if (document.getElementById('toggle-Enable').checked) {
        document.getElementById('nfw_header_options_table').className = 'form-table';
    } else {
        document.getElementById("nfw_header_options_table").className = 'form-table nfw-hide-options';
    }
}


///////////////////////////////////////////////////////////////
//
//          Visual Composer functions
//
///////////////////////////////////////////////////////////////

function nfw_icon_change(obj) {
    document.getElementById("nfw_selected_icon").className = obj.className;
    document.getElementById('nfw_icon_input').value = obj.className;
}

// Removes the icon the selected icon
function nfw_icon_clear_selection() {
    document.getElementById("nfw_selected_icon").className = "";
    document.getElementById('nfw_icon_input').value = "";
    return false;
}

// Displays the selected icon
function nfw_selected_icon_display() {
    document.getElementById("nfw_selected_icon").className = document.getElementById('nfw_icon_input').value;
}

// Radio style selection for icon box
function nfw_radio_style_option(obj) {
    document.getElementById('nfw_selected_radio_style').value = obj.value;
}

// Changes the font icon display based on the selection
function nfw_icon_change(obj) {
    document.getElementById("nfw_selected_icon").className = obj.className;
    document.getElementById('nfw_icon_input').value = obj.className;
}

// Removes the icon the selected icon
function nfw_icon_clear_selection() {
    document.getElementById("nfw_selected_icon").className = "";
    document.getElementById('nfw_icon_input').value = "";
    return false;
}

// Displays the selected icon
function nfw_selected_icon_display() {
    document.getElementById("nfw_selected_icon").className = document.getElementById('nfw_icon_input').value;
}

// Radio style selection for icon box
function nfw_radio_style_option(obj) {
    document.getElementById('nfw_selected_radio_style').value = obj.value;
}
