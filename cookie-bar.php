<?php
/*
Plugin Name: Cookie Bar
Plugin URI: https://www.brontobytes.com/
Description: Cookie Bar allows you to discreetly inform visitors that your website uses cookies.
Author: Brontobytes
Author URI: https://www.brontobytes.com/
Version: 1.8.6.2.6
License: GPLv2
*/

/*
 * Todo List
 * ---------
 * - Use classes in code 
 * - Add a Cookie Bar in admin live demo version that updates on settings change for real time review
 *   |_ setting to turn demo on and off
 *   |_ display in admin area or in a window simulation (?)
 * - Allow for settings export/import 
 * - Build a caching system (-> code written to a static CSS file that is pointed to instead of processing display code) 
 * - Add help/info icons which open info windows
 * - Provide cookie explanation page (on site) that users can link to (and that can be translated so to have an explanation in every language
 * - Increase security of plugin
 *   |_ sanitize input
 *   |_ sanitize output
 * - Create language files/translations
 *   |_ de_de
 *   |_ en_au
 *   |_ en_gb
 *   |_ en_us
 * - combine settings cards (button menu to make cards appear)
 */

if ( ! defined( 'ABSPATH' ) )
	exit;



/*
 * Default Settings
 *
 * Here all default values in one spot for easy modification.
 * This will be of interest to those who will want to distribute this plugin with their default values.
 *
 * Default values are ordered in appearance and sorted into their categories.
 */
/* Text Settings */
define( 'DEFAULT_COOKIE_BAR_MESSAGE_TEXT', __('By continuing to browse this site you are agreeing to the <a href="http://www.aboutcookies.org/" target="_blank" rel="nofollow">use of cookies</a>.', 'cookie-bar') );
define( 'DEFAULT_COOKIE_BAR_BUTTON_TEXT', __('I Understand', 'cookie-bar') );
/* Style Settings */                    
define( 'DEFAULT_COOKIE_BAR_LOCATION', 'bottom' );
define( 'DEFAULT_COOKIE_BAR_ALIGNMENT', 'center' );
define( 'DEFAULT_COOKIE_BAR_FONT_SIZE', '12' );
define( 'DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS', 'px' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE', '12' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE_UNITS', 'px' );
define( 'DEFAULT_COOKIE_BAR_BORDER', '1px' );
define( 'DEFAULT_COOKIE_BAR_BORDER_COLOR', '#fff' );
define( 'DEFAULT_COOKIE_BAR_SHADOW', 'none' );
define( 'DEFAULT_COOKIE_BAR_PADDING', '3');
define( 'DEFAULT_COOKIE_BAR_PADDING_UNITS', 'px');
define( 'DEFAULT_COOKIE_BAR_CURSOR_BUTTON_HOVER', 'pointer' );

/* Color Values */
define( 'DEFAULT_COOKIE_BAR_BACKGROUND_COLOR', '#2e363f' );
define( 'DEFAULT_COOKIE_BAR_TEXT_COLOR', '#fff' );
define( 'DEFAULT_COOKIE_BAR_TEXT_LINK_COLOR', '#fff' );
define( 'DEFAULT_COOKIE_BAR_TEXT_LINK_HOVER_COLOR', '#fff' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_BACKGROUND_COLOR', '#45ae52' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_HOVER_BACKGROUND_COLOR', '#45ae52' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_TEXT_COLOR', '#fff' );
define( 'DEFAULT_COOKIE_BAR_BUTTON_HOVER_TEXT_COLOR', '#fff' );



function cookie_bar_menu() {
	add_options_page('Cookie Bar Settings', 'Cookie Bar', 'administrator', 'cookie-bar-settings', 'cookie_bar_settings_page', 'dashicons-admin-generic');
}
add_action('admin_menu', 'cookie_bar_menu');



function cookie_bar_settings_page() { 
/* Localising color picker text */
$colorpicker_l10n = array(
    'defaultString' => __( 'Default Color' ),
             'pick' => __( 'Select  Color' )
);
wp_localize_script( 
    'wp-color-picker',
    'wpColorPickerL10n', 
    $colorpicker_l10n
);
?>



<!-- START Cookie Bar Admin Page -->

<div class="wrap">
    <div id="cookie-bar-admin-area-info">
        <h1><?php _e('Cookie Bar Settings', 'cookie-bar'); ?></h1>
        <p><?php _e('Cookie Bar allows you to discreetly inform visitors that your website uses cookies.', 'cookie-bar'); ?></p>
    </div>
    
    
    <form method="post" action="options.php">
        <?php settings_fields( 'cookie-bar-settings' ); ?>
        <?php do_settings_sections( 'cookie-bar-settings' ); ?>
        <div class="cookie-bar-admin-section" id="cookie-bar-admin-section-text-settings">
            <h3 class="cookie-bar-admin-current"><?php _e('Cookie Bar Text Setting', 'cookie-bar'); ?></h3>
            <table class="cookie-bar-admin-form-table" id="cookie-bar-admin-form-table-text-settings">
                <tr>
                    <th scope="row"><?php _e('Cookie Bar Message Text', 'cookie-bar'); ?></th>
                    <td>
                        <textarea id="cookie-bar-admin-form-message-text-input" name="cookie_bar_message_text"><?php echo esc_html( get_option('cookie_bar_message_text') ); ?></textarea>
                        <br>
                        <?php _e('HTML allowed, for example:', 'cookie-bar'); ?>
                        <br>
                        <small>
                            <code>
                                <?php esc_attr_e('By continuing to browse this site you are agreeing to the <a href="http://www.aboutcookies.org/" target="_blank" rel="nofollow">use of cookies</a>.', 'cookie-bar'); ?>
                            </code>
                        </small>
                    </td>
                </tr>
                <tr id="cookie-bar-admin-form-button-text">
                    <th scope="row"><?php _e('Button Text', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" id="cookie-bar-admin-form-button-text-input" name="cookie_bar_button_text" value="<?php echo esc_attr( get_option('cookie_bar_button_text') ); ?>">
                        <br>
                        <?php _e('Keep it short. No HTML or special characters, example:', 'cookie-bar'); ?>
                        <br>
                        <small>
                            <code>
                                <?php _e('I Understand', 'cookie-bar'); ?>
                            </code>
                        </small>
                    </td>
                </tr>
            </table>
        </div>
        
        
        <div class="cookie-bar-admin-section" id="cookie-bar-admin-section-style-settings">
            <h3 class="cookie-bar-admin-current"><?php _e('Design Settings', 'cookie-bar'); ?></h3>
            <table class="cookie-bar-admin-form-table">
                <tr>
                    <th colspan="2"><h4><?php _e('Bar Settings', 'cookie-bar'); ?></h4></th>
                    <th colspan="2"><h4><?php _e('Color Settings', 'cookie-bar'); ?></h4></th>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Bar Location', 'cookie-bar'); ?></th> <?php 
                if ( is_rtl() == true) { ?>
                    <td><?php 
                    if ( (get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) === "top") ) { ?>
                        <label for="cookie-bar-location-bottom"><?php echo _e('Bottom', 'cookie-bar'); ?></label> 
                        <input type="radio" id="cookie-bar-location-bottom" name="cookie_bar_location" value="bottom">
                        <label for="cookie-bar-location-top"><?php echo _e('Top', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-location-top" name="cookie_bar_location" value="top" checked=checked> <?php 
                    } else { ?> 
                        <label for="cookie-bar-location-bottom"><?php echo _e('Bottom of page', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-location-bottom" name="cookie_bar_location" value="bottom">
                        <label for="cookie-bar-location-top"><?php echo _e('Top of page', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-location-top" name="cookie_bar_location" value="top" checked=checked> <?php 
                    }; ?>
                    </td>
                    <?php 
                } else { ?>
                    <td><?php 
                    if ( (get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) === "top") ) { ?>
                        <input type="radio" id="cookie-bar-location-top" name="cookie_bar_location" value="top" checked=checked> 
                        <label for="cookie-bar-location-top"><?php echo _e('Top', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-location-bottom" name="cookie_bar_location" value="bottom"> 
                        <label for="cookie-bar-location-bottom"><?php echo _e('Bottom', 'cookie-bar'); ?></label><?php 
                    } else { ?>
                        <input type="radio" id="cookie-bar-location-top" name="cookie_bar_location" value="top" checked=checked> 
                        <label for="cookie-bar-location-top"><?php echo _e('Top of page', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-location-bottom" name="cookie_bar_location" value="bottom"> 
                        <label for="cookie-bar-location-bottom"><?php echo _e('Bottom of page', 'cookie-bar'); ?></label><?php 
                    }; ?>
                    </td><?php
                }; ?>
                    <th scope="row"><?php _e('Bar Color', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_background_color" value="<?php 
                        if (get_option(cookie_bar_background_color) == true) {
                            echo esc_attr( get_option('cookie_bar_background_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_BACKGROUND_COLOR;
                        } 
                        ?>" class="cookie_bar_background_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BACKGROUND_COLOR; ?>">
                    </td>
                </tr>
                <tr>    
                    <th scope="row"><?php _e('Alignment', 'cookie-bar'); ?></th>
                    </th> <?php
                if ( is_rtl() == true ) { ?>
                    <td>
                        <label for="cookie-bar-alignment-left"><?php _e('left', 'cookie-bar'); ?></label
                        <input type="radio" id="cookie-bar-alignment-left" name="cookie_bar_alignment" value="left"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'left') {
                            echo ' checked';
                        }?>>>
                        <label for="cookie-bar-alignment-center"><?php _e('center', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-alignment-center" name="cookie_bar_alignment" value="center"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'center') {
                            echo ' checked';
                        }?>>
                        <label for="cookie-bar-alignment-right"><?php _e('right', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-alignment-right" name="cookie_bar_alignment" value="right"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'right') {
                            echo ' checked';
                        }?>>
                    </td> <?php
                } else { ?>
                    <td>
                        <input type="radio" id="cookie-bar-alignment-left" name="cookie_bar_alignment" value="left"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'left') {
                            echo ' checked';
                        }?>>
                        <label for="cookie-bar-alignment-left"><?php _e('left', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-alignment-center" name="cookie_bar_alignment" value="center"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'center') {
                            echo ' checked';
                        }?>>
                        <label for="cookie-bar-alignment-center"><?php _e('center', 'cookie-bar'); ?></label>
                        <input type="radio" id="cookie-bar-alignment-right" name="cookie_bar_alignment" value="right"<?php
                        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'right') {
                            echo ' checked';
                        }?>>
                        <label for="cookie-bar-alignment-right"><?php _e('right', 'cookie-bar'); ?></label>
                    </td> <?php
                }; ?>
                    <th scope="row"><?php _e('Bar Text Color', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_text_color" value="<?php 
                        if (get_option(cookie_bar_text_color) == true) {
                            echo esc_attr( get_option('cookie_bar_text_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_TEXT_COLOR;
                        }
                        ?>" class="cookie_bar_text_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_TEXT_COLOR; ?>">
                    </td>
                </tr>
                <tr>   
                    <th scope="row"><?php _e('Font-Size', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_font_size" maxlength="3" size="3" value="<?php 
                        if ( get_option('cookie_bar_font_size') == true ) {
                            echo esc_attr( get_option('cookie_bar_font_size') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_FONT_SIZE;
                        };
                        ?>">
                        <select name="cookie_bar_font_size_units">
                            <option value="px"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS) === 'px' ) {
                                echo ' selected';
                            }; ?>>px</option>
                            <option value="em"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS) === 'em' ) {
                                echo ' selected';
                            }; ?>>em</option>
                            <option value="rem"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS) === 'rem' ) { 
                                echo ' selected';
                            }; ?>>rem</option>
                        </select>
                    </td> 
                    <th scope="row"><?php _e('Bar Text Link Color', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_text_link_color" value="<?php 
                        if (get_option(cookie_bar_text_link_color) == true) {
                            echo esc_attr( get_option('cookie_bar_text_link_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_TEXT_LINK_COLOR;
                        }
                        ?>" class="cookie_bar_text_link_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_TEXT_LINK_COLOR; ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Button Font-Size', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_button_font_size" maxlength="3" size="3" value="<?php 
                        if ( get_option('cookie_bar_button_font_size') == true ) {
                            echo esc_attr( get_option('cookie_bar_button_font_size') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE;
                        };
                        ?>">
                        <select name="cookie_bar_button_font_size_units">
                            <option value="px"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE_UNITS) === 'px' ) {
                                echo ' selected';
                            }; ?>>px</option>
                            <option value="em"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE_UNITS) === 'em' ) {
                                echo ' selected';
                            }; ?>>em</option>
                            <option value="rem"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE_UNITS) === 'rem' ) { 
                                echo ' selected';
                            }; ?>>rem</option>
                        </select>
                    </td> 
                    <th scope="row"><?php _e('Bar Text Link Color On Hover', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_text_link__color" value="<?php 
                        if (get_option(cookie_bar_text_link_hover_color) == true) {
                            echo esc_attr( get_option('cookie_bar_text_link_hover_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_TEXT_LINK_HOVER_COLOR;
                        }
                        ?>" class="cookie_bar_text_link_hover_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_TEXT_LINK_HOVER_COLOR; ?>">
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Border', 'cookie-bar'); ?></th>
                    <td id="getittofloat">
                        <select name="cookie_bar_border">
                            <option value="none"<?php
                            if ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === 'none' ) {
                                echo ' selected';
                            }; ?>>0</option>
                            <option value="1px"<?php
                            if ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '1px' ) {
                                echo ' selected';
                            }; ?>>1px</option>
                            <option value="2px"<?php
                            if ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '2px' ) {
                                echo ' selected';
                            }; ?>>2px</option>
                            <option value="3px"<?php
                            if ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '3px' ) {
                                echo ' selected';
                            }; ?>>3px</option>
                        </select>
                        <input type="text" name="cookie_bar_border_color" value="<?php 
                        if (get_option(cookie_bar_border_color) == true) {
                            echo esc_attr( get_option('cookie_bar_border_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_BORDER_COLOR;
                        }
                        ?>" class="cookie_bar_button_background_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BUTTON_BACKGROUND_COLOR; ?>">
                    </td>
                    <th scope="row"><?php _e('Button Color', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_button_background_color" value="<?php 
                        if (get_option(cookie_bar_button_background_color) == true) {
                            echo esc_attr( get_option('cookie_bar_button_background_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_BUTTON_BACKGROUND_COLOR;
                        }
                        ?>" class="cookie_bar_button_background_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BUTTON_BACKGROUND_COLOR; ?>">
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Bar Shadow', 'cookie-bar'); ?></th>
                    <td>
                        <select name="cookie_bar_shadow">
                            <option value="none" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === 'none' ) {
                                echo ' selected';
                            }; 
                            ?>><?php _e('none', 'cookie-bar'); ?></option>
                            <option value="2pxblack" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxblack' ) {
                                echo ' selected';
                            }; 
                            ?>>2px <?php _e('Black', 'cookie-bar'); ?> (#000)</option>
                            <option value="4pxblack" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxblack' ) {
                                echo ' selected';
                            }; 
                            ?>>4px <?php _e('Black', 'cookie-bar'); ?> (#000)</option>
                            <option value="2pxgray" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxgray' ) {
                                echo ' selected';
                            }; 
                            ?>>2px <?php _e('Gray', 'cookie-bar'); ?> (#999)</option>
                            <option value="4pxgray" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxgray' ) {
                                echo ' selected';
                            }; 
                            ?>>4px <?php _e('Gray', 'cookie-bar'); ?> (#999)</option>
                            <option value="2pxwhite" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxwhite' ) {
                                echo ' selected';
                            }; 
                            ?>>2px <?php _e('White', 'cookie-bar'); ?> (#fff)</option>
                            <option value="4pxwhite" <?php
                            if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxwhite' ) {
                                echo ' selected';
                            }; 
                            ?>>4px <?php _e('White', 'cookie-bar'); ?> (#fff)</option>
                        </select>
                    </td>
                    <th scope="row"><?php _e('Button Text Color', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_button_text_color" value="<?php 
                        if (get_option(cookie_bar_button_text_color) == true) {
                            echo esc_attr( get_option('cookie_bar_button_text_color') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_BUTTON_TEXT_COLOR;
                        }
                        ?>" class="cookie_bar_button_text_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BUTTON_TEXT_COLOR; ?>">
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Bar Padding', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_padding" maxlength="3" size="3" value="<?php 
                        if ( get_option('cookie_bar_padding') == true ) {
                            echo esc_attr( get_option('cookie_bar_padding') );
                        } else {
                            echo DEFAULT_COOKIE_BAR_PADDING;
                        };
                        ?>">
                        <select name="cookie_bar_font_size_units">
                            <option value="px"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_PADDING_UNITS) === 'px' ) {
                                echo ' selected';
                            }; ?>>px</option>
                            <option value="em"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_PADDING_UNITS) === 'em' ) {
                                echo ' selected';
                            }; ?>>em</option>
                            <option value="rem"<?php
                            if ( get_option('cookie_bar_font_size_units', DEFAULT_COOKIE_BAR_PADDING_UNITS) === 'rem' ) { 
                                echo ' selected';
                            }; ?>>rem</option>
                        </select>
                    </td>
                    <th scope="row"><?php _e('Button Color On Hover', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_button_hover_background_color" value="<?php 
                    if (get_option(cookie_bar_button_hover_background_color) == true) {
                        echo esc_attr( get_option('cookie_bar_button_hover_background_color') );
                    } else {
                        echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_BACKGROUND_COLOR;
                    }
                    ?>" class="cookie_bar_button_hover_background_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_BACKGROUND_COLOR; ?>">
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Cursor On Hover', 'cookie-bar'); ?></th>
                    <td>
                        <select name="cookie_bar_cursor_button_hover">
                            <option value="crosshair" <?php
                            if (get_option('cookie_bar_cursor_button_hover', DEFAULT_COOKIE_BAR_CURSOR_BUTTON_HOVER) === "crosshair") {
                                echo "selected";
                            }; ?>>crosshair</option>
                            <option value="pointer" <?php
                            if (get_option('cookie_bar_cursor_button_hover', DEFAULT_COOKIE_BAR_CURSOR_BUTTON_HOVER) === "pointer") {
                                echo "selected";
                            }; ?>>pointer</option>>pointer</option>
                            <option value="text" <?php
                            if (get_option('cookie_bar_cursor_button_hover', DEFAULT_COOKIE_BAR_CURSOR_BUTTON_HOVER) === "text") {
                                echo "selected";
                            }; ?>>text</option>>text</option>
                        </select>
                    </td>
                    <th scope="row"><?php _e('Button Text Color On Hover', 'cookie-bar'); ?></th>
                    <td>
                        <input type="text" name="cookie_bar_button_hover_text_color" value="<?php 
                    if (get_option(cookie_bar_button_hover_text_color) == true) {
                        echo esc_attr( get_option('cookie_bar_button_hover_text_color') );
                    } else {
                        echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_TEXT_COLOR;
                    }
                    ?>" class="cookie_bar_button_hover_text_color" data-default-color="<?php echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_TEXT_COLOR; ?>">
                    </td>
                </tr>
             </table>
        </div>
        
        <?php submit_button(); ?>
        
    </form>
    

    <div id="cookie-bar-sponsor-message">
        <p><?php _e('We are very happy to be able to provide this and other', 'cookie-bar'); ?> <a href="https://www.brontobytes.com/blog/c/wordpress-plugins/"><?php _e('free WordPress plugins', 'cookie-bar'); ?></a>.</p>
        <p><?php _e('Plugin developed by', 'cookie-bar'); ?> <a href="https://www.brontobytes.com/"><img id="cookie-bar-sponsor-logo" src="<?php echo plugins_url( 'images/brontobytes.svg', __FILE__ ) ?>" alt="<?php _e('Logo of Brontobytes a web hosting provider.', 'cookie-bar'); ?>"></a></p>
    </div>
</div>

<!-- END Cookie Bar Admin Page -->



<?php }



function cookie_bar_settings() {
    /* Text Settings - Default Language */
    register_setting( 'cookie-bar-settings', 'cookie_bar_message_text' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_text' );
    /* Basic Styles */
    register_setting( 'cookie-bar-settings', 'cookie_bar_location' );	
    register_setting( 'cookie-bar-settings', 'cookie_bar_alignment' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_font_size' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_font_size_units' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_font_size' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_font_size_units' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_border' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_border_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_shadow' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_padding' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_padding_units' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_cursor_button_hover' );
    /* Color Styles */
    register_setting( 'cookie-bar-settings', 'cookie_bar_background_color' );	
    register_setting( 'cookie-bar-settings', 'cookie_bar_text_color' );	
    register_setting( 'cookie-bar-settings', 'cookie_bar_text_link_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_text_link_hover_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_background_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_text_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_hover_background_color' );
    register_setting( 'cookie-bar-settings', 'cookie_bar_button_hover_text_color' );
}
add_action( 'admin_init', 'cookie_bar_settings' );



function cookie_bar_deactivation() {
    delete_option( 'cookie_bar_message_text' );
    delete_option( 'cookie_bar_button_text' );
    
    delete_option( 'cookie_bar_location' );
    delete_option( 'cookie_bar_alignment' );
    delete_option( 'cookie_bar_font_size' );
    delete_option( 'cookie_bar_font_size_units' );
    delete_option( 'cookie_bar_button_font_size' );
    delete_option( 'cookie_bar_button_font_size_units' );
    delete_option( 'cookie_bar_border' );
    delete_option( 'cookie_bar_border_color' );
    delete_option( 'cookie_bar_shadow' );
    delete_option( 'cookie_bar_padding' );
    delete_option( 'cookie_bar_padding_units' );
    delete_option( 'cookie_bar_cursor_button_hover' );
    
    delete_option( 'cookie_bar_background_color' );    
    delete_option( 'cookie_bar_text_color' );    
    delete_option( 'cookie_bar_text_link_color' );
    delete_option( 'cookie_bar_text_link_hover_color' );
    delete_option( 'cookie_bar_button_background_color' );
    delete_option( 'cookie_bar_button_text_color' );  
    delete_option( 'cookie_bar_button_hover_background_color' );
    delete_option( 'cookie_bar_button_hover_text_color' );  
}
register_deactivation_hook( __FILE__, 'cookie_bar_deactivation' );



function cookie_bar_dependencies() {
    wp_register_script( 'cookie-bar-js', plugins_url('js/cookie-bar.js', __FILE__), array('jquery'), time(), false );
    wp_enqueue_script( 'cookie-bar-js' );
    
    wp_register_style( 'cookie-bar-css', plugins_url('css/cookie-bar.css', __FILE__) );
    wp_enqueue_style( 'cookie-bar-css' );
}
add_action( 'wp_enqueue_scripts', 'cookie_bar_dependencies' );



function cookie_bar_admin_dependencies( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cookie-bar-color-picker', plugins_url('js/cookie-bar.js', __FILE__), array('wp-color-picker'), false, true );
    
    wp_register_script( 'cookie-bar-admin-js', plugins_url('js/cookie-bar-admin.js', __FILE__), array('jquery'), false, false );
    wp_enqueue_script( 'cookie-bar-admin-js' );
    
	  wp_register_style( 'cookie-bar-admin-css', plugins_url('css/cookie-bar-admin.css', __FILE__) );
    wp_enqueue_style( 'cookie-bar-admin-css' );
}
add_action( 'admin_enqueue_scripts', 'cookie_bar_admin_dependencies' );



class cookie_bar_languages {
    public static function loadTextDomain() {
        load_plugin_textdomain('cookie-bar', false, dirname(plugin_basename(__FILE__ )) . '/languages/');
    }
}
add_action('plugins_loaded', array('cookie_bar_languages', 'loadTextDomain'));



function cookie_bar_head() { ?>


<!-- START Cookie Bar Styles -->
<style>
    #cookie-bar-wp {
        background-color: <?php 
        if ( get_option('cookie_bar_background_color') == true ) {
            echo esc_attr( get_option('cookie_bar_background_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_BACKGROUND_COLOR;
        }; ?>; <?php
        if ( get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) === "top" ) { $location = "bottom"; }
        else { $location = "top"; };?>
        border-<?php echo $location; ?>: <?php 
        if ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '1px') {
            echo '1px solid ';
            if ( get_option('cookie_bar_border_color') == true) {
                echo esc_attr( get_option('cookie_bar_border_color') );
            } else {
                echo DEFAULT_COOKIE_BAR_BORDER_COLOR;
            };
        } elseif ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '2px') {
            echo '2px solid ';
            if ( get_option('cookie_bar_border_color') == true) {
                echo esc_attr( get_option('cookie_bar_border_color') );
            } else {
                echo DEFAULT_COOKIE_BAR_BORDER_COLOR;
            };
        } elseif ( get_option('cookie_bar_border', DEFAULT_COOKIE_BAR_BORDER) === '3px') {
            echo '3px solid ';
            if ( get_option('cookie_bar_border_color') == true) {
                echo esc_attr( get_option('cookie_bar_border_color') );
            } else {
                echo DEFAULT_COOKIE_BAR_BORDER_COLOR;
            };
        } else {
            echo 'none';
        }; ?>;
        box-shadow: 0 <?php
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxblack' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '2px 2px #000';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxblack' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-2px 2px #000';
        };
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxblack' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '4px 4px #000';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxblack' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-4px 4px #000';
        };
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxgray' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '2px 2px #999';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxgray' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-2px 2px #000';
        }; 
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxgray' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '4px 4px #999';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxgray' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-4px 4px #000';
        };
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxwhite' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '2px 2px #fff';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '2pxwhite' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-2px 2px #000';
        };
        if ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxwhite' && get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'top' ) {
            echo '4px 4px #fff';
        } elseif ( get_option('cookie_bar_shadow', DEFAULT_COOKIE_BAR_SHADOW) === '4pxwhite' &&  get_option('cookie_bar_location', DEFAULT_COOKIE_BAR_LOCATION) == 'bottom' ) {
                echo '-4px 4px #000';
        } else {
            echo '';
        }; 
        ?>;
        color: <?php 
        if ( get_option('cookie_bar_text_color') == true ) {
            echo esc_attr( get_option('cookie_bar_text_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_TEXT_COLOR;
        }; ?>;
        font-size: <?php 
        if ( get_option('cookie_bar_font_size') == true ) {
            echo esc_attr( get_option('cookie_bar_font_size') );
        } else {
            echo DEFAULT_COOKIE_BAR_FONT_SIZE;
        }; 
        if ( get_option('cookie_bar_font_size_units') == true ) {
            echo esc_attr( get_option('cookie_bar_font_size_units') );
        } else {
            echo DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS;
        }; ?>;
        line-height: <?php
        if ( get_option('cookie_bar_font_size') == true) {
            $fontsize = get_option('cookie_bar_font_size');
        } else {
            $fontsize = DEFAULT_COOKIE_BAR_FONT_SIZE;
        };
        $lineheight = $fontsize * 1.1;
        echo $lineheight;
        echo DEFAULT_COOKIE_BAR_FONT_SIZE_UNITS;
        ?>;
        padding: <?php 
        if ( get_option('cookie_bar_padding') == true ) {
            echo esc_attr( get_option('cookie_bar_padding') );
        } else {
            echo DEFAULT_COOKIE_BAR_PADDING;
        }; 
        if ( get_option('cookie_bar_padding_units') == true ) {
            echo esc_attr( get_option('cookie_bar_padding_units') );
        } else {
            echo DEFAULT_COOKIE_BAR_PADDING_UNITS;
        }; ?>;
        <?php
        if ( get_option('cookie_bar_location') == true && get_option('cookie_bar_location') === "top" ) { ?>
        top: 0; <?php
        } elseif ( get_option('cookie_bar_location') != true && DEFAULT_COOKIE_BAR_LOCATION === "top" ) { ?>
        top: 0; <?php
        } else { ?>
        bottom: 0; <?php
        }; ?>
        text-align: <?php
        if ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT)  === 'left' ) { 
            echo 'left';
        } elseif ( get_option('cookie_bar_alignment', DEFAULT_COOKIE_BAR_ALIGNMENT) === 'right' ) { 
            echo 'right';
        } else {
            echo 'center';
        }; ?>; <?php
        if ( is_rtl() == true ) { ?>
        direction: rtl;
        unicode-bidi: bidi-override; <?php
        } else { ?>
        direction: ltr; <?php
        }; ?>
    }
    #cookie-bar-wp a {
        color: <?php if (get_option('cookie_bar_text_link_color') == true ) {
            echo esc_attr( get_option('cookie_bar_text_link_color') );
            } else {
                echo DEFAULT_COOKIE_BAR_TEXT_LINK_COLOR;
            }; ?>;
    }
    #cookie-bar-wp a:hover {
        color: <?php if (get_option('cookie_bar_text_link_hover_color') == true ) {
            echo esc_attr( get_option('cookie_bar_text_link_hover_color') );
            } else {
                echo DEFAULT_COOKIE_BAR_TEXT_LINK_HOVER_COLOR;
            }; ?>;
    }
    #cookie-bar-wp button {
        background-color: <?php if ( get_option('cookie_bar_button_background_color') == true ) {
            echo esc_attr( get_option('cookie_bar_button_background_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_BACKGROUND_COLOR;
        }; ?>;
        color: <?php if ( get_option('cookie_bar_button_text_color') == true ) {
            echo esc_attr( get_option('cookie_bar_button_text_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_TEXT_COLOR;
        }; ?>;
        font-size: <?php 
        if ( get_option('cookie_bar_button_font_size') == true ) {
            echo esc_attr( get_option('cookie_bar_button_font_size') );
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE;
        }; 
        if ( get_option('cookie_bar_button_font_size_units') == true ) {
            echo esc_attr( get_option('cookie_bar_button_font_size_units') );
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_FONT_SIZE_UNITS;
        }; ?>;
    }
    #cookie-bar-wp button:hover {
        background-color: <?php if ( get_option('cookie_bar_button_hover_background_color') == true ) {
            echo esc_attr( get_option('cookie_bar_button_hover_background_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_BACKGROUND_COLOR;
        }; ?>;
        color: <?php if ( get_option('cookie_bar_button_hover_text_color') == true ) {
            echo esc_attr( get_option('cookie_bar_button_hover_text_color') );
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_HOVER_TEXT_COLOR;
        }; ?>;
        cursor: <?php if ( get_option('cookie_bar_cursor_button_hover') == true ) {
            echo esc_attr( get_option('cookie_bar_cursor_button_hover') );
        } else {
            echo DEFAULT_COOKIE_BAR_CURSOR_BUTTON_HOVER;
        }; ?>;
    }    
</style>
<!-- END Cookie Bar Styles -->


<?php
}
add_action( 'wp_head', 'cookie_bar_head');



function cookie_bar() { ?>


<!-- START Cookie Bar -->
<div id="cookie-bar-wp"> <?php
    if ( is_rtl() == true ) { ?>
    <button id="cookie-bar-cookie-accept-wp" onclick="cookieBarAcceptCookiesWP();"><?php 
        if (get_option('cookie_bar_button_text') == true ) {
            echo get_option('cookie_bar_button_text');
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_TEXT;
        }; ?></button>
    <span>          
        <?php 
        if (get_option('cookie_bar_message_text') == true ) {
            echo get_option('cookie_bar_message_text');
        } else {
            echo DEFAULT_COOKIE_BAR_MESSAGE_TEXT;
        };   ?> 
    </span> <?php
    } else { ?>
    <span>          
        <?php 
        if (get_option('cookie_bar_message_text') == true ) {
            echo get_option('cookie_bar_message_text');
        } else {
            echo DEFAULT_COOKIE_BAR_MESSAGE_TEXT;
        };   ?> 
    </span>
    <button id="cookie-bar-cookie-accept-wp" onclick="cookieBarAcceptCookiesWP();"><?php 
        if (get_option('cookie_bar_button_text') == true ) {
            echo get_option('cookie_bar_button_text');
        } else {
            echo DEFAULT_COOKIE_BAR_BUTTON_TEXT;
        }; ?></button> <?php
    }; ?>
</div>
<!-- END Cookie Bar -->


<?php
}
add_action( 'wp_footer', 'cookie_bar', 10 );