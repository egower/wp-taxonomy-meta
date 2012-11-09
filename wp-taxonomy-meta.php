<?php
/*
Plugin Name: Taxonomy Meta 
Plugin URI:  http://techjunkie.com
Description: Plugin to allow addition of additional taxonomy meta information
Author: Evan Gower
Version: 1.00
Author URI: http://techjunkie.com/
License: GPL
*/

add_action('category_edit_form_fields','taxonomy_meta_form_fields');
add_action('edited_category', 'taxonomy_meta_form');

function taxonomy_meta_form() {
  if ( !current_user_can( 'manage_options' ) )
    return;

  if($_POST['seotitle']){
    $seo_title = sanitize_text_field($_POST['seotitle']);
    $seo_titles = get_option('seo_taxonomy_titles');
    echo $seo_titles;
    $seo_titles = unserialize($seo_titles);

    $cat_ID = (int)$_POST['tag_ID'];
    
    $seo_titles[$cat_ID] = $seo_title;

    update_option('seo_taxonomy_titles', $seo_titles);
  }
}

function taxonomy_meta_form_fields ($tag) {
  $cat_ID = $tag->term_id;
  $seo_titles = get_option('seo_taxonomy_titles');
  $seo_title = $seo_titles[$cat_ID];
?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="seotitle"><?php _e('SEO Title', ''); ?></label>
            </th>
            <td>
                <input type="text" name="seotitle" size="100" value="<?php echo $seo_title; ?>">
            </td>
        </tr>
<?php 
}
?>
