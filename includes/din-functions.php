<?php 

function din_add_nav_item(){
	global $bp, $groups_template;
	
	$doc = new BP_Docs_Query;
	
	$groups_slug = !empty( $bp->groups->root_slug ) ? $bp->groups->root_slug : $bp->groups->slug;

	// create the query
	$args = array(
		'post_type'                 => $doc->post_type_name,
		'post_status'               => 'published',
		$doc->associated_item_tax_name   => $doc->item_slug,
		'bp_docs_tag'					=> get_option('din_tag_name'),
		'posts_per_page'            => 1,
		'orderby'                   => 'date',
	); // end show query

	$din_posts = query_posts($args);
	
	// create custom Doc in Nav item
	foreach ( $din_posts as $post ) {

		$bp->bp_options_nav['groups'][$post->post_name]['name'] = $post->post_title;
		$bp->bp_options_nav['groups'][$post->post_name]['slug'] = $post->post_name;
		$bp->bp_options_nav['groups'][$post->post_name]['link'] = bp_docs_get_group_doc_permalink($post->ID);
		$bp->bp_options_nav['groups'][$post->post_name]['css_id'] = 'doc_in_nav';
		$bp->bp_options_nav['groups'][$post->post_name]['position'] = 90;
		$bp->bp_options_nav['groups'][$post->post_name]['user_has_access'] = 1;
	
	}
	
}
add_action( 'wp', 'din_add_nav_item' );

	

// create custom plugin settings menu
add_action('admin_menu', 'din_create_menu');
	
function din_create_menu() {
	$doc = new BP_Docs_Query;
	//create new top-level menu
	add_submenu_page('edit.php?post_type='.$doc->post_type_name, 'Options', 'Options', 'manage_options', $doc->post_type_name.'-options', 'din_settings_page' ); 
	
	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'din-settings-group', 'din_tag_name' );
}

function din_settings_page() {
?>
<div class="wrap">
<h2>Doc in Nav</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'din-settings-group' ); ?>
    <table class="form-table">
         
        <tr valign="top">
        <th scope="row">Tag Name</th>
        <td><input type="text" name="din_tag_name" value="<?php echo get_option('din_tag_name'); ?>" /></td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>