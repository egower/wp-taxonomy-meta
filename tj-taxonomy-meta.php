<?php
/*
Plugin Name: TJ Taxonomy Meta 
Plugin URI:  http://techjunkie.com
Description: Plugin to allow addition of additional taxonomy meta information
Author: Evan Gower
Version: 1.00
Author URI: http://techjunkie.com/
License: GPL
*/

add_action('category_edit_form_fields','taxonomy_meta_form_fields');
add_action('edited_category', 'taxonomy_meta_form');

//add_action('TAXONOMYNAME_edit_form_fields','pgoa_category_edit_form_fields');
//add_action('edited_TAXONOMYNAME', 'pgoa_category_edit_form');

//commented out above is an example of how this can be used in place of the default category
//simply replace TAXONOMYNAME with the slug of your taxonomy

function taxonomy_meta_form() {
  if ( !current_user_can( 'manage_options' ) )
    return;

  if($_POST['extra_title']){
    $extra_title = sanitize_text_field($_POST['extra_title']);
    $extra_titles = get_option('extra_taxonomy_titles');
    $extra_titles = unserialize($extra_titles);

    $cat_ID = (int)$_POST['tag_ID'];
    
    $extra_titles[$cat_ID] = $extra_title;

    update_option('extra_taxonomy_titles', $extra_titles);
  }
}

function taxonomy_meta_form_fields ($tag) {
  $cat_ID = $tag->term_id;
  $extra_titles = get_option('extra_taxonomy_titles');
  $extra_title = $extra_titles[$cat_ID];
  ?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="extra_title"><?php _e('Extra Title', ''); ?></label>
            </th>
            <td>
                <input type="text" name="extra_title" size="100" value="<?php echo $extra_title; ?>">
            </td>
        </tr>
  <?php 
}
?>
