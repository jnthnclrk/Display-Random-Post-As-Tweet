<?php
/*
	Plugin Name: Display Random Post As Tweet
	Plugin URI: http://www.skyrocketonlinemarketing.com/wordpress-plugins/
	Description: A simple plugin to display a random post in a format ready for posting to Twitter.
	Author: Sky Rocket Inc.
	Version: 0.1
	Author URI: http://www.skyrocketonlinemarketing.com/
*/
?>
<?php 
// create custom plugin settings menu
add_action('admin_menu', 'drpat_create_menu');

function drpat_create_menu() {
	//create new top-level menu
	add_options_page(__('Display Random Post As Tweet Settings','menu-drpat'), __('Display Random Post As Tweet Settings','menu-drpat'), 'manage_options', 'drpatsettings', 'drpat_settings_page');
	//call register settings function
	add_action( 'admin_init', 'drpat_register_mysettings' );
}

function drpat_register_mysettings() {
	//register our settings
	register_setting( 'drpat-settings-group', 'drpat_template' );
	register_setting( 'drpat-settings-group', 'drpat_page_slug' );
	register_setting( 'drpat-settings-group', 'drpat_content_type' );
}

function drpat_settings_page() {
	// build the slide post settings page
	global $page_slug;
	$page_slug = get_option('drpat_page_slug');
	$plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
?>
<div class="wrap">
<h2>Display Random Post As Tweet</h2>
<h3><?php if ( get_option('drpat_page_slug') ) { echo '<a href="'.get_permalink( get_option('drpat_page_slug') ).'" target="_blank">View page</a></h3>'; } ?>
<form method="post" action="options.php">
    <?php settings_fields( 'drpat-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><strong>Content Types</strong><br /><small>Choose a post type</small></th>
        <td>
        <select name="drpat_content_type" id="drpat_content_type">
            <option value="any" <?php if (get_option('drpat_content_type') == 'any'){echo 'selected="selected"';}?>>All Content</option>
			<?php foreach ( get_post_types( array( 'public' => true, 'can_export' => true ), 'objects' ) as $post_type_obj ) { ?>
                <option value="<?php echo $post_type_obj->name; ?>" <?php if (get_option('drpat_content_type') == $post_type_obj->name){echo 'selected="selected"';}?>><?php echo $post_type_obj->labels->name; ?></option>
            <?php } ?>
        </select> 
        </td>
        </tr>
        <tr valign="top">
        <th scope="row"><strong>Page</strong><br /><small>Choose a page for the slideshow display</small></th>
        <td><?php wp_dropdown_pages('name=drpat_page_slug&selected='.get_option('drpat_page_slug')); ?></td>
        </tr>
        <tr valign="top">
        <th scope="row"><strong>Template</strong><br /><small>Choose a template for the slideshow</small></th>
        <td>
        	<select name="drpat_template"/>
				<?php 
                //$values = array( '/templates/template-normal.php' => 'Normal', '/templates/template-title.php' => 'Title Only', '/templates/template-bpl.php' => 'BPL');
                $values = array( '/templates/template-normal.php' => 'Normal');
                $val = get_option( 'drpat_template' );
                foreach($values as $v => $n) {
                    $s = ($val == $v) ? " selected='selected'" : null;
                    echo "<option value='$v'$s>$n</option>\n";
                }
                ?>
            </select>
        </td>
        </tr>
	</table>
    <input type="hidden" name="drpat_plugin_url" value="<?php echo $plugin_url; ?>" />
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
    </p>
</form>
</div>
<?php 
}

add_filter( 'page_template', 'drpat_page_template' );
function drpat_page_template( $page_template )
{
	$page_slug = get_option('drpat_page_slug');
	if ( is_page( $page_slug ) ) {
		$page_template = dirname( __FILE__ ) . get_option('drpat_template');
	}
	return $page_template;
}
?>